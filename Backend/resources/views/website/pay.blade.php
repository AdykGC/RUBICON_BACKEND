<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пополнение баланса | Rubicon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-top-color: black;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .toast {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-black text-white font-sans relative overflow-hidden flex items-center justify-center min-h-screen p-6">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[400px] h-[400px] bg-green-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-blue-500/5 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md bg-gray-900/40 border border-gray-800 backdrop-blur-xl rounded-3xl p-8 shadow-2xl">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight">Пополнение баланса</h1>
            <p class="text-gray-400 text-sm mt-2">
                Автомат: <span id="machine-display" class="text-green-400 font-mono">{{ $machineId }}</span>
            </p>
        </div>

        <div class="bg-gray-800/40 border border-gray-700/50 rounded-2xl p-5 mb-6 flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Баланс автомата</p>
                <p class="text-2xl font-bold mt-1">
                    <span id="current-balance">0</span>
                    <span class="text-sm font-normal text-gray-400">тг</span>
                </p>
            </div>
            <div class="h-10 w-10 bg-green-500/20 rounded-full flex items-center justify-center text-green-400 text-xl">
                💳
            </div>
        </div>

        <div class="mb-6">
            <label class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-3 block">Сумма пополнения</label>
            <div class="relative">
                <input
                    id="amount-input"
                    type="number"
                    placeholder="0.00"
                    class="w-full bg-gray-800/60 border border-gray-700 rounded-2xl py-4 px-6 text-2xl font-bold focus:outline-none focus:border-green-500/50 transition-all text-white placeholder-gray-600" />
                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 font-bold">₸</span>
            </div>
        </div>

        <div id="presets-container" class="grid grid-cols-4 gap-3 mb-8"></div>

        <button
            id="pay-button"
            onclick="processPayment()"
            disabled
            class="w-full py-4 bg-green-500 hover:bg-green-600 disabled:bg-gray-800 disabled:text-gray-600 text-black font-bold rounded-2xl transition-all duration-300 transform active:scale-[0.98] shadow-lg shadow-green-500/20 relative flex justify-center items-center gap-2">
            <span id="btn-text">Оплатить через <span class="font-extrabold uppercase tracking-tighter">Kaspi QR</span></span>
            <div id="btn-loader" class="hidden loading-spinner"></div>
        </button>

        <p class="text-center text-[10px] text-gray-500 mt-6 uppercase tracking-widest">
            Powered by <span class="text-gray-300 font-bold">Rubicon IoT</span>
        </p>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-gray-600 text-xs">
        Secure end-to-end encryption
    </div>

    <script>
        const amountInput = document.getElementById('amount-input');
        const payButton = document.getElementById('pay-button');
        const machineDisplay = document.getElementById('machine-display');
        const presetsContainer = document.getElementById('presets-container');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');
        const balanceSpan = document.getElementById('current-balance');

        const presets = [5, 10, 15, 20, 50, 100, 150, 200];
        let machineId = '{{ $machineId }}';
        let currentBalance = 0;

        // Загрузка баланса (опционально, если всё равно хотите показывать)
        async function fetchBalance() {
            try {
                const response = await fetch(`/machine/balance/${machineId}`);
                if (response.ok) {
                    const data = await response.json();
                    currentBalance = data.balance;
                    balanceSpan.innerText = currentBalance.toFixed(2);
                } else {
                    console.error('Ошибка загрузки баланса');
                }
            } catch (error) {
                console.error('Ошибка сети:', error);
            }
        }

        window.onload = () => {
            machineDisplay.innerText = machineId;
            renderPresets();
            fetchBalance(); // можно оставить, но баланс будет увеличиваться, если сервер его увеличивает
        };

        function renderPresets() {
            presetsContainer.innerHTML = presets.map(val => `
            <button 
                onclick="setAmount(${val})"
                class="preset-btn py-3 px-2 rounded-xl border border-gray-700 bg-gray-800/40 text-gray-300 hover:border-gray-500 transition-all text-sm font-medium"
                data-value="${val}"
            >
                ${val} ₸
            </button>
        `).join('');
        }

        function setAmount(val) {
            amountInput.value = val;
            updateUI();
        }

        amountInput.addEventListener('input', updateUI);

        function updateUI() {
            const val = parseInt(amountInput.value);
            payButton.disabled = !val || val <= 0;

            document.querySelectorAll('.preset-btn').forEach(btn => {
                if (parseInt(btn.dataset.value) === val) {
                    btn.classList.add('bg-green-500', 'border-green-500', 'text-black', 'shadow-[0_0_15px_rgba(34,197,94,0.4)]');
                    btn.classList.remove('bg-gray-800/40', 'text-gray-300');
                } else {
                    btn.classList.remove('bg-green-500', 'border-green-500', 'text-black', 'shadow-[0_0_15px_rgba(34,197,94,0.4)]');
                    btn.classList.add('bg-gray-800/40', 'text-gray-300');
                }
            });
        }

        async function processPayment() {
            const amount = amountInput.value;
            if (!amount || amount <= 0) return;

            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            payButton.disabled = true;

            try {
                const response = await fetch('/machine/topup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        mac_address: machineId,
                        amount: amount
                    })
                });

                const data = await response.json();

                // Проверяем успешность по полю status === 'sent'
                if (response.ok && data.status === 'sent') {
                    const pulses = data.pulses || Math.floor(amount / 5);
                    alert(`✅ Оплата на ${amount} ₸ принята! Выдано ${pulses} порций.`);
                    amountInput.value = '';
                    updateUI();
                    // Баланс не обновляем – сумма сгорела, либо сервер сам увеличил баланс (если вы оставили increment)
                    // Для синхронизации можно перезапросить баланс:
                    await fetchBalance();
                } else {
                    alert(`❌ Ошибка: ${data.error || 'Не удалось обработать платеж'}`);
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('❌ Произошла ошибка соединения. Попробуйте позже.');
            } finally {
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
                payButton.disabled = false;
            }
        }
    </script>
</body>

</html>