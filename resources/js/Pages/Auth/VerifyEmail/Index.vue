<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useEmailVerification } from "./useEmailVerification";
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";

defineProps<{
  status?: string;
}>();

const { onSubmit, isSubmitting, verificationLinkSent } = useEmailVerification(status);
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Verificação de E-mail - KWK</title>
      <meta name="description" content="Verifique seu endereço de e-mail" />
    </Head>

    <div
      class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24"
    >
      <div class="space-y-6">
        <div
          v-if="verificationLinkSent"
          class="p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg"
          role="alert"
        >
          Um novo link de verificação foi enviado para seu e-mail.
        </div>

        <form
          @submit.prevent="onSubmit"
          class="space-y-4 rounded-xl w-full border p-4 lg:p-8 relative"
          aria-labelledby="verification-title"
        >
          <h1 id="verification-title" class="text-2xl font-bold text-center">
            Verificação de E-mail
          </h1>

          <p class="text-sm text-muted-foreground">
            Obrigado por se registrar! Antes de começar, verifique seu e-mail clicando no
            link que enviamos. Se você não recebeu o e-mail, podemos enviar outro.
          </p>

          <Button type="submit" :disabled="isSubmitting" class="w-full">
            {{ isSubmitting ? "Enviando..." : "Reenviar e-mail de verificação" }}
          </Button>
        </form>
        <Link :href="route('logout')" method="post" as="button" class="w-full">
          <Button
            variant="outline"
            class="w-full"
            :href="route('logout')"
            method="post"
            as="button"
          >
            Sair da conta
          </Button>
        </Link>
      </div>
    </div>
  </GuestLayout>
</template>
