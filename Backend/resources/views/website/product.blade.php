<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubicon Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white font-sans">
    <div class="min-h-screen px-10 py-10">
        <h1 class="text-4xl font-bold mb-10">Rubicon Solution</h1>
        <p class="text-gray-400 max-w-2xl mb-10">
            A complete hardware + software ecosystem for modern vending infrastructure.
        </p>

        <section class="max-w-4xl">
            <h2 class="text-2xl font-semibold">Overview</h2>
            <p class="text-gray-400 mt-4">
                Rubicon is a hardware and software solution designed to modernize vending machines...
            </p>
        </section>

        <section class="mt-16 grid md:grid-cols-2 gap-10">
            <div>
                <h2 class="text-2xl font-semibold">Hardware Module</h2>
                <ul class="mt-4 space-y-3 text-gray-400">
                    <li>✔️ Plug-and-play integration</li>
                    <li>✔️ QR code display support</li>
                    <li>✔️ Secure payment processing</li>
                    <li>✔️ Low power consumption</li>
                </ul>
            </div>
            <div class="bg-gray-900 rounded-2xl p-6">
                <p class="text-gray-400">
                    The module connects directly to the vending machine controller...
                </p>
            </div>
        </section>

        <section class="mt-16 grid md:grid-cols-2 gap-10">
            <div class="bg-gray-900 rounded-2xl p-6">
                <p class="text-gray-400">
                    The Rubicon app provides real-time monitoring and analytics...
                </p>
            </div>
            <div>
                <h2 class="text-2xl font-semibold">Software Platform</h2>
                <ul class="mt-4 space-y-3 text-gray-400">
                    <li>✔️ Real-time transaction tracking</li>
                    <li>✔️ Device status monitoring</li>
                    <li>✔️ Notifications & alerts</li>
                    <li>✔️ Cloud-based access</li>
                </ul>
            </div>
        </section>

        <button 
            onclick="window.location.href='{{ url('/rubicon') }}'"
            class="mt-16 px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-xl transition">
            ← Back
        </button>
    </div>
</body>
</html>