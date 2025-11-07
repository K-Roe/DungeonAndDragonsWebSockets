<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import axios from "axios";
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
async function resendEmail() {
  console.log(email.value)
  try {
    await ensureCsrf();
    await axios.post('/api/resend-verification', { email: email.value }, { withCredentials: true });
    message.value = '✅ Verification email resent!';
  } catch (err) {
    message.value = err.response?.data?.message || '❌ Failed to resend email';
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
        <div class="h-16 w-16 flex items-center justify-center rounded-full bg-green-100">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-8 w-8 text-green-600"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 12H8m0 0l4-4m-4 4l4 4m0-4h8" />
          </svg>
        </div>
      </div>

      <!-- Title -->
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
        Verify Your Email
      </h1>

      <!-- Message -->
      <p class="text-gray-600 mb-6">
        We’ve sent a confirmation link to your email
        <span v-if="email" class="font-semibold text-gray-900">{{ email }}</span>.
        Please check your inbox and click the link to activate your account.
      </p>

      <!-- CTA -->
      <div class="space-y-4">
        <button
            type="button"
            @click="resendEmail"
            class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 transition rounded-lg font-semibold text-white shadow"
        >
          Resend Verification Email
        </button>

        <p v-if="message" class="mt-3 text-sm text-center text-green-600 font-medium">
          {{ message }}
        </p>

        <p class="text-sm text-gray-500">
          Didn’t get the email? Check your spam folder or click “Resend Verification Email”.
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
* {
  font-family: 'Inter', sans-serif;
}
</style>
