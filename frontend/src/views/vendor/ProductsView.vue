<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useProductStore } from '@/stores/product'

const router = useRouter()
const productStore = useProductStore()

const products = ref<any[]>([])
const loading = ref(true)
const showModal = ref(false)
const editingProduct = ref<any>(null)

const form = ref({
  name: '',
  category_id: '',
  description: '',
  price: '',
  stock: '',
  image: '',
})

onMounted(async () => {
  await productStore.fetchCategories()
  await fetchProducts()
})

async function fetchProducts() {
  loading.value = true
  try {
    const response = await api.get('/vendor/products')
    products.value = response.data
  } catch (error) {
    console.error('Error fetching products:', error)
  } finally {
    loading.value = false
  }
}

function openModal(product?: any) {
  if (product) {
    editingProduct.value = product
    form.value = {
      name: product.name,
      category_id: product.category_id,
      description: product.description || '',
      price: product.price,
      stock: product.stock,
      image: product.image || '',
    }
  } else {
    editingProduct.value = null
    form.value = {
      name: '',
      category_id: '',
      description: '',
      price: '',
      stock: '',
      image: '',
    }
  }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  editingProduct.value = null
}

async function saveProduct() {
  try {
    if (editingProduct.value) {
      await api.put(`/vendor/products/${editingProduct.value.id}`, form.value)
    } else {
      await api.post('/vendor/products', form.value)
    }
    await fetchProducts()
    closeModal()
  } catch (error) {
    console.error('Error saving product:', error)
  }
}

async function deleteProduct(id: number) {
  if (!confirm('Are you sure you want to delete this product?')) return
  
  try {
    await api.delete(`/vendor/products/${id}`)
    await fetchProducts()
  } catch (error) {
    console.error('Error deleting product:', error)
  }
}
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
      <div>
        <button @click="router.push('/vendor')" class="text-indigo-600 hover:text-indigo-800 mb-2 flex items-center gap-1">
          ← Back to Dashboard
        </button>
        <h1 class="text-3xl font-bold text-gray-900">Manage Products</h1>
      </div>
      <button @click="openModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add Product
      </button>
    </div>
    
    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
    
    <div v-else-if="products.length === 0" class="text-center py-12 bg-white rounded-xl shadow-md">
      <p class="text-gray-500 text-lg">No products yet</p>
      <button @click="openModal()" class="mt-4 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
        Add Your First Product
      </button>
    </div>
    
    <div v-else class="bg-white rounded-xl shadow-md overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="product in products" :key="product.id">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <img :src="product.image" :alt="product.name" class="h-12 w-12 rounded-lg object-cover" />
                <span class="ml-4 font-medium text-gray-900">{{ product.name }}</span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ product.category?.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">${{ product.price }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span :class="product.stock > 10 ? 'text-green-600' : 'text-orange-600'">{{ product.stock }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <button @click="openModal(product)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
              <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          {{ editingProduct ? 'Edit Product' : 'Add New Product' }}
        </h2>
        
        <form @submit.prevent="saveProduct" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Product Name</label>
            <input v-model="form.name" type="text" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select v-model="form.category_id" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Select category</option>
              <option v-for="cat in productStore.categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea v-model="form.description" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
          </div>
          
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Price</label>
              <input v-model="form.price" type="number" step="0.01" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Stock</label>
              <input v-model="form.stock" type="number" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700">Image URL</label>
            <input v-model="form.image" type="url" placeholder="https://..." class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" />
          </div>
          
          <div class="flex gap-4 pt-4">
            <button type="button" @click="closeModal" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
              Cancel
            </button>
            <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
              {{ editingProduct ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
