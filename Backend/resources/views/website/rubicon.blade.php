@extends('layouts.app')

@section('title', 'Rubicon | Smart Vending Payments')

@section('content')
    <section class="flex flex-col items-center text-center pt-20 pb-10 px-6">
        <h2 class="text-4xl md:text-6xl font-bold leading-tight max-w-4xl">
            Smart Payments for <span class="text-green-400">Vending Machines</span>
        </h2>

        <p class="text-gray-300 mt-6 max-w-2xl text-lg leading-relaxed">
            Rubicon transforms traditional vending machines into smart, cashless systems powered by Kaspi QR,
            real-time analytics, and remote control.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <button onclick="goToPayment()" class="px-7 py-3 bg-green-500 hover:bg-green-600 text-black font-bold rounded-xl transition transform active:scale-95">
                Get Started
            </button>
            <button onclick="downloadAPK()" class="px-7 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-xl transition flex items-center gap-2">
                <span>🤖</span> Download APK
            </button>
            <a href="{{ url('/product') }}" class="px-7 py-3 border border-gray-600 hover:bg-gray-800 rounded-xl transition">
                Learn More
            </a>
        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl w-full">
            <div class="bg-gray-900/50 border border-gray-700 rounded-xl p-6 backdrop-blur-sm">
                <h3 class="text-3xl font-bold text-green-400">+35%</h3>
                <p class="text-gray-300 text-sm">Revenue Growth</p>
            </div>
            <div class="bg-gray-900/50 border border-gray-700 rounded-xl p-6 backdrop-blur-sm">
                <h3 class="text-3xl font-bold text-green-400">24/7</h3>
                <p class="text-gray-300 text-sm">Monitoring</p>
            </div>
            <div class="bg-gray-900/50 border border-gray-700 rounded-xl p-6 backdrop-blur-sm">
                <h3 class="text-3xl font-bold text-green-400">100%</h3>
                <p class="text-gray-300 text-sm">Cashless</p>
            </div>
        </div>
    </section>

    <section class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold">Stop Losing Customers</h2>
                <p class="text-gray-400 mt-4">Traditional payment systems are holding your business back</p>
            </div>
            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-red-500/10 border border-red-500/20 p-8 rounded-3xl">
                    <h4 class="text-red-400 text-xl font-bold mb-4">Old Approach</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li>• Manual cash collection and counting</li>
                        <li>• Bill validators often get jammed</li>
                        <li>• Lost sales when customers have no change</li>
                        <li>• No real-time data on stock or sales</li>
                    </ul>
                </div>
                <div class="bg-green-500/10 border border-green-500/20 p-8 rounded-3xl">
                    <h4 class="text-green-400 text-xl font-bold mb-4">With Rubicon</h4>
                    <ul class="space-y-3 text-gray-200">
                        <li>• Funds settle directly to your account</li>
                        <li>• Zero physical wear on hardware</li>
                        <li>• Kaspi QR is available to everyone</li>
                        <li>• Full control via cloud dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 px-6">
        <div class="max-w-5xl mx-auto bg-gray-900/50 border border-gray-700 rounded-2xl p-8 md:p-16 text-center backdrop-blur-sm">
            <h3 class="text-3xl font-bold">What is Rubicon?</h3>
            <p class="text-gray-300 mt-6 text-lg leading-relaxed">
                Rubicon is a next-generation vending infrastructure platform that upgrades traditional machines
                into intelligent, cashless systems without replacing existing hardware.
            </p>
            <p class="text-gray-400 mt-4 text-sm">
                A hardware module combined with a cloud platform for full control, monitoring, and scalability.
            </p>
        </div>
    </section>

    <section id="features" class="py-20 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900/50 border border-gray-700 p-8 rounded-2xl hover:border-green-500 transition-all duration-300">
                <div class="text-3xl mb-4">💳</div>
                <h3 class="text-xl font-semibold">Instant Payments</h3>
                <p class="text-gray-400 mt-2">Kaspi QR payments with zero delay and automatic confirmation.</p>
            </div>
            <div class="bg-gray-900/50 border border-gray-700 p-8 rounded-2xl hover:border-green-500 transition-all duration-300">
                <div class="text-3xl mb-4">📊</div>
                <h3 class="text-xl font-semibold">Live Analytics</h3>
                <p class="text-gray-400 mt-2">Track revenue, inventory levels, and machine health in real-time.</p>
            </div>
            <div class="bg-gray-900/50 border border-gray-700 p-8 rounded-2xl hover:border-green-500 transition-all duration-300">
                <div class="text-3xl mb-4">⚙️</div>
                <h3 class="text-xl font-semibold">Remote Control</h3>
                <p class="text-gray-400 mt-2">Reboot, update prices, and manage devices from your smartphone.</p>
            </div>
        </div>
    </section>

    <section id="how" class="py-20 px-6 text-center">
        <h3 class="text-3xl font-bold">How It Works</h3>
        <p class="text-gray-300 mt-4 max-w-xl mx-auto">Upgrade your vending business in simple steps</p>

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="relative p-8">
                <div class="text-5xl mb-4">🔌</div>
                <h4 class="text-lg font-semibold">1. Install</h4>
                <p class="text-gray-400 mt-2 text-sm">Plug the Rubicon module into your machine's MDB port.</p>
            </div>
            <div class="relative p-8">
                <div class="text-5xl mb-4">📱</div>
                <h4 class="text-lg font-semibold">2. Pay</h4>
                <p class="text-gray-400 mt-2 text-sm">Customers scan the QR code and pay via their banking app.</p>
            </div>
            <div class="relative p-8">
                <div class="text-5xl mb-4">📈</div>
                <h4 class="text-lg font-semibold">3. Manage</h4>
                <p class="text-gray-400 mt-2 text-sm">Monitor sales and manage stock via the cloud dashboard.</p>
            </div>
        </div>
    </section>

    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center bg-green-500 text-black rounded-3xl p-10 md:p-16">
            <h3 class="text-3xl md:text-4xl font-bold">Ready to modernize?</h3>
            <p class="mt-4 text-black/80 font-medium max-w-xl mx-auto">
                Join the cashless revolution and increase your vending revenue today.
            </p>
            <button onclick="goToPayment()" class="mt-8 px-10 py-4 bg-black text-white hover:bg-gray-900 rounded-xl font-bold transition transform active:scale-95">
                Get Started Now
            </button>
        </div>
    </section>
@endsection