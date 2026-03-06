<script setup lang="ts">
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useOrderStore } from '@/stores/order'

const route = useRoute()
const router = useRouter()
const orderStore = useOrderStore()

onMounted(() => {
  orderStore.fetchOrder(Number(route.params.id))
})

function formatPrice(price: number) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
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
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <button @click="router.back()" class="text-indigo-600 hover:text-indigo-800 mb-6 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Back to Orders
    </button>
    
    <div v-if="orderStore.loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="orderStore.currentOrder">
      <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Order #{{ orderStore.currentOrder.id }}</h1>
            <p class="text-gray-500 mt-1">Placed on {{ formatDate(orderStore.currentOrder.created_at) }}</p>
          </div>
          <span :class="['px-4 py-2 rounded-full text-sm font-medium', getStatusColor(orderStore.currentOrder.status)]">
            {{ orderStore.currentOrder.status.charAt(0).toUpperCase() + orderStore.currentOrder.status.slice(1) }}
          </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">Shipping Address</h3>
            <p class="text-gray-600">{{ orderStore.currentOrder.shipping_address }}</p>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">Phone</h3>
            <p class="text-gray-600">{{ orderStore.currentOrder.phone }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Items</h2>
        <div class="space-y-4">
          <div v-for="item in orderStore.currentOrder.order_items" :key="item.id" class="flex gap-6">
            <img :src="item.product?.image" :alt="item.product?.name" class="w-24 h-24 object-cover rounded-lg" />
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900">{{ item.product?.name }}</h3>
              <p class="text-gray-500">{{ item.quantity }} × {{ formatPrice(item.price) }}</p>
            </div>
            <p class="font-bold text-gray-900 text-lg">{{ formatPrice(item.price * item.quantity) }}</p>
          </div>
        </div>
        
        <div class="border-t border-gray-200 mt-6 pt-6">
          <div class="flex justify-between text-xl font-bold text-gray-900">
            <span>Total</span>
            <span>{{ formatPrice(orderStore.currentOrder.total) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
