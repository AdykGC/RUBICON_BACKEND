<template>
  <div class="min-h-screen bg-black text-white font-sans relative overflow-hidden flex items-center justify-center p-6">
    
    <div class="fixed inset-0 z-0">
      <div class="absolute top-[-10%] left-[-10%] w-[400px] h-[400px] bg-green-500/10 rounded-full blur-[100px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-blue-500/5 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md bg-gray-900/40 border border-gray-800 backdrop-blur-xl rounded-3xl p-8 shadow-2xl">
      
      <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold tracking-tight">Пополнение баланса</h1>
        <p class="text-gray-400 text-sm mt-2">Автомат: <span class="text-green-400 font-mono">{{ machineId || 'RUB-795211' }}</span></p>
      </div>

      <div class="bg-gray-800/40 border border-gray-700/50 rounded-2xl p-5 mb-6 flex justify-between items-center">
        <div>
          <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Ваш баланс</p>
          <p class="text-2xl font-bold mt-1">0 <span class="text-sm font-normal text-gray-400">тг</span></p>
        </div>
        <div class="h-10 w-10 bg-green-500/20 rounded-full flex items-center justify-center text-green-400">
          💳
        </div>
      </div>

      <div class="mb-6">
        <label class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-3 block">Сумма к оплате</label>
        <div class="relative">
          <input 
            v-model="amount" 
            type="number" 
            placeholder="0.00" 
            class="w-full bg-gray-800/60 border border-gray-700 rounded-2xl py-4 px-6 text-2xl font-bold focus:outline-none focus:border-green-500/50 transition-all text-white placeholder-gray-600"
          />
          <span class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 font-bold">₸</span>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3 mb-8">
        <button 
          v-for="val in presets" 
          :key="val" 
          @click="amount = val"
          class="py-3 px-4 rounded-xl border transition-all duration-200 font-medium"
          :class="amount === val 
            ? 'bg-green-500 border-green-500 text-black shadow-[0_0_15px_rgba(34,197,94,0.4)]' 
            : 'bg-gray-800/40 border-gray-700 text-gray-300 hover:border-gray-500'"
        >
          {{ val.toLocaleString() }} ₸
        </button>
      </div>

      <button 
        @click="processPayment" 
        :disabled="!amount || loading"
        class="w-full py-4 bg-green-500 hover:bg-green-600 disabled:bg-gray-800 disabled:text-gray-600 text-black font-bold rounded-2xl transition-all duration-300 transform active:scale-[0.98] shadow-lg shadow-green-500/20 relative overflow-hidden"
      >
        <span v-if="!loading" class="flex items-center justify-center gap-2">
          Оплатить через <span class="font-extrabold uppercase tracking-tighter">Kaspi QR</span>
        </span>
        <div v-else class="flex justify-center items-center">
          <div class="w-6 h-6 border-2 border-black/30 border-t-black rounded-full animate-spin"></div>
        </div>
      </button>

      <p class="text-center text-[10px] text-gray-500 mt-6 uppercase tracking-widest">
        Powered by <span class="text-gray-300 font-bold">Rubicon IoT</span>
      </p>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-gray-600 text-xs">
      Secure end-to-end encryption
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';


const machineId = ref('');
const amount = ref(null);
const loading = ref(false);
const presets = [5, 10, 15, 20, 50, 100, 150, 200];

onMounted(() => {
  const params = new URLSearchParams(window.location.search);
  machineId.value = params.get('id') || 'RUB-795211';
});

const processPayment = async () => {
  loading.value = true;
  
  // Эмуляция задержки запроса к Spring Boot
  setTimeout(() => {
    loading.value = false;
    alert(`Симуляция: Запрос на ${amount.value} ₸ отправлен на автомат ${machineId.value}`);
  }, 2000);
};
</script>

<style scoped>
/* Убираем стрелочки у input number */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>