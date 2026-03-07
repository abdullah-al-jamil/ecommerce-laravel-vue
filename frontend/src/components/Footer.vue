
<script setup>
const currentYear = new Date().getFullYear()
</script>
<template>
    <!-- <footer class="bg-gray-800 text-white py-8 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <span class="text-2xl font-bold">Shop</span>
            <p class="text-gray-400 mt-2">Your one-stop shop for everything</p>
          </div>
          <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-white">About</a>
            <a href="#" class="text-gray-400 hover:text-white">Contact</a>
            <a href="#" class="text-gray-400 hover:text-white">Privacy</a>
          </div>
        </div>
        <div class="mt-8 text-center text-gray-400">
          &copy; 2026 Shop. All rights reserved.
        </div>
      </div>
    </footer> -->

<!-- src/components/FooterMinimal.vue -->

  <footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Simple Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        
        <!-- Logo Column -->
        <div class="col-span-2 md:col-span-1">
          <router-link to="/" class="text-xl font-bold hover:text-gray-300">
            ShopHub
          </router-link>
          <p class="text-sm text-gray-400 mt-2">
            © {{ currentYear }} All rights reserved.
          </p>
        </div>

        <!-- Links -->
        <div>
          <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-gray-400">Shop</h4>
          <ul class="space-y-2 text-sm">
            <li><router-link to="/products" class="text-gray-300 hover:text-white">Products</router-link></li>
            <li><router-link to="/categories" class="text-gray-300 hover:text-white">Categories</router-link></li>
            <li><router-link to="/deals" class="text-gray-300 hover:text-white">Deals</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-gray-400">Support</h4>
          <ul class="space-y-2 text-sm">
            <li><router-link to="/contact" class="text-gray-300 hover:text-white">Contact</router-link></li>
            <li><router-link to="/faq" class="text-gray-300 hover:text-white">FAQ</router-link></li>
            <li><router-link to="/shipping" class="text-gray-300 hover:text-white">Shipping</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-3 text-sm uppercase tracking-wider text-gray-400">Legal</h4>
          <ul class="space-y-2 text-sm">
            <li><router-link to="/privacy" class="text-gray-300 hover:text-white">Privacy</router-link></li>
            <li><router-link to="/terms" class="text-gray-300 hover:text-white">Terms</router-link></li>
          </ul>
        </div>
      </div>

      <!-- Social Icons -->
      <div class="flex justify-center space-x-4 mt-8 pt-4 border-t border-gray-700">
        <a href="#" class="text-gray-400 hover:text-white">
          <span class="sr-only">Facebook</span>
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
          </svg>
        </a>
        <a href="#" class="text-gray-400 hover:text-white">
          <span class="sr-only">Twitter</span>
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
          </svg>
        </a>
        <a href="#" class="text-gray-400 hover:text-white">
          <span class="sr-only">Instagram</span>
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
          </svg>
        </a>
      </div>
    </div>
  </footer>
</template>

