<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
// import logo from '../../assets/MerlinForAllLogo.png'

const router = useRouter();
const message = ref("Email verified successfully! You can now log in.");

function goToLogin() {
  router.push('/login');
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:px-6 md:px-10">
    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-md w-full max-w-md border border-gray-200 text-center">
      <div class="flex justify-center mb-6">
<!--        <img :src="logo" alt="Merlin for All Logo" class="h-20 w-auto"/>-->
      </div>
      <!-- Icon -->
      <div class="flex justify-center mb-6">
        <div class="h-16 w-16 flex items-center justify-center rounded-full bg-green-100">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-8 w-8 text-green-600"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>


      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
        Email Verified
      </h1>

      <p class="text-gray-600 mb-6">
        {{ message }}
      </p>

      <button
          @click="goToLogin"
          class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 transition rounded-lg font-semibold text-white shadow"
      >
        Go to Login
      </button>

    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
* {
  font-family: 'Inter', sans-serif;
}
</style>
