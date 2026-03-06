<script setup lang="ts">
import { onMounted } from 'vue'
import { useProductStore } from '@/stores/product'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'
import { RouterLink } from 'vue-router'

const productStore = useProductStore()
const cartStore = useCartStore()
const authStore = useAuthStore()

onMounted(() => {
  productStore.fetchProducts()
  productStore.fetchCategories()
})

async function addToCart(productId: number) {
  if (!authStore.isAuthenticated) {
    window.location.href = '/login'
    return
  }
  await cartStore.addToCart(productId, 1)
}
</script>

<template>
  <div>
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Welcome to Shop</h1>
        <p class="text-xl mb-8 text-indigo-100">Discover amazing products at great prices</p>
        <RouterLink to="#products" class="bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-indigo-50 transition">
          Shop Now
        </RouterLink>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Products</h2>
      
      <div v-if="productStore.loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
      </div>
      
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div v-for="product in productStore.products" :key="product.id" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
          <RouterLink :to="`/products/${product.slug}`">
            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
              <img :src="product.image" :alt="product.name" class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" />
            </div>
          </RouterLink>
          <div class="p-6">
            <p class="text-sm text-indigo-600 font-medium">{{ product.category?.name }}</p>
            <RouterLink :to="`/products/${product.slug}`">
              <h3 class="text-lg font-semibold text-gray-900 mt-1 hover:text-indigo-600">{{ product.name }}</h3>
            </RouterLink>
            <div class="flex items-center justify-between mt-4">
              <span class="text-2xl font-bold text-gray-900">${{ product.price }}</span>
              <button @click="addToCart(product.id)" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add to Cart
              </button>
            </div>
            <p v-if="product.stock < 10" class="text-sm text-orange-500 mt-2">{{ product.stock }} left in stock</p>
          </div>
        </div>
      </div>
      
      <div v-if="productStore.products.length === 0 && !productStore.loading" class="text-center py-12">
        <p class="text-gray-500 text-lg">No products available</p>
      </div>
    </div>

    <div class="bg-gray-100 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Why Choose Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-xl shadow-md text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Free Shipping</h3>
            <p class="text-gray-600">On orders over $50</p>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Secure Payment</h3>
            <p class="text-gray-600">100% secure payment</p>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Easy Returns</h3>
            <p class="text-gray-600">30-day return policy</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
