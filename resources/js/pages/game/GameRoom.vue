<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import {echo, useEcho} from '@laravel/echo-vue'
import axios from 'axios'

const route = useRoute()
const messages = ref([])
const newMessage = ref('')
onMounted(() => {
    const Echo = echo()
    console.log('listening on', `adventure.${route.params.id}`)

    Echo.private(`adventure.${route.params.id}`)
        .listen('.AdventureMessage', (e) => {
            console.log('💬 got it', e)
            messages.value.push({ sender: e.user, text: e.message })
        })
})

async function sendMessage() {
    if (!newMessage.value.trim()) return
    await axios.post(`/adventures/${route.params.id}/message`, {text: newMessage.value})
    newMessage.value = ''
}
</script>

<template>
    <div class="min-h-screen bg-stone-900 text-amber-100 p-6">
        <h1 class="text-2xl font-bold mb-4 font-uncial">🗺️ Adventure Room</h1>

        <div class="bg-amber-50/90 text-gray-900 p-4 rounded-lg h-96 overflow-y-auto mb-4">
            <div v-for="(msg, i) in messages" :key="i">
                <strong>{{ msg.sender }}:</strong> {{ msg.text }}
            </div>
        </div>

        <form @submit.prevent="sendMessage" class="flex gap-2">
            <input
                v-model="newMessage"
                placeholder="Type your action..."
                class="flex-1 px-4 py-2 border border-yellow-700 rounded-lg bg-amber-50/80 text-gray-900"
            />
            <button type="submit" class="bg-red-800 px-4 py-2 rounded-lg text-amber-100 font-bold">
                Send
            </button>
        </form>
    </div>
</template>
