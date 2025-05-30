<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForgotPassword } from "./useForgotPassword";
import {
  FormControl,
  FormLabel,
  FormMessage,
  FormField,
  FormItem,
} from "@/components/ui/form";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Loader2 } from "lucide-vue-next";

defineProps<{
  status?: string;
}>();

const { onSubmit, isSubmitting, meta } = useForgotPassword();
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Recuperar Senha - KWK</title>
      <meta name="description" content="Recupere o acesso à sua conta" />
    </Head>

    <div class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24">
        <form
          @submit.prevent="onSubmit"
          class="space-y-4 rounded-xl w-full border p-4 lg:p-8 relative"
          aria-labelledby="forgot-password-title"
        >
          <h1 id="forgot-password-title" class="text-2xl font-bold text-center">
            Recuperar Senha
          </h1>

          <p class="text-sm text-muted-foreground">
            Esqueceu sua senha? Sem problemas. Informe seu e-mail cadastrado e enviaremos
            um link seguro para você criar uma nova senha.
          </p>

          <FormField name="email" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="forgot-email">E-mail</FormLabel>
              <FormControl>
                <Input
                  id="forgot-email"
                  type="email"
                  v-bind="componentField"
                  placeholder="seu@email.com"
                  autocomplete="email"
                  :disabled="isSubmitting"
                  aria-describedby="email-error"
                />
              </FormControl>
              <FormMessage id="email-error" />
            </FormItem>
          </FormField>

          <div class="flex justify-end pt-2">
            <Button
              type="submit"
              :disabled="isSubmitting || !meta.dirty"
              class="w-full sm:w-auto"
            >
              <Loader2
                v-if="isSubmitting"
                class="mr-2 h-4 w-4 animate-spin"
              />
              {{ isSubmitting ? 'Enviando...' : 'Enviar Link' }}
            </Button>
          </div>
        </form>
      </div>
  </GuestLayout>
</template>