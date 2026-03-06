import { defineStore } from 'pinia'
import api from '@/services/api.ts'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref<any[]>([])
  const total = ref(0)
  const count = ref(0)
  const loading = ref(false)

  async function fetchCart() {
    loading.value = true
    try {
      const response = await api.get('/cart')
      items.value = response.data.items
      total.value = response.data.total
      count.value = response.data.count
    } catch (error) {
      console.error('Error fetching cart:', error)
    } finally {
      loading.value = false
    }
  }

  async function addToCart(productId: number, quantity: number = 1) {
    try {
      await api.post('/cart', { product_id: productId, quantity })
      await fetchCart()
      return true
    } catch (error: any) {
      const message = error.response?.data?.message || 'Failed to add to cart'
      throw new Error(message)
    }
  }

  async function updateQuantity(cartId: number, quantity: number) {
    try {
      await api.put(`/cart/${cartId}`, { quantity })
      await fetchCart()
    } catch (error) {
      console.error('Error updating cart:', error)
    }
  }

  async function removeFromCart(cartId: number) {
    try {
      await api.delete(`/cart/${cartId}`)
      await fetchCart()
    } catch (error) {
      console.error('Error removing from cart:', error)
    }
  }

  async function clearCart() {
    try {
      await api.delete('/cart')
      items.value = []
      total.value = 0
      count.value = 0
    } catch (error) {
      console.error('Error clearing cart:', error)
    }
  }

  return {
    items,
    total,
    count,
    loading,
    fetchCart,
    addToCart,
    updateQuantity,
    removeFromCart,
    clearCart,
  }
})
