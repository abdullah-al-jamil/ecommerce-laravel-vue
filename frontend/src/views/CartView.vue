<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const cartStore = useCartStore()
const authStore = useAuthStore()

onMounted(() => {
  if (authStore.isAuthenticated) {
    cartStore.fetchCart()
  }
})

function formatPrice(price: number) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

async function updateQuantity(cartId: number, quantity: number) {
  if (quantity < 1) return
  await cartStore.updateQuantity(cartId, quantity)
}

async function removeItem(cartId: number) {
  await cartStore.removeFromCart(cartId)
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
    
    <div v-if="cartStore.loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="cartStore.items.length === 0" class="text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <p class="mt-4 text-gray-500 text-lg">Your cart is empty</p>
      <button @click="router.push('/')" class="mt-6 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
        Continue Shopping
      </button>
    </div>
    
    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-6">
        <div v-for="item in cartStore.items" :key="item.id" class="bg-white rounded-xl shadow-md p-6 flex gap-6">
          <img :src="item.product?.image" :alt="item.product?.name" class="w-24 h-24 object-cover rounded-lg" />
          <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900">{{ item.product?.name }}</h3>
            <p class="text-gray-500 text-sm">{{ item.product?.category?.name }}</p>
            <p class="text-indigo-600 font-bold mt-2">{{ formatPrice(item.product?.price || 0) }}</p>
          </div>
          <div class="flex flex-col items-end justify-between">
            <button @click="removeItem(item.id)" class="text-gray-400 hover:text-red-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <div class="flex items-center border border-gray-300 rounded-lg">
              <button @click="updateQuantity(item.id, item.quantity - 1)" class="px-3 py-1 text-gray-600 hover:text-gray-900">-</button>
              <span class="px-3 py-1 text-gray-900">{{ item.quantity }}</span>
              <button @click="updateQuantity(item.id, item.quantity + 1)" class="px-3 py-1 text-gray-600 hover:text-gray-900">+</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
          <div class="space-y-3 border-b border-gray-200 pb-4">
            <div class="flex justify-between text-gray-600">
              <span>Subtotal ({{ cartStore.count }} items)</span>
              <span>{{ formatPrice(cartStore.total) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
              <span>Shipping</span>
              <span>Free</span>
            </div>
          </div>
          <div class="flex justify-between text-xl font-bold text-gray-900 pt-4">
            <span>Total</span>
            <span>{{ formatPrice(cartStore.total) }}</span>
          </div>
          <button @click="router.push('/checkout')" class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition font-medium">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
