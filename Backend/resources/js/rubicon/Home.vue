<template>
  <div class="bg-black text-white min-h-screen font-sans relative overflow-y-auto">
    
    <div class="fixed inset-0 bg-black z-0">
      <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-green-500/10 rounded-full blur-[120px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10">
      
      <header class="flex justify-between items-center px-6 md:px-10 py-6 border-b border-gray-800 bg-black/50 backdrop-blur-md sticky top-0">
        <h1 class="text-xl font-bold tracking-wide">Rubicon</h1>
        <nav class="hidden md:flex space-x-6 text-gray-300 text-sm">
          <a href="#about" class="hover:text-white transition">Product</a>
          <a href="#features" class="hover:text-white transition">Features</a>
          <a href="#how" class="hover:text-white transition">How it works</a>
        </nav>
      </header>

      <section class="flex flex-col items-center text-center pt-20 pb-10 px-6">
        <h2 class="text-4xl md:text-6xl font-bold leading-tight max-w-4xl">
          Smart Payments for <span class="text-green-400">Vending Machines</span>
        </h2>

        <p class="text-gray-300 mt-6 max-w-2xl text-lg leading-relaxed">
          Rubicon transforms traditional vending machines into smart, cashless systems powered by Kaspi QR,
          real-time analytics, and remote control.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
          <button 
            @click="goToPayment" 
            class="px-7 py-3 bg-green-500 hover:bg-green-600 text-black font-bold rounded-xl transition">
            Get Started
          </button>
          <button 
            @click="downloadAPK"
            class="px-7 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-xl transition flex items-center gap-2">
            <span>🤖</span> Download APK
          </button>
          <button
            @click="$router.push('/product')"
            class="px-7 py-3 border border-gray-600 hover:bg-gray-800 rounded-xl transition">
            Learn More
          </button>
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
        <div class="max-w-3xl mx-auto">
          <h3 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h3>
          <div class="space-y-6">
            <div class="border-b border-gray-800 pb-6">
              <h4 class="text-lg font-medium text-green-400">Which machines are compatible?</h4>
              <p class="text-gray-400 mt-2">Our module works with all modern machines supporting the MDB protocol, including coffee machines, snack vendors, and self-service car washes.</p>
            </div>
            <div class="border-b border-gray-800 pb-6">
              <h4 class="text-lg font-medium text-green-400">How do Kaspi QR fees work?</h4>
              <p class="text-gray-400 mt-2">We integrate with your Kaspi Pay business account. You only pay the standard bank commission with no hidden transaction fees from our side.</p>
            </div>
            <div class="border-b border-gray-800 pb-6">
              <h4 class="text-lg font-medium text-green-400">Do I need a constant internet connection?</h4>
              <p class="text-gray-400 mt-2">Yes, the module includes a built-in SIM slot to ensure 24/7 connectivity for processing payments and sending analytics.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center bg-green-500 text-black rounded-3xl p-10 md:p-16">
          <h3 class="text-3xl md:text-4xl font-bold">Ready to modernize?</h3>
          <p class="mt-4 text-black/80 font-medium max-w-xl mx-auto">
            Join the cashless revolution and increase your vending revenue today.
          </p>
          <button 
            @click="goToPayment" 
            class="mt-8 px-10 py-4 bg-black text-white hover:bg-gray-900 rounded-xl font-bold transition">
            Get Started Now
          </button>
        </div>
      </section>

      <footer class="border-t border-gray-800 px-6 md:px-10 py-10 text-gray-400 text-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <p>© 2026 Rubicon Inc. All rights reserved.</p>
        <div class="flex gap-8">
          <a href="#" class="hover:text-white transition">Privacy Policy</a>
          <a href="#" class="hover:text-white transition">Terms of Service</a>
          <a href="#" class="hover:text-white transition">Contact</a>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
// Функция для перехода на страницу оплаты
const goToPayment = (id = 'RUB-001') => {
  window.location.href = `/pay?id=${id}`
}

// Функция для скачивания APK
const downloadAPK = () => {
  const link = document.createElement('a');
  // Убедись, что файл лежит в папке public под этим именем
  link.href = '/app-rubicon-release.apk'; 
  link.download = 'Rubicon_Vending.apk';
  link.click();
};
</script>