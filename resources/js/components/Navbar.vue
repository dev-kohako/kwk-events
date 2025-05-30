<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Separator } from "@/components/ui/separator";
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";
import { X, Menu } from "lucide-vue-next";
import ToggleMode from "./ToggleMode.vue";
import { Button } from "@/components/ui/button";

const props = defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

const mobileMenuOpen = ref(false);
const isScrolled = ref(false);

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value;
  document.body.style.overflow = mobileMenuOpen.value ? "hidden" : "auto";
}

function closeMobileMenu() {
  mobileMenuOpen.value = false;
  document.body.style.overflow = "auto";
}

function handleScroll() {
  isScrolled.value = window.scrollY > 10;
}

function handleKeyDown(e) {
  if (e.key === "Escape" && mobileMenuOpen.value) {
    closeMobileMenu();
  }
}

onMounted(() => {
  window.addEventListener("scroll", handleScroll);
  document.addEventListener("keydown", handleKeyDown);
});

onUnmounted(() => {
  window.removeEventListener("scroll", handleScroll);
  document.removeEventListener("keydown", handleKeyDown);
  document.body.style.overflow = "auto";
});
</script>

<template>
  <header
    class="absolute w-full top-0 z-50 border-b border-border bg-background/50 transition-all"
    :class="{ 'shadow-sm': isScrolled }"
  >
    <nav
      class="max-w-7xl mx-auto w-full flex items-center justify-between px-8 2xl:px-0 py-2"
    >
      <Link
        href="/"
        class="text-xl font-black hover:opacity-80 transition-opacity"
        aria-label="Página inicial"
        @click="closeMobileMenu"
      >
        KWK.
      </Link>

      <div class="hidden md:flex justify-center items-center">
        <DropdownMenu v-if="$page.props.auth.user">
          <DropdownMenuTrigger as-child>
            <Button variant="link" class="p-0">
              {{ $page.props.auth.user.name }}
              <Icon icon="lucide:chevron-down" width="24" height="24" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-56">
            <DropdownMenuLabel>Perfil</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
              <DropdownMenuItem as-child>
                <Link class="w-full h-full" :href="route('profile.edit')">Conta</Link>
              </DropdownMenuItem>

              <DropdownMenuItem as-child>
                <Link :href="route('events')">Eventos</Link>
              </DropdownMenuItem>

              <DropdownMenuItem as-child>
                <Link :href="route('events.create')">Criar evento</Link>
              </DropdownMenuItem>

              <DropdownMenuItem as-child>
                <Link :href="route('events.my-events')">Meus eventos</Link>
              </DropdownMenuItem>

              <DropdownMenuItem as-child>
                <Link :href="route('events.subscriptions')">Incrições</Link>
              </DropdownMenuItem>

              <DropdownMenuSeparator />

              <Link :href="route('logout')" method="post" as="button" class="w-full">
                <DropdownMenuItem> Sair </DropdownMenuItem>
              </Link>
            </DropdownMenuGroup>
          </DropdownMenuContent>
        </DropdownMenu>

        <template v-else>
          <Link href="/register" class="mr-2">
            <Button variant="outline"> Registrar </Button>
          </Link>
          <Link href="/login">
            <Button> Entrar </Button>
          </Link>
        </template>

        <Separator orientation="vertical" class="mx-4 min-h-8" />

        <ToggleMode />
      </div>

      <Button
        @click.stop="toggleMobileMenu"
        class="md:hidden rounded-md transition-colors z-50 flex justify-end -mr-1"
        variant="link"
        size="icon"
        :aria-expanded="mobileMenuOpen"
        aria-label="Alternar menu de navegação"
      >
        <Menu v-if="!mobileMenuOpen" class="w-6 h-6" />
        <X v-else class="w-6 h-6" />
      </Button>
    </nav>

    <transition
      enter-active-class="transition-opacity duration-300 ease-out"
      leave-active-class="transition-opacity duration-200 ease-in"
      enter-from-class="opacity-0"
      leave-to-class="opacity-0"
    >
      <div
        v-if="mobileMenuOpen"
        class="fixed inset-0 w-full h-screen bg-background backdrop-blur-sm flex flex-col justify-between pt-20"
      >
        <div class="flex w-full flex-col px-6">
          <Link :href="route('profile.edit')">
            <Button variant="link" class="p-0"> Conta </Button>
          </Link>
          <Link :href="route('events')">
            <Button variant="link" class="p-0"> Eventos </Button>
          </Link>
          <Link :href="route('events.create')">
            <Button variant="link" class="p-0"> Criar Evento </Button>
          </Link>
          <Link :href="route('events.my-events')">
            <Button variant="link" class="p-0"> Meus Eventos </Button>
          </Link>
          <Link :href="route('events.subscriptions')">
            <Button variant="link" class="p-0"> Inscrições </Button>
          </Link>
        </div>

        <Separator class="absolute bottom-0" />

        <div class="w-full flex justify-between items-center py-3 px-6 border-t">
          <h1 class="text-sm font-medium">
            {{ $page.props.auth.user.name }}
          </h1>
          <ToggleMode />
        </div>
      </div>
    </transition>
  </header>
</template>
