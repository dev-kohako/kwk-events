<!-- resources/js/Pages/Events/Show/Index.vue -->
<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Event } from "@/types";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardHeader,
  CardTitle,
  CardContent,
  CardFooter,
} from "@/components/ui/card";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { formatAddress } from "@/utils/address";
import { useShow } from "./useShow";

const props = defineProps<{ event: Event }>();

const { onSubscribe, onUnsubscribe, isSubmitting } = useShow(props.event);
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Evento" />

    <div class="flex flex-1 items-center justify-center w-full">
<Card class="w-full md:max-w-2xl relative shadow-md">
  <Badge
    v-if="event.is_full"
    class="bg-red-600 text-white absolute top-3 right-3 rounded-full px-3 py-1 text-sm font-semibold"
    :aria-label="`Status: ${event.status_label}`"
  >
    Evento Lotado
  </Badge>

  <CardHeader class="border-b pb-3 mb-3">
    <CardTitle class="text-3xl font-bold">
      {{ event.name }} em  {{ event.city }}
    </CardTitle>
    <p class="text-sm text-gray-600 mt-1">
      {{ formatAddress({
        address: event.address,
        number: event.number,
        complement: event.complement,
        city: event.city,
        state: event.state,
        zipcode: event.zipcode
      }) }}
    </p>
  </CardHeader>

  <CardContent class="space-y-4">
    <p>
      <strong>Descrição: </strong>
      <span class="text-gray-700">{{ event.description || "Sem descrição disponível." }}</span>
    </p>

    <p>
      <strong>Data Início: </strong>
      <span>{{ new Date(event.starts_at).toLocaleString() }}</span>
    </p>
    <p>
      <strong>Data Fim: </strong>
      <span>{{ new Date(event.ends_at).toLocaleString() }}</span>
    </p>

    <p>
      <strong>Inscritos:</strong>
      <span>{{ event.guests_count ?? 0 }} / {{ event.max_subscription ?? "Ilimitado" }}</span>
    </p>

  </CardContent>

  <CardFooter class="flex justify-end gap-2 px-6 py-4 border-t">
    <Button
      v-if="event.is_subscribed"
      variant="outline"
      :disabled="isSubmitting"
      @click="onUnsubscribe"
    >
      Cancelar inscrição
    </Button>

    <Button
      v-if="event.is_subscribed"
      disabled
      class="cursor-not-allowed"
    >
      Já inscrito
    </Button>

    <Button
      v-else
      :disabled="isSubmitting || event.is_full"
      @click="onSubscribe"
    >
      Inscrever-se
    </Button>
  </CardFooter>
</Card>

    </div>
  </AuthenticatedLayout>
</template>
