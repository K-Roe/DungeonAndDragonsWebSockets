<script setup>
// import logo from '../assets/dnd_logo.png' // optional
import { useAuthStore } from '../../stores/auth';
const auth = useAuthStore();
console.log(auth)

import {onMounted, ref} from "vue";
import JoinGameModal from "../../components/Game/JoinGameModal.vue";


import { useRouter } from 'vue-router'

const showModal = ref(false)
const router = useRouter()

function joinAdventure(adventure) {
    showModal.value = false
    router.push(`/game/${adventure.id}`)
}



</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-900 via-stone-900 to-gray-800 text-amber-100">
    <!-- Header -->
    <header class="border-b border-yellow-700 bg-[url('/stone-wall.jpg')] bg-cover bg-center shadow-lg">
      <div class="max-w-6xl mx-auto flex items-center justify-between p-5">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-amber-300 drop-shadow-md font-uncial">
          🕯️ The Adventurer’s Tavern
        </h1>
        <div class="text-right text-sm italic text-amber-200">
          Welcome back, {{ auth.user?.name || 'Traveler' }}
        </div>
      </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto mt-10 px-4 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <!-- Adventurer Card -->
      <section
          class="bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-2 border-yellow-700 rounded-2xl p-6 shadow-2xl flex flex-col justify-between hover:shadow-amber-500/30 transition"
      >
        <div>
          <h2 class="text-2xl font-bold text-red-900 mb-3 font-uncial">Adventurer’s Card</h2>
          <p><strong>Name:</strong> {{ auth.user?.name || 'Unknown' }}</p>
          <p><strong>Title:</strong> Wandering Hero</p>
          <p><strong>Level:</strong> 1</p>
          <p><strong>Gold:</strong> 0</p>
        </div>
        <router-link
            to="/profile"
            class="mt-5 bg-red-800 hover:bg-red-700 text-amber-100 font-bold px-4 py-2 rounded-lg text-center shadow-md transition transform hover:scale-105"
        >
          View Profile
        </router-link>
      </section>

      <!-- Quest Board -->
      <section
          class="bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-2 border-yellow-700 rounded-2xl p-6 shadow-2xl col-span-2 flex flex-col justify-between hover:shadow-amber-500/30 transition"
      >
        <div>
          <h2 class="text-2xl font-bold text-red-900 mb-3 font-uncial">Quest Board</h2>
          <ul class="space-y-3 text-gray-800">
            <li
                class="bg-amber-50/90 p-3 rounded-md border border-yellow-700 shadow-sm hover:bg-amber-100 cursor-pointer"
            >
              ⚔️ <strong>Join an Existing Campaign</strong> — continue your tale with your party.
            </li>
              <router-link
                  to="/host-adventure"
                  class="bg-amber-50/90 p-3 rounded-md border border-yellow-700 shadow-sm hover:bg-amber-100 cursor-pointer"
              >
                  🏕️ <strong>Host a New Adventure</strong> — forge your own story as Dungeon Master.
              </router-link>
            <li
                class="bg-amber-50/90 p-3 rounded-md border border-yellow-700 shadow-sm hover:bg-amber-100 cursor-pointer"
            >
              📜 <strong>Quest Log</strong> — revisit completed tales and earned rewards.
            </li>
          </ul>
        </div>
        <router-link
            to="/create-character"
            class="mt-6 bg-red-800 hover:bg-red-700 text-amber-100 font-bold px-4 py-2 rounded-lg text-center shadow-md transition transform hover:scale-105"
        >
          Create New Character
        </router-link>
      </section>

      <!-- Party Table -->
      <section
          class="bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-2 border-yellow-700 rounded-2xl p-6 shadow-2xl hover:shadow-amber-500/30 transition"
      >
          <h2 class="text-2xl font-bold text-red-900 mb-3 font-uncial">Party Table</h2>
          <p class="text-gray-800">Pull up a chair. Your friends’ games will appear here — join them when the tavern bell rings.</p>
          <div class="mt-5 text-center">
              <button
                  @click="showModal = true"
                  class="bg-amber-600 hover:bg-amber-500 text-gray-900 font-bold px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105"
              >
                  Browse Games
              </button>
          </div>

          <JoinGameModal v-if="showModal" @close="showModal = false" @join="joinAdventure" />
      </section>
    </main>

    <!-- Footer -->
    <footer
        class="mt-16 border-t border-yellow-700 text-center text-sm text-amber-300 py-4 bg-[url('/stone-wall.jpg')] bg-cover bg-center shadow-inner"
    >
      <p>🍺 Roe All For One Tavern © 2025 — May fortune favor your dice.</p>
    </footer>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

.font-uncial {
  font-family: 'Uncial Antiqua', cursive;
}

p, li, button, a {
  font-family: 'Inter', sans-serif;
}
</style>
