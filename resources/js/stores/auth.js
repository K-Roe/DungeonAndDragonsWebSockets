import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
    // -----------------------------
    // State
    // -----------------------------
    const user = ref(null)
    const authenticated = ref(false)
    const loading = ref(true)
    const csrfFetched = ref(false)

    // -----------------------------
    // Ensure CSRF cookie
    // -----------------------------
    async function ensureCsrf() {
        if (!csrfFetched.value) {
            await axios.get('/sanctum/csrf-cookie', { withCredentials: true })
            csrfFetched.value = true
        }
    }

    // -----------------------------
    // Getters
    // -----------------------------
    const isAuthenticated = computed(() => authenticated.value)
    const currentUser = computed(() => user.value)
    const isLoading = computed(() => loading.value)

    // -----------------------------
    // Actions
    // -----------------------------
    async function login(credentials) {
        await ensureCsrf()
        try {
            const response = await axios.post('/login', credentials, { withCredentials: true })
            user.value = response.data.user
            authenticated.value = true
            return true
        } catch (error) {
            user.value = null
            authenticated.value = false

            if (error.response?.status === 422 && error.response.data?.errors) {
                const firstField = Object.keys(error.response.data.errors)[0]
                throw error.response.data.errors[firstField][0]
            }

            throw error
        }
    }

    async function register(userData) {
        await ensureCsrf()
        try {
            await axios.post('/register', userData, { withCredentials: true })
            return true
        } catch (error) {
            throw error
        }
    }

    async function logout() {
        try {
            await ensureCsrf()
            await axios.post('/logout', {}, { withCredentials: true })
            user.value = null
            authenticated.value = false
        } catch (error) {
            console.error('Logout failed', error)
        }
    }

    async function fetchUser() {
        loading.value = true
        try {
            await ensureCsrf()
            const response = await axios.get('/api/user', { withCredentials: true })
            user.value = response.data
            authenticated.value = true
        } catch (error) {
            user.value = null
            authenticated.value = false
        } finally {
            loading.value = false
        }
    }

    async function resendVerification(email) {
        try {
            await ensureCsrf()
            const response = await axios.post(
                '/api/resend-verification',
                { email },
                { withCredentials: true }
            )


            return response.data.message
        } catch (error) {
            throw error.response?.data?.message || error.message
        }
    }

    function setLoaded() {
        loading.value = false
    }

    // -----------------------------
    // Return state, getters, actions
    // -----------------------------
    return {
        user,
        authenticated,
        loading,
        isAuthenticated,
        currentUser,
        isLoading,
        login,
        register,
        logout,
        fetchUser,
        setLoaded,
        ensureCsrf,
        resendVerification
    }
})
