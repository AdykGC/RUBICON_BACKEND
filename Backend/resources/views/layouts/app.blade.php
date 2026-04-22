<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rubicon | Smart Vending Payments')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { scroll-behavior: smooth; }
        body { background-color: black; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
    </style>
    @stack('styles')
</head>
<body class="bg-black text-white font-sans relative overflow-y-auto">

    <div class="fixed inset-0 bg-black z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-green-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10">
        <header class="flex justify-between items-center px-6 md:px-10 py-6 border-b border-gray-800 bg-black/50 backdrop-blur-md sticky top-0">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-wide hover:text-green-400 transition">Rubicon</a>
            <nav class="hidden md:flex space-x-6 text-gray-300 text-sm">
                @if(Route::currentRouteName() === 'home')
                    <a href="#about" class="hover:text-white transition">Product</a>
                    <a href="#features" class="hover:text-white transition">Features</a>
                    <a href="#how" class="hover:text-white transition">How it works</a>
                @else
                    <a href="{{ url('/#about') }}" class="hover:text-white transition">Product</a>
                    <a href="{{ url('/#features') }}" class="hover:text-white transition">Features</a>
                    <a href="{{ url('/#how') }}" class="hover:text-white transition">How it works</a>
                @endif
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="border-t border-gray-800 px-6 md:px-10 py-10 text-gray-400 text-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <p>© 2026 Rubicon Inc. All rights reserved.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <a href="#" class="hover:text-white transition">Contact</a>
            </div>
        </footer>
    </div>

    <script>
        function goToPayment() {
            window.location.href = '{{ url("/pay?id=RUB-001") }}';
        }

        function downloadAPK() {
            const link = document.createElement('a');
            link.href = '{{ asset("app-rubicon-release.apk") }}';
            link.download = 'Rubicon_Vending.apk';
            link.click();
        }
    </script>
    @stack('scripts')
</body>
</html>