<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import api from '@/services/api'

const router = useRouter()
const authStore = useAuthStore()

const stats = ref({
  totalProducts: 0,
  totalOrders: 0,
  totalRevenue: 0,
})

onMounted(async () => {
  try {
    const response = await api.get('/vendor/products')
    stats.value.totalProducts = response.data.length
    
    const ordersResponse = await api.get('/vendor/orders')
    stats.value.totalOrders = ordersResponse.data.length
    stats.value.totalRevenue = ordersResponse.data.reduce((sum: number, order: any) => {
      return sum + order.order_items.reduce((orderSum: number, item: any) => {
        if (item.product?.user_id === authStore.user?.id) {
          return orderSum + (item.price * item.quantity)
        }
        return orderSum
      }, 0)
    }, 0)
  } catch (error) {
    console.error('Error fetching stats:', error)
  }
})
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Vendor Dashboard</h1>
      <p class="text-gray-500 mt-2">Welcome back, {{ authStore.user?.name }}!</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-indigo-100">Total Products</p>
            <p class="text-4xl font-bold mt-2">{{ stats.totalProducts }}</p>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100">Total Orders</p>
            <p class="text-4xl font-bold mt-2">{{ stats.totalOrders }}</p>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-100">Total Revenue</p>
            <p class="text-4xl font-bold mt-2">${{ stats.totalRevenue.toFixed(2) }}</p>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="space-y-3">
          <button @click="router.push('/vendor/products')" class="w-full flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="font-medium text-gray-900">Manage Products</span>
          </button>
          <button @click="router.push('/vendor/orders')" class="w-full flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="font-medium text-gray-900">View Orders</span>
          </button>
        </div>
      </div>
      
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Activity</h2>
        <p class="text-gray-500">No recent activity</p>
      </div>
    </div>
  </div>
</template>
