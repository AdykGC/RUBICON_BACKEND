<template>
  <div class="bg-black text-white min-h-screen px-10 py-10">

    <!-- TITLE -->
    <h1 class="text-4xl font-bold mb-10">
      Rubicon Solution
    </h1>

    <p class="text-gray-400 max-w-2xl mb-10">
      A complete hardware + software ecosystem for modern vending infrastructure.
    </p>

    <!-- OVERVIEW -->
    <section class="max-w-4xl">
      <h2 class="text-2xl font-semibold">Overview</h2>
      <p class="text-gray-400 mt-4">
        Rubicon is a hardware and software solution designed to modernize vending machines.
        It enables secure QR-based payments via Kaspi and provides full remote monitoring.
      </p>
    </section>

    <!-- HARDWARE -->
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
          The module connects directly to the vending machine controller,
          enabling communication between the payment system and the machine.
        </p>
      </div>
    </section>

    <!-- SOFTWARE -->
    <section class="mt-16 grid md:grid-cols-2 gap-10">
      <div class="bg-gray-900 rounded-2xl p-6">
        <p class="text-gray-400">
          The Rubicon app provides real-time monitoring and analytics,
          helping you manage machines efficiently.
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

    <!-- USE CASE -->
    <section class="mt-16">
      <h2 class="text-2xl font-semibold">Use Case</h2>

      <div class="grid md:grid-cols-3 gap-6 mt-6">

        <div class="bg-gray-900 p-6 rounded-2xl">
          <h3 class="font-semibold">Install</h3>
          <p class="text-gray-400 mt-2">
            Connect the Rubicon module to your vending machine
          </p>
        </div>

        <div class="bg-gray-900 p-6 rounded-2xl">
          <h3 class="font-semibold">Pay</h3>
          <p class="text-gray-400 mt-2">
            Customer scans QR and completes payment
          </p>
        </div>

        <div class="bg-gray-900 p-6 rounded-2xl">
          <h3 class="font-semibold">Manage</h3>
          <p class="text-gray-400 mt-2">
            Monitor and control via app
          </p>
        </div>

      </div>
    </section>

    <!-- BACK -->
    <button @click="goBack" class="mt-16 px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-xl" >
      ← Back
    </button>

  </div>
</template>
<script setup>
const goBack = () => {
  window.location.href = '/rubicon'
}
</script>