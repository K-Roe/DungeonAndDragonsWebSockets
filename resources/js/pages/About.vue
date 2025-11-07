<script setup>
// import logo from '../assets/dnd_logo.png' // Uncomment and replace when your logo is ready
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-amber-100 to-amber-200 text-gray-900 p-4 sm:p-6 md:p-10 flex items-center justify-center">
    <div class="w-full max-w-2xl sm:max-w-3xl bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-4 border-yellow-900 p-6 sm:p-8 md:p-10 rounded-2xl shadow-2xl text-center">
      <div class="flex justify-center mb-6">
        <!-- <img :src="logo" alt="D&D Logo" class="h-24 w-auto drop-shadow-lg"/> -->
      </div>

      <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6 text-red-800 tracking-wide drop-shadow-md">
        About the Realm
      </h1>

      <p class="text-base sm:text-lg text-gray-800 leading-relaxed mb-4 sm:mb-6">
        <strong>Dungeons & Dragons Online</strong> is a gathering place for heroes, wanderers, and storytellers alike.
        Whether you seek treasure, glory, or just a good ale with friends — the adventure awaits.
      </p>

      <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 sm:mb-6">
        In this digital realm, players connect across the land in real time, forging their destinies together through
        quests, battles, and fellowship. Every choice shapes your legend.
      </p>

      <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
        Crafted with <strong>Laravel</strong> and <strong>Vue 3</strong>, this world blends the magic of fantasy with
        the technology of today — allowing Dungeon Masters and adventurers to share one living, breathing world.
      </p>

      <div class="mt-8 text-center text-sm text-yellow-900 italic">
        “The dice decide our fate — but the story is ours to tell.”
      </div>
    </div>
  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');

h1 {
  font-family: 'Uncial Antiqua', cursive;
}

p {
  font-family: 'Inter', sans-serif;
}
</style>
