<script setup>
// import logo from '../assets/dnd_logo.png' // replace with your fantasy-style logo



</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-amber-100 to-amber-200 text-gray-900 p-4 sm:p-6 md:p-10 flex items-center justify-center">
    <div class="w-full max-w-3xl sm:max-w-4xl bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-4 border-yellow-900 p-6 sm:p-8 md:p-10 rounded-2xl shadow-2xl">
      <div class="flex justify-center mb-6">
<!--        <img :src="logo" alt="Dungeon & Dragons Logo" class="h-24 w-auto drop-shadow-lg"/>-->
      </div>

      <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center text-red-800 mb-6 tracking-wide drop-shadow-md">
        Dungeon & Dragons Online
      </h1>

      <p class="text-base sm:text-lg text-gray-800 leading-relaxed mb-4 sm:mb-6 text-center">
        Gather your party and prepare to venture into the unknown. Create your hero, join friends on epic quests, and
        battle creatures in real time with live updates powered by <strong>WebSockets</strong>.
      </p>

      <p class="text-sm sm:text-base text-gray-700 mb-6 text-center">
        Whether you’re a Dungeon Master forging the world or a player seeking glory, <em>D&D Online</em> lets everyone
        around the table — or across the world — play together.
      </p>

      <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6 sm:mt-10">
        <router-link
            class="w-full sm:w-auto text-center bg-red-700 hover:bg-red-800 text-yellow-100 font-bold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105"
            to="/register"
        >
          Begin Your Adventure
        </router-link>

        <router-link
            class="w-full sm:w-auto text-center bg-yellow-50 hover:bg-yellow-100 text-red-800 font-semibold px-8 py-3 rounded-lg shadow-sm border border-yellow-700 transition"
            to="/about"
        >
          Learn the Lore
        </router-link>
      </div>

      <div class="mt-8 text-center text-sm text-gray-600">
        ⚔️ <span class="italic">Forge your fate. Roll your destiny.</span> ⚔️
      </div>
    </div>
  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

h1 {
  font-family: 'Uncial Antiqua', cursive;
}

p, a {
  font-family: 'Inter', sans-serif;
}
</style>
