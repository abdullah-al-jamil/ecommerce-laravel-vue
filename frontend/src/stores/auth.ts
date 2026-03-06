import { defineStore } from 'pinia'
import api from '@/services/api.ts'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user') || 'null'))
  const token = ref(localStorage.getItem('token') || null)

  const isAuthenticated = computed(() => !!token.value)
  const isVendor = computed(() => user.value?.role === 'vendor')

  async function register(data: { name: string; email: string; password: string; password_confirmation: string; role?: string }) {
    const response = await api.post('/register', data)
    token.value = response.data.token
    user.value = response.data.user
    localStorage.setItem('token', token.value!)
    localStorage.setItem('user', JSON.stringify(user.value))
    return response.data
  }

  async function login(email: string, password: string) {
    const response = await api.post('/login', { email, password })
    token.value = response.data.token
    user.value = response.data.user
    localStorage.setItem('token', token.value!)
    localStorage.setItem('user', JSON.stringify(user.value))
    return response.data
  }

  async function logout() {
    await api.post('/logout')
    token.value = null
    user.value = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  async function fetchUser() {
    try {
      const response = await api.get('/user')
      user.value = response.data
      localStorage.setItem('user', JSON.stringify(user.value))
    } catch (error) {
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    isVendor,
    register,
    login,
    logout,
    fetchUser,
  }
})
