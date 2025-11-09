<script setup>
import { ref, onMounted } from 'vue'
import router from "../../router/index.js";
import axios from 'axios'

const emit = defineEmits(['close', 'join'])

const adventures = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(() => {
    fetchActive()
})

async function fetchActive() {
    loading.value = true
    error.value = null
    try {
        const {data} = await axios.get('/adventures/active', {
            withCredentials: true,
        })
        adventures.value = data.adventures
    } catch (err) {
        console.error('Failed to load adventures', err)
        error.value = err
    } finally {
        loading.value = false
    }
}

function joinAdventure(adventure) {
    emit('join', adventure)
    router.push(`/game/${adventure.id}`)
}
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black/40">
        <div
            class="relative bg-[url('/parchment-texture.jpg')] bg-cover bg-center p-6 rounded-2xl shadow-2xl border border-yellow-800/60 max-w-lg w-full text-stone-800"
        >
            <div class="absolute inset-0 bg-amber-50/70 rounded-2xl backdrop-blur-[1px]"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-red-900 mb-4 font-uncial drop-shadow-sm">
                    🎲 Available Adventures
                </h2>

                <div v-if="loading" class="text-center text-gray-700">Loading tables...</div>
                <div v-else-if="error" class="text-center text-red-700">Failed to load adventures.</div>

                <ul v-else class="space-y-3">
                    <li
                        v-for="a in adventures"
                        :key="a.id"
                        class="p-3 bg-amber-100/80 rounded-lg border border-yellow-700 flex justify-between items-center hover:bg-amber-200/80 transition"
                    >
                        <div>
                            <div class="font-bold text-gray-900">{{ a.title }}</div>
                            <div class="text-sm text-gray-700">Players: {{ a.currentPlayers }}/{{ a.maxPlayers }}</div>
                        </div>
                        <button
                            @click="joinAdventure(a)"
                            class="bg-red-800 hover:bg-red-700 text-amber-100 px-3 py-1 rounded-lg font-bold shadow-sm"
                        >
                            Join
                        </button>
                    </li>
                </ul>

                <div class="text-center mt-5">
                    <button @click="$emit('close')" class="text-sm text-gray-700 underline hover:text-gray-900">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
