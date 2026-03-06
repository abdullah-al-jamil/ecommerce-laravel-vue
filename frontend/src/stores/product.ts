import { defineStore } from 'pinia'
import api from '@/services/api.ts'
import { ref } from 'vue'

export const useProductStore = defineStore('product', () => {
  const products = ref<any[]>([])
  const product = ref<any>(null)
  const categories = ref<any[]>([])
  const loading = ref(false)
  const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
  })

  async function fetchProducts(params: any = {}) {
    loading.value = true
    try {
      const response = await api.get('/products', { params })
      products.value = response.data.data
      pagination.value = {
        current_page: response.data.current_page,
        last_page: response.data.last_page,
        total: response.data.total,
      }
    } catch (error) {
      console.error('Error fetching products:', error)
    } finally {
      loading.value = false
    }
  }

  async function fetchProduct(slug: string) {
    loading.value = true
    try {
      const response = await api.get(`/products/${slug}`)
      product.value = response.data
    } catch (error) {
      console.error('Error fetching product:', error)
    } finally {
      loading.value = false
    }
  }

  async function fetchCategories() {
    try {
      const response = await api.get('/categories')
      categories.value = response.data
    } catch (error) {
      console.error('Error fetching categories:', error)
    }
  }

  return {
    products,
    product,
    categories,
    loading,
    pagination,
    fetchProducts,
    fetchProduct,
    fetchCategories,
  }
})
