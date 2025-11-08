<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth.js';

const authStore = useAuthStore();
const router = useRouter();

const user = ref(null);
const name = ref('');
const email = ref('');
const updateMessage = ref('');
const updateError = ref('');

onMounted(async () => {
  if (authStore.isAuthenticated) {
    user.value = authStore.currentUser;
  } else {
    await authStore.fetchUser();
    user.value = authStore.currentUser;
  }

  if (user.value) {
    name.value = user.value.name;
    email.value = user.value.email;
  }
});

import { useEchoPublic} from "@laravel/echo-vue";

useEchoPublic("public", "TestMessage", (e) => {
    console.log(e);
});

async function logout() {
  await authStore.logout();
  router.push('/');
}

function updateProfile() {
  // placeholder for future update endpoint
  updateMessage.value = 'Profile updated successfully!';
  updateError.value = '';
  setTimeout(() => (updateMessage.value = ''), 3000);
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-900 via-stone-900 to-gray-800 text-amber-100 p-4 sm:p-8">
    <div
        class="max-w-3xl mx-auto bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-4 border-yellow-800 rounded-2xl p-6 sm:p-10 shadow-2xl">
      <!-- Header -->
      <h1 class="text-3xl sm:text-4xl font-extrabold text-center mb-8 text-red-800 font-uncial drop-shadow-md">
        🪶 Adventurer’s Profile
      </h1>

      <div v-if="user">
        <!-- Avatar & Info -->
        <div class="flex flex-col sm:flex-row items-center sm:items-start mb-8 gap-6">
          <div
              class="flex items-center justify-center bg-red-800 text-amber-100 rounded-full w-20 h-20 text-3xl shadow-md font-bold"
          >
            {{ user.name }}
          </div>

          <div class="text-center sm:text-left">
            <h2 class="text-xl font-bold text-red-900">{{ user.name }}</h2>
            <p class="text-yellow-900 italic">{{ user.email }}</p>
            <p class="mt-2 text-sm text-gray-700">Status: Active Adventurer</p>
          </div>
        </div>

        <!-- Form -->
        <div>
          <h3 class="text-2xl font-bold mb-4 text-red-800 font-uncial">Character Details</h3>
          <form @submit.prevent="updateProfile" class="space-y-4">
            <div>
              <label for="name" class="block mb-1 text-yellow-900 font-semibold">Name</label>
              <input
                  id="name"
                  v-model="name"
                  type="text"
                  readonly
                  class="w-full p-3 rounded-lg border border-yellow-700 bg-amber-50 text-gray-900 cursor-not-allowed"
              />
            </div>

            <div>
              <label for="email" class="block mb-1 text-yellow-900 font-semibold">Email</label>
              <input
                  id="email"
                  v-model="email"
                  type="email"
                  readonly
                  class="w-full p-3 rounded-lg border border-yellow-700 bg-amber-50 text-gray-900 cursor-not-allowed"
              />
            </div>

            <p v-if="updateMessage" class="text-green-700 mt-2 font-semibold">{{ updateMessage }}</p>
            <p v-if="updateError" class="text-red-700 mt-2 font-semibold">{{ updateError }}</p>
          </form>
        </div>

        <!-- Actions -->
        <div class="mt-10 text-center flex flex-col sm:flex-row justify-center gap-4">
          <router-link
              to="/dashboard"
              class="bg-amber-700 hover:bg-amber-600 text-gray-900 font-bold px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105"
          >
            Return to Tavern
          </router-link>
          <button
              @click="logout"
              class="bg-red-700 hover:bg-red-800 text-yellow-100 font-bold px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105"
          >
            Logout
          </button>
        </div>
      </div>

      <!-- Loading -->
      <div v-else class="text-center text-yellow-800">Loading your profile, adventurer...</div>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

.font-uncial {
  font-family: 'Uncial Antiqua', cursive;
}

p, input, button, label {
  font-family: 'Inter', sans-serif;
}
</style>
