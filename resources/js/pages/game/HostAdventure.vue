<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const title = ref('')
const description = ref('')
const maxPlayers = ref(4)
const difficulty = ref('Normal')
const isPrivate = ref(false)

async function saveAdventure() {
    console.log('✨ New Adventure Created:', {
        title: title.value,
        description: description.value,
        maxPlayers: maxPlayers.value,
        isPrivate: isPrivate.value,
    })

    await axios.post('/adventures', {
        title: title.value,
        description: description.value,
        maxPlayers: maxPlayers.value,
        difficulty: difficulty.value,
        isPrivate: isPrivate.value,
    })

    // For now, just redirect back to the tavern
    router.push('/dashboard')
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-900 via-stone-900 to-gray-800 text-amber-100 py-10 px-4">
        <div
            class="max-w-3xl mx-auto bg-[url('/parchment-texture.jpg')] bg-cover bg-center border-2 border-yellow-700 rounded-2xl p-6 sm:p-10 shadow-2xl"
        >
            <h1 class="text-3xl sm:text-4xl font-bold text-red-900 mb-6 text-center font-uncial drop-shadow-lg">
                🏕️ Host a New Adventure
            </h1>

            <form @submit.prevent="saveAdventure" class="space-y-5">
                <div>
                    <label class="block mb-1 font-semibold text-red-900">Adventure Title</label>
                    <input
                        v-model="title"
                        required
                        type="text"
                        placeholder="The Cursed Mines of Mornvale"
                        class="w-full px-4 py-2 border border-yellow-700 rounded-lg bg-amber-50/80 text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-800"
                    />
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-red-900">Description</label>
                    <textarea
                        v-model="description"
                        rows="4"
                        placeholder="Write a short summary of your quest..."
                        class="w-full px-4 py-2 border border-yellow-700 rounded-lg bg-amber-50/80 text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-800"
                    ></textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold text-red-900">Max Players</label>
                        <input
                            v-model="maxPlayers"
                            type="number"
                            min="2"
                            max="8"
                            class="w-full px-4 py-2 border border-yellow-700 rounded-lg bg-amber-50/80 text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-800"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="private" v-model="isPrivate" type="checkbox" class="w-4 h-4 text-red-800" />
                    <label for="private" class="text-red-900 font-semibold">Private Adventure (invite only)</label>
                </div>

                <div class="text-center mt-8">
                    <button
                        type="submit"
                        class="bg-red-800 hover:bg-red-700 text-amber-100 font-bold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105"
                    >
                        Begin the Adventure
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Uncial+Antiqua&family=Inter:wght@400;600;700&display=swap');
.font-uncial {
    font-family: 'Uncial Antiqua', cursive;
}
p, label, input, textarea, button, select {
    font-family: 'Inter', sans-serif;
}
</style>
