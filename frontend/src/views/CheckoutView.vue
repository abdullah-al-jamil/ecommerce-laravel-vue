<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useOrderStore } from '@/stores/order'

const router = useRouter()
const cartStore = useCartStore()
const orderStore = useOrderStore()

const shippingAddress = ref('')
const phone = ref('')
const error = ref('')
const loading = ref(false)

onMounted(() => {
  cartStore.fetchCart()
})

function formatPrice(price: number) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

async function handleCheckout() {
  error.value = ''
  loading.value = true
  
  try {
    await orderStore.createOrder({
      shipping_address: shippingAddress.value,
      phone: phone.value,
    })
    await cartStore.fetchCart()
    router.push('/orders')
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Checkout failed. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
    
    <div v-if="cartStore.items.length === 0" class="text-center py-12">
      <p class="text-gray-500 text-lg">Your cart is empty</p>
      <button @click="router.push('/')" class="mt-6 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
        Continue Shopping
      </button>
    </div>
    
    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <div>
        <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping Information</h2>
        
        <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
          {{ error }}
        </div>
        
        <form @submit.prevent="handleCheckout" class="space-y-6">
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Shipping Address</label>
            <textarea id="address" v-model="shippingAddress" required rows="3" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your full shipping address"></textarea>
          </div>
          
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input id="phone" v-model="phone" type="tel" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Your phone number" />
          </div>
          
          <button type="submit" :disabled="loading || cartStore.items.length === 0" class="w-full bg-indigo-600 text-white py-4 rounded-lg hover:bg-indigo-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed">
            <span v-if="loading">Processing...</span>
            <span v-else>Place Order - {{ formatPrice(cartStore.total) }}</span>
          </button>
        </form>
      </div>
      
      <div>
        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
        <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
          <div v-for="item in cartStore.items" :key="item.id" class="flex gap-4">
            <img :src="item.product?.image" :alt="item.product?.name" class="w-16 h-16 object-cover rounded-lg" />
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">{{ item.product?.name }}</h3>
              <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
            </div>
            <p class="font-medium text-gray-900">{{ formatPrice((item.product?.price || 0) * item.quantity) }}</p>
          </div>
          
          <div class="border-t border-gray-200 pt-4 space-y-2">
            <div class="flex justify-between text-gray-600">
              <span>Subtotal</span>
              <span>{{ formatPrice(cartStore.total) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
              <span>Shipping</span>
              <span class="text-green-600">Free</span>
            </div>
            <div class="flex justify-between text-xl font-bold text-gray-900 pt-2">
              <span>Total</span>
              <span>{{ formatPrice(cartStore.total) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
