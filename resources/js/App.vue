<script setup>
import { useAuthStore } from './stores/auth';
import { computed, ref } from 'vue';
// import logo from '../js/assets/dnd_logo.png' // Uncomment when your logo’s ready

const authStore = useAuthStore();
const isLoading = computed(() => authStore.loading);
const mobileOpen = ref(false);




// window.Echo.channel('test')
//     .listen('.message.sent', e => {
//       console.log('🔥 Incoming broadcast:', e.message)
//     })
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-amber-100 to-amber-200 text-gray-900">
    <!-- Loading Spinner -->
    <div v-if="isLoading" class="flex items-center justify-center h-screen">
      <div class="w-12 h-12 border-4 border-yellow-200 border-t-red-800 rounded-full animate-spin"></div>
    </div>

    <div v-else>
      <!-- Navbar -->
      <nav class="bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-b-4 border-yellow-900 shadow-xl p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
          <!-- Logo + Title -->
          <div class="flex items-center gap-3">
            <!-- <img :src="logo" alt="D&D Logo" class="h-10 w-auto drop-shadow-md"/> -->
            <router-link
                to="/"
                class="text-xl sm:text-2xl md:text-3xl font-extrabold text-red-800 drop-shadow-md tracking-wide hover:text-red-900 transition"
            >
              Dungeon & Dragons
            </router-link>
          </div>

          <!-- Desktop Links -->
          <div class="hidden sm:flex space-x-6">
            <template v-if="authStore.authenticated">
              <router-link
                  to="/dashboard"
                  class="text-yellow-900 hover:text-red-800 font-semibold transition"
              >
                Guild Hall
              </router-link>
              <router-link
                  to="/profile"
                  class="text-yellow-900 hover:text-red-800 font-semibold transition"
              >
                Adventurer’s Tome
              </router-link>
            </template>
            <template v-else>
              <router-link
                  to="/"
                  class="text-yellow-900 hover:text-red-800 font-semibold transition"
              >
                Home
              </router-link>
              <router-link
                  to="/about"
                  class="text-yellow-900 hover:text-red-800 font-semibold transition"
              >
                Lore
              </router-link>
              <router-link
                  to="/login"
                  class="text-yellow-900 hover:text-red-800 font-semibold transition"
              >
                Enter Realm
              </router-link>
              <router-link
                  to="/register"
                  class="bg-red-700 hover:bg-red-800 text-yellow-100 font-bold px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105"
              >
                Join the Quest
              </router-link>
            </template>
          </div>

          <!-- Mobile Hamburger -->
          <button
              @click="mobileOpen = !mobileOpen"
              class="sm:hidden text-3xl text-yellow-900 focus:outline-none"
          >
            ☰
          </button>
        </div>

        <!-- Mobile Menu -->
        <transition name="fade">
          <div
              v-if="mobileOpen"
              class="sm:hidden mt-3 flex flex-col gap-2 bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-2 border-yellow-900 p-3 rounded-lg shadow-lg"
          >
            <template v-if="authStore.authenticated">
              <router-link
                  @click="mobileOpen = false"
                  to="/dashboard"
                  class="block text-yellow-900 hover:text-red-800 font-semibold"
              >
                Guild Hall
              </router-link>
              <router-link
                  @click="mobileOpen = false"
                  to="/profile"
                  class="block text-yellow-900 hover:text-red-800 font-semibold"
              >
                Adventurer’s Tome
              </router-link>
            </template>
            <template v-else>
              <router-link
                  @click="mobileOpen = false"
                  to="/"
                  class="block text-yellow-900 hover:text-red-800 font-semibold"
              >
                Home
              </router-link>
              <router-link
                  @click="mobileOpen = false"
                  to="/about"
                  class="block text-yellow-900 hover:text-red-800 font-semibold"
              >
                Lore
              </router-link>
              <router-link
                  @click="mobileOpen = false"
                  to="/login"
                  class="block text-yellow-900 hover:text-red-800 font-semibold"
              >
                Enter Realm
              </router-link>
              <router-link
                  @click="mobileOpen = false"
                  to="/register"
                  class="block bg-red-700 hover:bg-red-800 text-yellow-100 px-4 py-2 rounded-lg font-bold text-center"
              >
                Join the Quest
              </router-link>
            </template>
          </div>
        </transition>
      </nav>

      <main class="min-h-[calc(100vh-80px)]">
        <router-view />
      </main>
    </div>
  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
}

/* Fade for mobile menu */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Fantasy font for headings/nav */
h1, nav a {
  font-family: 'Uncial Antiqua', cursive;
}
</style>
