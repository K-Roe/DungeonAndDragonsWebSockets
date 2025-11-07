<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
// import logo from '../../assets/MerlinForAllLogo.png'

const route = useRoute();
const email = ref(route.query.email || '');
const message = ref('');

const csrfFetched = ref(false)
async function ensureCsrf() {
  if (!csrfFetched.value) {
    await axios.get('/sanctum/csrf-cookie', { withCredentials: true })
    csrfFetched.value = true
  }
}
async function resendEmail(email) {
  if (!email.value) return;

  try {
    await ensureCsrf();
    const response = await axios.post('/api/resend-verification', { email: email.value }, { withCredentials: true });
    message.value = response.data.message || 'Verification email resent!';
  } catch (err) {
    message.value = err.response?.data?.message || 'Failed to resend email.';
  }
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
        <div class="h-16 w-16 flex items-center justify-center rounded-full bg-red-100">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-8 w-8 text-red-600"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </div>

      <!-- Title -->
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
        Verification Failed
      </h1>

      <!-- Message -->
      <p class="text-gray-600 mb-6">
        The verification link is invalid or has expired. Please try again or request a new verification email.
      </p>

      <!-- Buttons -->
      <div class="space-y-3">
        <button
            @click="resendEmail"
            class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 transition rounded-lg font-semibold text-white shadow"
        >
          Resend Verification Email
        </button>
      </div>
      <p v-if="message" class="text-center text-gray-700 mt-4">{{ message }}</p>

    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
* {
  font-family: 'Inter', sans-serif;
}
</style>
