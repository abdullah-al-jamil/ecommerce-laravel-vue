<script setup lang="ts">
import { RouterView } from 'vue-router'
import Footer from '@/components/Footer.vue'
import Navbar from './components/Navbar.vue'


</script>

<template>
  <div class="min-h-screen bg-gray-50">
    
    <Navbar />
    <main>
      <RouterView />
    </main>

    <Footer />
  </div>
</template>
