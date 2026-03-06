<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useProductStore } from '@/stores/product'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const productStore = useProductStore()
const cartStore = useCartStore()
const authStore = useAuthStore()

const quantity = ref(1)
const addedToCart = ref(false)

onMounted(() => {
  productStore.fetchProduct(route.params.slug as string)
})

async function addToCart() {
  if (!authStore.isAuthenticated) {
    router.push('/login')
    return
  }
  
  await cartStore.addToCart(productStore.product.id, quantity.value)
  addedToCart.value = true
  setTimeout(() => {
    addedToCart.value = false
  }, 2000)
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div v-if="productStore.loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="productStore.product" class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-2xl bg-gray-100">
        <img :src="productStore.product.image" :alt="productStore.product.name" class="w-full h-[500px] object-cover" />
      </div>
      
      <div>
        <p class="text-indigo-600 font-medium">{{ productStore.product.category?.name }}</p>
        <h1 class="text-4xl font-bold text-gray-900 mt-2">{{ productStore.product.name }}</h1>
        <div class="mt-4 flex items-center">
          <div class="flex items-center">
            <svg v-for="i in 5" :key="i" class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
          <span class="ml-2 text-sm text-gray-500">(12 reviews)</span>
        </div>
        
        <p class="text-4xl font-bold text-gray-900 mt-6">${{ productStore.product.price }}</p>
        
        <p class="mt-6 text-gray-600 leading-relaxed">{{ productStore.product.description }}</p>
        
        <div class="mt-8">
          <p class="text-sm text-gray-700">
            <span v-if="productStore.product.stock > 0" class="text-green-600 font-medium">In Stock ({{ productStore.product.stock }} available)</span>
            <span v-else class="text-red-600 font-medium">Out of Stock</span>
          </p>
        </div>
        
        <div class="mt-8 flex items-center gap-4">
          <div class="flex items-center border border-gray-300 rounded-lg">
            <button @click="quantity > 1 && quantity--" class="px-4 py-2 text-gray-600 hover:text-gray-900">-</button>
            <span class="px-4 py-2 text-gray-900">{{ quantity }}</span>
            <button @click="quantity++" class="px-4 py-2 text-gray-600 hover:text-gray-900">+</button>
          </div>
          
          <button @click="addToCart" :disabled="productStore.product.stock === 0" class="flex-1 bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{ addedToCart ? 'Added!' : 'Add to Cart' }}
          </button>
        </div>
        
        <div v-if="addedToCart" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
          Product added to cart successfully!
        </div>
      </div>
    </div>
    
    <div v-else class="text-center py-12">
      <p class="text-gray-500">Product not found</p>
    </div>
  </div>
</template>
