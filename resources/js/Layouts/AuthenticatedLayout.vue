<script setup lang="ts">
import Navbar from "@/components/Navbar.vue";
import { Toaster } from "@/components/ui/sonner";
import "vue-sonner/style.css";
</script>

<template>
  <Navbar />
  <Toaster richColors position="top-right" />

  <main class="flex min-h-screen h-full py-20 md:pt-28 flex-col items-center px-6">
    <slot />
  </main>
</template>
