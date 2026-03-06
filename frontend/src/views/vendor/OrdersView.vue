<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useOrderStore } from '@/stores/order'

const router = useRouter()
const orderStore = useOrderStore()

const statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled']

onMounted(() => {
  orderStore.fetchVendorOrders()
})

function formatPrice(price: number) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'short', 
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

async function updateStatus(orderId: number, status: string) {
  await orderStore.updateOrderStatus(orderId, status)
  await orderStore.fetchVendorOrders()
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
      <button @click="router.push('/vendor')" class="text-indigo-600 hover:text-indigo-800 mb-2 flex items-center gap-1">
        ← Back to Dashboard
      </button>
      <h1 class="text-3xl font-bold text-gray-900">Manage Orders</h1>
    </div>
    
    <div v-if="orderStore.loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="orderStore.orders.length === 0" class="text-center py-12 bg-white rounded-xl shadow-md">
      <p class="text-gray-500 text-lg">No orders yet</p>
    </div>
    
    <div v-else class="space-y-6">
      <div v-for="order in orderStore.orders" :key="order.id" class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
          <div>
            <p class="text-lg font-semibold text-gray-900">Order #{{ order.id }}</p>
            <p class="text-sm text-gray-500">Customer: {{ order.user?.name }}</p>
            <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
          </div>
          <select :value="order.status" @change="updateStatus(order.id, ($event.target as HTMLSelectElement).value)" :class="['px-4 py-2 rounded-lg text-sm font-medium border-0 focus:ring-2 focus:ring-indigo-500', getStatusColor(order.status)]">
            <option v-for="status in statuses" :key="status" :value="status" class="bg-white">
              {{ status.charAt(0).toUpperCase() + status.slice(1) }}
            </option>
          </select>
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
          <div class="text-sm text-gray-500">
            <p>Shipping: {{ order.shipping_address }}</p>
            <p>Phone: {{ order.phone }}</p>
          </div>
          <p class="text-xl font-bold text-gray-900">Total: {{ formatPrice(order.total) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
