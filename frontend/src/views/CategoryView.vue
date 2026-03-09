<script setup lang="ts">
import { onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useProductStore } from '@/stores/product'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const productStore = useProductStore()
const cartStore = useCartStore()
const authStore = useAuthStore()

async function loadProducts() {
  const slug = route.params.slug as string

  await productStore.fetchCategories()

  const category = productStore.categories.find(
    (c) => c.slug === slug
  )

  const categoryId = category?.id

  productStore.fetchProducts({
    ...(categoryId ? { category_id: categoryId } : {}),
  })
}

onMounted(loadProducts)

watch(
  () => route.params.slug,
  () => {
    loadProducts()
  }
)

async function addToCart(productId: number) {
  if (!authStore.isAuthenticated) {
    router.push('/login')
    return
  }

  await cartStore.addToCart(productId, 1)
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 capitalize">{{ (route.params.slug as string).replace('-', ' ') }}</h1>
      <p class="text-gray-500 mt-2">Browse our collection</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div class="md:col-span-1">
        <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
          <h3 class="font-semibold text-gray-900 mb-4">Categories</h3>
          <div class="space-y-2">
            <RouterLink to="/" class="block text-gray-600 hover:text-indigo-600 py-1">All Products</RouterLink>
            <RouterLink
              v-for="category in productStore.categories"
              :key="category.id"
              :to="{ name: 'category', params: { slug: category.slug }, state: { categoryId: category.id } }"
              class="block text-gray-600 hover:text-indigo-600 py-1 capitalize"
            >
              {{ category.name }}
            </RouterLink>
          </div>
        </div>
      </div>
      
      <div class="md:col-span-3">
        <div v-if="productStore.loading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        </div>
        
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="product in productStore.products" :key="product.id" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <RouterLink :to="`/products/${product.slug}`">
              <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                <img :src="product.image" :alt="product.name" class="w-full h-56 object-cover hover:scale-105 transition-transform duration-300" />
              </div>
            </RouterLink>
            <div class="p-5">
              <RouterLink :to="`/products/${product.slug}`">
                <h3 class="text-lg font-semibold text-gray-900 mt-1 hover:text-indigo-600">{{ product.name }}</h3>
              </RouterLink>
              <div class="flex items-center justify-between mt-3">
                <span class="text-xl font-bold text-gray-900">${{ product.price }}</span>
                <button @click="addToCart(product.id)" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition text-sm">
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <div v-if="productStore.products.length === 0 && !productStore.loading" class="text-center py-12">
          <p class="text-gray-500 text-lg">No products found in this category</p>
        </div>
      </div>
    </div>
  </div>
</template>
