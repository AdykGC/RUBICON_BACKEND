@extends('layouts.app')

@section('title', 'Rubicon Solution')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16 md:py-20">
    <h1 class="text-4xl md:text-5xl font-bold mb-6">Rubicon Solution</h1>
    <p class="text-gray-400 text-lg max-w-2xl mb-12">
        A complete hardware + software ecosystem for modern vending infrastructure.
    </p>

    <section class="mb-16">
        <h2 class="text-2xl font-semibold border-l-4 border-green-500 pl-4">Overview</h2>
        <p class="text-gray-300 mt-4 leading-relaxed">
            Rubicon is a hardware and software solution designed to modernize vending machines,
            enabling cashless payments, real‑time monitoring, and remote management without replacing existing equipment.
        </p>
    </section>

    <div class="grid md:grid-cols-2 gap-12 mb-16">
        <div>
            <h2 class="text-2xl font-semibold">Hardware Module</h2>
            <ul class="mt-5 space-y-3 text-gray-300">
                <li class="flex items-center gap-2">✔️ Plug-and-play integration</li>
                <li class="flex items-center gap-2">✔️ QR code display support</li>
                <li class="flex items-center gap-2">✔️ Secure payment processing</li>
                <li class="flex items-center gap-2">✔️ Low power consumption</li>
            </ul>
        </div>
        <div class="bg-gray-900/60 border border-gray-700 rounded-2xl p-6 backdrop-blur-sm">
            <p class="text-gray-300 leading-relaxed">
                The module connects directly to the vending machine controller via the MDB port,
                intercepts payment signals, and communicates with the Rubicon cloud platform.
                No firmware changes required.
            </p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-12">
        <div class="bg-gray-900/60 border border-gray-700 rounded-2xl p-6 backdrop-blur-sm order-2 md:order-1">
            <p class="text-gray-300 leading-relaxed">
                The Rubicon app provides real-time monitoring and analytics – from transaction history
                to stock levels. Receive instant alerts when a machine is offline or needs maintenance.
            </p>
        </div>
        <div class="order-1 md:order-2">
            <h2 class="text-2xl font-semibold">Software Platform</h2>
            <ul class="mt-5 space-y-3 text-gray-300">
                <li class="flex items-center gap-2">✔️ Real-time transaction tracking</li>
                <li class="flex items-center gap-2">✔️ Device status monitoring</li>
                <li class="flex items-center gap-2">✔️ Notifications & alerts</li>
                <li class="flex items-center gap-2">✔️ Cloud-based access</li>
            </ul>
        </div>
    </div>

    <div class="mt-16">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-xl transition text-gray-200">
            ← Back to Home
        </a>
    </div>
</div>
@endsection