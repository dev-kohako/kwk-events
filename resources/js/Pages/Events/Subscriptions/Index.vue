<template>
  <Head title="Events" />
  <Navbar />
  <div class="flex justify-center items-start">
    <div
      class="relative flex min-h-screen flex-col items-center justify-start w-full max-w-7xl py-24 max-lg:landscape:py-24 px-8 2xl:px-0"
    >
      <div class="relative w-full">
        <h1 class="text-center text-4xl font-black uppercase mb-4">
          KWK - <span class="font-bold">Eventos</span>
        </h1>
        <Separator />
        <main class="mt-6">
          <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div
              v-for="event in events?.data"
              :key="event.id"
              class="relative group overflow-hidden rounded-xl shadow-xl transition-all"
            >
              <Card
                :class="[
                  'flex flex-col justify-center items-center h-full',
                  {
                    '':
                      event.status_label === 'Cancelado' ||
                      event.status_label === 'Expirado',
                    '': event.status_label === 'Ativo',
                  },
                ]"
              >
                <Badge
                  v-if="
                    event.status_label === 'Cancelado' ||
                    event.status_label === 'Expirado'
                  "
                  class="bg-transparent border border-border absolute top-3 right-3 text-center rounded-full"
                >
                  {{ event.status_label }}
                </Badge>

                <CardHeader
                  class="flex justify-center items-center min-h-44 max-h-44 h-full w-full bg-gradient-to-br from-fuchsia-600 to-violet-800"
                >
                  <h1 class="text-3xl text-center font-bold my-6 text-white">
                    {{ event.name }}
                  </h1>
                </CardHeader>

                <CardFooter class="pt-6">
                  <div class="flex justify-center items-center">
                    <div class="text-center">
                      <p class="text-lg">{{ getShortMonth(event.starts_at) }}</p>
                      <p class="text-3xl font-bold">{{ getDayOfMonth(event.starts_at) }}</p>
                    </div>
                    <Separator orientation="vertical" class="mx-4 h-16" />
                    <div class="space-y-0.5">
                      <div class="flex justify-start items-center gap-1">
                        <Icon icon="hugeicons:maps-location-01" width="20" height="20" />
                        <p class="truncate text-sm w-full max-w-[180px] sm:max-w-[220px]">
                          Local: {{ event.address }} - {{ event.city }}
                        </p>
                      </div>
                      <div class="flex justify-start items-center gap-1">
                        <Icon icon="quill:clock" width="18" height="18" />
                        <p class="flex text-sm items-center text-center gap-1">
                          Início: {{ getTime(event.starts_at) }}
                        </p>
                      </div>
                      <div class="flex justify-start items-center gap-1">
                        <Icon icon="quill:clock" width="18" height="18" />
                        <p class="flex text-sm items-center text-center gap-1">
                          Fim: {{ getTime(event.ends_at) }}
                        </p>
                      </div>
                    </div>
                  </div>
                </CardFooter>
              </Card>

              <div
                class="absolute inset-0 border rounded-xl bg-black/50 backdrop-blur-sm p-6 flex flex-col justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
              >
                <h2 class="text-xl font-semibold pointer-events-auto">
                  {{ event.name }}
                </h2>
                <p class="mt-2 pointer-events-auto">Savor exquisite flavors</p>
                <Button class="pointer-events-auto"> Reservar </Button>
              </div>
            </div>
          </div>

          <div class="text-sm py-2 text-right">
            <span class="font-medium">{{ events?.from }}</span> a
            <span class="font-medium">{{ events?.to }}</span> de
            <span class="font-medium">{{ events?.total }}</span> resultados
          </div>

          <Pagination
            :items-per-page="events?.per_page ?? 10"
            :total="events?.total ?? 0"
            :default-page="events?.current_page ?? 1"
            v-slot="{ page }"
            class="mt-0"
          >
            <PaginationContent v-slot="{ items }">
              <PaginationPrevious @click="goToPage((events?.current_page ?? 1) - 1)" />

              <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                  v-if="item.type === 'page'"
                  :value="item.value"
                  :is-active="item.value === (events?.current_page ?? 1)"
                  @click="goToPage(item.value)"
                >
                  {{ item.value }}
                </PaginationItem>
              </template>

              <PaginationEllipsis :index="4" />
              <PaginationNext @click="goToPage((events?.current_page ?? 1) + 1)" />
            </PaginationContent>
          </Pagination>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Navbar from "@/components/Navbar.vue";
import { router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination";
import { Card, CardFooter, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { getDayOfMonth, getShortMonth, getTime } from "@/utils/date";


import { Event, Paginated } from "@/types";

defineProps<{
  events?: Paginated<Event>;
}>();

function goToPage(page: number) {
  router.get("/events/subscriptions", { page }, { preserveScroll: true, preserveState: true });
}

</script>
