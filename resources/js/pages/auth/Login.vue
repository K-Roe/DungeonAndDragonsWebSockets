<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth.js';
// import logo from '../../assets/dnd_logo.png'; // swap this with your D&D logo

const email = ref('');
const password = ref('');
const error = ref('');
const success = ref('');
const router = useRouter();
const authStore = useAuthStore();

async function login() {
  try {
    await authStore.login({
      email: email.value,
      password: password.value
    });
    router.push('/dashboard');
  } catch (err) {
    error.value = err;
  }
}

async function resendActivation() {
  if (!email.value) {
    error.value = 'Please inscribe your email before sending a new scroll.';
    success.value = '';
    return;
  }

  try {
    success.value = await authStore.resendVerification(email.value);
    error.value = '';
  } catch (err) {
    error.value = err;
    success.value = '';
  }
}

</script>

<template>
  <div
      class="min-h-screen flex items-center justify-center bg-gradient-to-b from-amber-100 to-amber-200 px-4 sm:px-6 md:px-10">
    <div
        class="bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-4 border-yellow-900 p-6 sm:p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md">
      <div class="flex justify-center mb-6">
<!--        <img :src="logo" alt="D&D Logo" class="h-20 w-auto drop-shadow-md"/>-->
      </div>

      <h1 class="text-3xl sm:text-4xl font-extrabold text-center mb-6 text-red-800 tracking-wide drop-shadow-md">
        Enter the Realm
      </h1>

      <form class="space-y-4 sm:space-y-5" @submit.prevent="login">
        <div>
          <label class="block mb-1 font-semibold text-yellow-900" for="email">Scroll of Contact (Email)</label>
          <input
              id="email"
              v-model="email"
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="you@kingdom.com"
              required
              type="email"
          />
        </div>

        <div>
          <label class="block mb-1 font-semibold text-yellow-900" for="password">Secret Phrase</label>
          <input
              id="password"
              v-model="password"
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="••••••••"
              required
              type="password"
          />
        </div>

        <div>
          <button
              class="w-full py-2.5 px-4 bg-red-700 hover:bg-red-800 transition rounded-lg font-bold text-yellow-100 shadow-lg hover:scale-105 transform"
              type="submit"
          >
            Enter the Tavern
          </button>
        </div>
      </form>

      <div
          v-if="error === 'Please verify your email before logging in.'"
          class="text-center mt-4"
      >
        <button
            class="text-red-800 hover:text-red-900 text-sm font-semibold underline"
            type="button"
            @click="resendActivation"
        >
          Resend Magical Verification Scroll
        </button>
      </div>

      <p
          v-if="error"
          class="text-red-700 text-center mt-3 sm:mt-4 font-medium text-sm sm:text-base bg-amber-50 p-2 rounded"
      >
        ⚠️ {{ error }}
      </p>

      <p
          v-if="success"
          class="text-green-700 text-center mt-3 font-medium bg-amber-50 p-2 rounded"
      >
        ✅ {{ success }}
      </p>

      <p class="text-center mt-4 sm:mt-6 text-sm sm:text-base text-yellow-900">
        New to the realm?
        <router-link
            to="/register"
            class="text-red-800 font-semibold hover:underline"
        >
          Create Your Hero
        </router-link>
      </p>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

h1, label, button {
  font-family: 'Uncial Antiqua', cursive;
}

* {
  font-family: 'Inter', sans-serif;
}
</style>
