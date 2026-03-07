<script setup lang="ts">
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import { onMounted } from 'vue'

const router = useRouter()
const authStore = useAuthStore()
const cartStore = useCartStore()

onMounted(() => {
  if (authStore.isAuthenticated) {
    cartStore.fetchCart()
  }
})

async function handleLogout() {
  await authStore.logout()
  router.push('/')
}
</script>

<template>
    <nav class="bg-white shadow-lg sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <RouterLink to="/" class="flex items-center">
              <span class="text-2xl font-bold text-indigo-600">Shop</span>
            </RouterLink>
            <div class="hidden md:flex ml-10 space-x-8">
              <RouterLink to="/" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Home</RouterLink>
              <RouterLink to="/category/electronics" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Electronics</RouterLink>
              <RouterLink to="/category/clothing" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Clothing</RouterLink>
              <RouterLink to="/category/home-garden" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Home & Garden</RouterLink>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <RouterLink to="/cart" class="relative text-gray-700 hover:text-indigo-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span v-if="cartStore.count > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ cartStore.count }}
              </span>
            </RouterLink>
            
            <template v-if="authStore.isAuthenticated">
              <RouterLink v-if="authStore.isVendor" to="/vendor" class="text-gray-700 hover:text-indigo-600 font-medium">
                Vendor Dashboard
              </RouterLink>
              <RouterLink to="/orders" class="text-gray-700 hover:text-indigo-600">
                Orders
              </RouterLink>
              <div class="flex items-center gap-2">
                <span class="text-gray-700">{{ authStore.user?.name }}</span>
                <button @click="handleLogout" class="text-gray-700 hover:text-indigo-600">
                  Logout
                </button>
              </div>
            </template>
            <template v-else>
              <RouterLink to="/login" class="text-gray-700 hover:text-indigo-600 font-medium">Login</RouterLink>
              <RouterLink to="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium transition">Sign Up</RouterLink>
            </template>
          </div>
        </div>
      </div>
    </nav>
</template>