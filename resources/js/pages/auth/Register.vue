<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth.js';
// import logo from '../../assets/dnd_logo.png'; // swap with your D&D logo

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const error = ref('');
const router = useRouter();
const authStore = useAuthStore();

async function register() {
  try {
    await authStore.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    await router.push({
      path: '/verify-email',
      query: {email: email.value}
    });
  } catch (err) {
    error.value = err.response?.data?.message || 'Registration failed';
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
        Create Your Hero
      </h1>

      <form @submit.prevent="register" class="space-y-4 sm:space-y-5">
        <div>
          <label for="name" class="block mb-1 font-semibold text-yellow-900">Adventurer’s Name</label>
          <input
              id="name"
              type="text"
              v-model="name"
              required
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="Sir Galen the Brave"
          />
        </div>

        <div>
          <label for="email" class="block mb-1 font-semibold text-yellow-900">Scroll of Contact (Email)</label>
          <input
              id="email"
              type="email"
              v-model="email"
              required
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="you@kingdom.com"
          />
        </div>

        <div>
          <label for="password" class="block mb-1 font-semibold text-yellow-900">Secret Phrase</label>
          <input
              id="password"
              type="password"
              v-model="password"
              required
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="••••••••"
          />
        </div>

        <div>
          <label for="password_confirmation" class="block mb-1 font-semibold text-yellow-900">Confirm Secret
            Phrase</label>
          <input
              id="password_confirmation"
              type="password"
              v-model="password_confirmation"
              required
              class="w-full px-4 py-2.5 rounded-lg border border-yellow-700 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 bg-amber-50"
              placeholder="••••••••"
          />
        </div>

        <div>
          <button
              type="submit"
              class="w-full py-2.5 px-4 bg-red-700 hover:bg-red-800 transition rounded-lg font-bold text-yellow-100 shadow-lg hover:scale-105 transform"
          >
            Forge Account
          </button>
        </div>
      </form>

      <p v-if="error" class="text-red-700 text-center mt-3 font-medium text-sm sm:text-base bg-amber-50 p-2 rounded">
        ⚠️ {{ error }}
      </p>

      <p class="text-center mt-4 sm:mt-6 text-sm sm:text-base text-yellow-900">
        Already have a hero?
        <router-link to="/login" class="text-red-800 font-semibold hover:underline">Return to the Tavern</router-link>
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
