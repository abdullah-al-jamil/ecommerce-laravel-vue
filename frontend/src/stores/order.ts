import { defineStore } from 'pinia'
import api from '@/services/api.ts'
import { ref } from 'vue'

export const useOrderStore = defineStore('order', () => {
  const orders = ref<any[]>([])
  const currentOrder = ref<any>(null)
  const loading = ref(false)

  async function fetchOrders() {
    loading.value = true
    try {
      const response = await api.get('/orders')
      orders.value = response.data
    } catch (error) {
      console.error('Error fetching orders:', error)
    } finally {
      loading.value = false
    }
  }

  async function fetchOrder(orderId: number) {
    loading.value = true
    try {
      const response = await api.get(`/orders/${orderId}`)
      currentOrder.value = response.data
    } catch (error) {
      console.error('Error fetching order:', error)
    } finally {
      loading.value = false
    }
  }

  async function createOrder(data: { shipping_address: string; phone: string }) {
    loading.value = true
    try {
      const response = await api.post('/orders', data)
      return response.data
    } catch (error) {
      console.error('Error creating order:', error)
      throw error
    } finally {
      loading.value = false
    }
  }

  async function fetchVendorOrders() {
    loading.value = true
    try {
      const response = await api.get('/vendor/orders')
      orders.value = response.data
    } catch (error) {
      console.error('Error fetching vendor orders:', error)
    } finally {
      loading.value = false
    }
  }

  async function updateOrderStatus(orderId: number, status: string) {
    try {
      await api.put(`/vendor/orders/${orderId}`, { status })
    } catch (error) {
      console.error('Error updating order status:', error)
    }
  }

  return {
    orders,
    currentOrder,
    loading,
    fetchOrders,
    fetchOrder,
    createOrder,
    fetchVendorOrders,
    updateOrderStatus,
  }
})
