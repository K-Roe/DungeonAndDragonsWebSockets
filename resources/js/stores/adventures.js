import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAdventuresStore = defineStore('adventures', () => {
    // -----------------------------
    // State
    // -----------------------------
    const adventures = ref([])
    const selectedAdventure = ref(null)
    const loading = ref(false)
    const error = ref(null)

    // -----------------------------
    // Getters
    // -----------------------------
    const allAdventures = computed(() => adventures.value)
    const activeAdventure = computed(() => selectedAdventure.value)
    const isLoading = computed(() => loading.value)
    const hasError = computed(() => !!error.value)

    // -----------------------------
    // Actions
    // -----------------------------


    async function fetchActive() {
        loading.value = true
        error.value = null

        try {
            const { data } = await axios.get('/adventures/active', {
                withCredentials: true,
            })
            adventures.value = data.adventures
            return data
        } catch (err) {
            console.error('Failed to load adventures', err)
            error.value = err
        } finally {
            loading.value = false
        }
    }

    async function createAdventure(payload) {
        loading.value = true
        error.value = null

        try {
            const { data } = await axios.post('/adventures', payload, { withCredentials: true })
            adventures.value.push(data.adventure)
            return data.adventure
        } catch (err) {
            console.error('Failed to create adventure', err)
            error.value = err
            throw err
        } finally {
            loading.value = false
        }
    }

    async function sendMessage(adventureId, text) {
        try {
            await axios.post(`/adventures/${adventureId}/message`, { text }, { withCredentials: true })
        } catch (err) {
            console.error('Message send failed', err)
        }
    }

    function selectAdventure(adventure) {
        selectedAdventure.value = adventure
    }

    function clearSelection() {
        selectedAdventure.value = null
    }

    // -----------------------------
    // Return everything
    // -----------------------------
    return {
        adventures,
        selectedAdventure,
        loading,
        error,
        allAdventures,
        activeAdventure,
        isLoading,
        hasError,
        fetchActive,
        createAdventure,
        sendMessage,
        selectAdventure,
        clearSelection,
    }
})
