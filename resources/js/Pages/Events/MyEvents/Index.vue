<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Event, Paginated } from "@/types";
import { Icon } from "@iconify/vue";
import { router } from "@inertiajs/vue3";
import { getDayOfMonth, getShortMonth, getTime } from "@/utils/date";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogClose,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Card, CardFooter, CardHeader } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { Button } from "@/components/ui/button";
import { RouteParams } from "../../../../../vendor/tightenco/ziggy/src/js";
import { notify } from "@/utils/notify";

defineProps<{
  events?: Paginated<Event>;
}>();

const onDeleteEvent = (uuid: string) => {
  router.delete(route("events.destroy", uuid), {
    preserveScroll: true,
    onSuccess: () => {
      notify.success("Evento excluído com sucesso!");
    },
    onError: (errors) => {
      notify.error("Erro ao excluir o evento.");
      console.error(errors);
    },
  });
};

function goToPage(page: number) {
  router.get(
    "/events/my-events/",
    { page },
    { preserveScroll: true, preserveState: true }
  );
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Meus eventos" />

    <template v-if="events?.data?.length">
      <div class="relative flex flex-col items-center max-w-7xl w-full">
        <div class="relative flex flex-col items-center justify-start w-full max-w-7xl">
          <div class="relative w-full">
            <header class="flex justify-between items-center">
              <h1 class="text-center sm:text-start sm:text-3xl font-black uppercase">
                KWK - <span class="font-bold">Meus Eventos</span>
              </h1>
              <Link :href="route('events.create')" aria-label="Criar novo evento">
                <Button variant="outline">Criar Evento</Button>
              </Link>
            </header>
            <Separator class="my-4" aria-hidden="true" />

            <main class="w-full" aria-labelledby="events-heading">
              <h2 id="events-heading" class="sr-only">Lista de meus eventos</h2>

              <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                <article
                  v-for="event in events.data"
                  :key="event.id"
                  class="relative group overflow-hidden rounded-xl shadow-xl transition-all"
                  :aria-labelledby="`event-${event.id}-title`"
                  :aria-describedby="`event-${event.id}-date event-${event.id}-location`"
                >
                  <Card class="flex flex-col justify-center items-center h-full">
                    <Badge
                      v-if="['Cancelado', 'Expirado'].includes(event.status_label)"
                      class="bg-foreground text-background font-semibold absolute top-3 right-3 text-center rounded-full px-3"
                      :aria-label="`Status: ${event.status_label}`"
                    >
                      {{ event.status_label }}
                    </Badge>
                    <CardHeader
                      class="flex justify-center items-center min-h-44 max-h-44 h-full w-full bg-gradient-to-br from-fuchsia-600 to-violet-600"
                    >
                      <h3
                        :id="`event-${event.id}-title`"
                        class="text-3xl text-center font-bold my-6 text-white"
                      >
                        {{ event.name }}
                      </h3>
                    </CardHeader>

                    <CardFooter class="pt-6">
                      <div class="flex justify-center items-center">
                        <div
                          :id="`event-${event.id}-date`"
                          class="text-center"
                          aria-label="Data do evento"
                        >
                          <p class="text-lg">{{ getShortMonth(event.starts_at) }}</p>
                          <p class="text-3xl font-bold">
                            {{ getDayOfMonth(event.starts_at) }}
                          </p>
                        </div>
                        <Separator
                          orientation="vertical"
                          class="mx-4 h-16"
                          aria-hidden="true"
                        />
                        <div :id="`event-${event.id}-location`" class="space-y-0.5">
                          <div class="flex justify-start items-center gap-1">
                            <Icon
                              icon="hugeicons:maps-location-01"
                              width="20"
                              height="20"
                              aria-hidden="true"
                            />
                            <p class="truncate text-sm max-w-[180px] sm:max-w-[220px]">
                              <span class="sr-only">Local:</span>
                              {{ event.address }} - {{ event.city }}
                            </p>
                          </div>
                          <div class="flex justify-start items-center gap-1">
                            <Icon
                              icon="quill:clock"
                              width="18"
                              height="18"
                              aria-hidden="true"
                            />
                            <p class="text-sm">
                              <span class="sr-only">Horário de início:</span>
                              {{ getTime(event.starts_at) }}
                            </p>
                          </div>
                          <div class="flex justify-start items-center gap-1">
                            <Icon
                              icon="quill:clock"
                              width="18"
                              height="18"
                              aria-hidden="true"
                            />
                            <p class="text-sm">
                              <span class="sr-only">Horário de término:</span>
                              {{ getTime(event.ends_at) }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </CardFooter>
                  </Card>

                  <div
                    class="absolute bottom-0 h-full max-h-[7.1em] left-0 right-0 border-t-0 rounded-b-xl bg-zinc-950/20 dark:bg-zinc-950/50 backdrop-blur-sm p-6 flex flex-col justify-center items-center pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out"
                  >
                    <h3
                      class="text-xl font-semibold pointer-events-auto pb-4 truncate max-w-[320px]"
                    >
                      Meu Evento: {{ event.name }}
                    </h3>
                    <div class="w-full flex justify-center gap-2">
                      <Link
                        class="pointer-events-auto"
                        :href="route('events.show', event.uuid_code)"
                        :aria-label="`Ver detalhes do evento ${event.name}`"
                      >
                        <Button class="mb-1">Ver Detalhes</Button>
                      </Link>
                      <Link
                        class="pointer-events-auto"
                        :href="route('events.edit', event.uuid_code)"
                        :aria-label="`Editar evento ${event.name}`"
                      >
                        <Button>Editar</Button>
                      </Link>
                      <Dialog>
                        <DialogTrigger as-child>
                          <Button
                            variant="destructive"
                            class="pointer-events-auto"
                            aria-label="Excluir evento"
                          >
                            Excluir Evento
                          </Button>
                        </DialogTrigger>
                        <DialogContent class="sm:max-w-[425px]">
                          <DialogHeader>
                            <DialogTitle>Confirmar exclusão de evento</DialogTitle>
                            <DialogDescription>
                              Esta ação é irreversível. Você deseja realmente excluir este
                              evento?
                            </DialogDescription>
                          </DialogHeader>
                          <DialogFooter class="sm:space-x-1 mt-2">
                            <DialogClose as-child>
                              <Button type="button" variant="secondary">Cancelar</Button>
                            </DialogClose>
                            <Button
                              variant="destructive"
                              @click="onDeleteEvent(event.uuid_code)"
                            >
                              Confirmar Exclusão
                            </Button>
                          </DialogFooter>
                        </DialogContent>
                      </Dialog>
                    </div>
                  </div>
                </article>
              </div>

              <Pagination
                :items-per-page="events?.per_page ?? 10"
                :total="events?.total ?? 0"
                :default-page="events?.current_page ?? 1"
                v-slot="{ page }"
                class="mt-6"
                aria-label="Navegação de páginas"
              >
                <PaginationContent v-slot="{ items }">
                  <PaginationPrevious
                    @click="goToPage((events?.current_page ?? 1) - 1)"
                    aria-label="Página anterior"
                  />

                  <template v-for="(item, index) in items" :key="index">
                    <PaginationItem
                      v-if="item.type === 'page'"
                      :value="item.value"
                      :is-active="item.value === (events?.current_page ?? 1)"
                      @click="goToPage(item.value)"
                      :aria-label="`Ir para página ${item.value}`"
                      :aria-current="
                        item.value === (events?.current_page ?? 1) ? 'page' : undefined
                      "
                    >
                      {{ item.value }}
                    </PaginationItem>
                  </template>

                  <PaginationEllipsis :index="4" aria-hidden="true" />
                  <PaginationNext
                    @click="goToPage((events?.current_page ?? 1) + 1)"
                    aria-label="Próxima página"
                  />
                </PaginationContent>
                <div
                  class="flex justify-center items-center text-sm text-muted-foreground"
                >
                  <span v-if="events?.data.length" class="text-nowrap">
                    {{ events?.to }} de {{ events?.total }} eventos
                  </span>
                </div>
              </Pagination>
            </main>
          </div>
        </div>
      </div>
    </template>

    <template v-else>
      <main
        class="flex justify-center items-center w-full h-[calc(100vh-16rem)]"
        aria-live="polite"
      >
        <div class="text-center space-y-4">
          <p class="text-2xl font-bold mb-2">Nenhum evento disponível</p>
          <Link :href="route('events.create')">
            <Button variant="outline">Criar seu primeiro evento</Button>
          </Link>
        </div>
      </main>
    </template>
  </AuthenticatedLayout>
</template>
