<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useOrderStore } from '@/stores/order'

const router = useRouter()
const orderStore = useOrderStore()

onMounted(() => {
  orderStore.fetchOrders()
})

function formatPrice(price: number) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

function getStatusColor(status: string) {
  const colors: Record<string, string> = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    shipped: 'bg-purple-100 text-purple-800',
    delivered: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
  }
  return colors[status] || 'bg-gray-100 text-gray-800'
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>
    
    <div v-if="orderStore.loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="orderStore.orders.length === 0" class="text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <p class="mt-4 text-gray-500 text-lg">No orders yet</p>
      <button @click="router.push('/')" class="mt-6 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
        Start Shopping
      </button>
    </div>
    
    <div v-else class="space-y-6">
      <div v-for="order in orderStore.orders" :key="order.id" class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
          <div>
            <p class="text-sm text-gray-500">Order #{{ order.id }}</p>
            <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
          </div>
          <span :class="['px-3 py-1 rounded-full text-sm font-medium', getStatusColor(order.status)]">
            {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
          </span>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
          <div v-for="item in order.order_items" :key="item.id" class="flex gap-4 py-2">
            <img :src="item.product?.image" :alt="item.product?.name" class="w-16 h-16 object-cover rounded-lg" />
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">{{ item.product?.name }}</h3>
              <p class="text-sm text-gray-500">Qty: {{ item.quantity }} × {{ formatPrice(item.price) }}</p>
            </div>
            <p class="font-medium text-gray-900">{{ formatPrice(item.price * item.quantity) }}</p>
          </div>
        </div>
        
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
          <p class="text-xl font-bold text-gray-900">Total: {{ formatPrice(order.total) }}</p>
          <button @click="router.push(`/orders/${order.id}`)" class="text-indigo-600 hover:text-indigo-800 font-medium">
            View Details →
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
