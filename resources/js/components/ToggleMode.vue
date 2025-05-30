<script setup lang="ts">
import { Icon } from '@iconify/vue'
import { useColorMode } from '@vueuse/core'
import { Button } from '@/components/ui/button'

const colorMode = useColorMode()

function toggleTheme() {
  colorMode.value = colorMode.value === 'dark' ? 'light' : 'dark'
}
</script>

<template>
  <Button
    variant="outline"
    size="icon"
    class="w-8 h-8 relative"
    @click="toggleTheme"
    aria-label="Toggle theme"
  >
    <Icon
      icon="radix-icons:moon"
      class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"
    />
    <Icon
      icon="radix-icons:sun"
      class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"
    />
    <span class="sr-only">Toggle theme</span>
  </Button>
</template>
