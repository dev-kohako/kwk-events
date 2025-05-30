<script setup lang="ts">
import Navbar from "@/components/Navbar.vue";
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
</script>

<template> 
  <Toaster richColors position="top-right" />
  <Navbar />
  <div class="flex min-h-screen flex-col justify-center items-center px-6">
    <slot />
  </div>
</template>
