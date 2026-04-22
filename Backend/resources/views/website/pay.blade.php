<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пополнение баланса | Rubicon</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.2);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
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
        <h1 class="text-2xl font-bold">Пополнение баланса</h1>
        <p class="text-gray-400 text-sm mt-2">
            Автомат: 
            <span id="machine-display" class="text-green-400 font-mono">
                {{ $machineId ?? 'RUB-795211' }}
            </span>
        </p>
    </div>

    <div class="bg-gray-800/40 border border-gray-700/50 rounded-2xl p-5 mb-6 flex justify-between items-center">
        <div>
            <p class="text-xs text-gray-400 uppercase">Ваш баланс</p>
            <p class="text-2xl font-bold mt-1">0 <span class="text-sm text-gray-400">тг</span></p>
        </div>
        <div class="h-10 w-10 bg-green-500/20 rounded-full flex items-center justify-center text-green-400 text-xl">
            💳
        </div>
    </div>

    <div class="mb-6">
        <label class="text-xs text-gray-400 uppercase mb-3 block">Сумма к оплате</label>
        <div class="relative">
            <input 
                id="amount-input"
                type="number" 
                placeholder="0.00" 
                class="w-full bg-gray-800/60 border border-gray-700 rounded-2xl py-4 px-6 text-2xl font-bold focus:outline-none focus:border-green-500/50 text-white"
            />
            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500">₸</span>
        </div>
    </div>

    <div id="presets-container" class="grid grid-cols-4 gap-3 mb-8"></div>

    <button 
        id="pay-button"
        onclick="processPayment()"
        disabled
        class="w-full py-4 bg-green-500 hover:bg-green-600 disabled:bg-gray-800 disabled:text-gray-600 text-black font-bold rounded-2xl transition flex justify-center items-center gap-2"
    >
        <span id="btn-text">Оплатить через Kaspi QR</span>
        <div id="btn-loader" class="hidden loading-spinner"></div>
    </button>

</div>

<script>
    const amountInput = document.getElementById('amount-input');
    const payButton = document.getElementById('pay-button');
    const presetsContainer = document.getElementById('presets-container');
    const btnText = document.getElementById('btn-text');
    const btnLoader = document.getElementById('btn-loader');

    let machineId = @json($machineId ?? 'RUB-795211');

    const presets = [5, 10, 15, 20, 50, 100, 150, 200];

    window.onload = () => {
        renderPresets();
    };

    function renderPresets() {
        presetsContainer.innerHTML = presets.map(val => `
            <button onclick="setAmount(${val})"
                class="preset-btn py-3 rounded-xl border border-gray-700 bg-gray-800/40 text-gray-300">
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
    }

    function processPayment() {
        const amount = amountInput.value;

        btnText.classList.add('hidden');
        btnLoader.classList.remove('hidden');
        payButton.disabled = true;

        setTimeout(() => {
            btnText.classList.remove('hidden');
            btnLoader.classList.add('hidden');
            payButton.disabled = false;

            alert(`Оплата ${amount} ₸ → ${machineId}`);
        }, 1500);
    }
</script>

</body>
</html>