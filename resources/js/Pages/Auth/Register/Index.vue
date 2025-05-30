<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { useRegister } from "./useRegister";
import { MIN_PASSWORD_LENGTH } from "@/schemas/auth/register.schema";

const FORM_ID = "register-form";
const { onSubmit, isSubmitting, meta } = useRegister();
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Criar Conta - KWK</title>
      <meta name="description" content="Crie sua conta no sistema KWK" />
    </Head>

    <main
      class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24"
    >
      <form
        :id="FORM_ID"
        @submit.prevent="onSubmit"
        class="space-y-4 rounded-xl w-full border p-4 lg:p-8"
        aria-labelledby="form-title"
      >
        <h1 class="text-2xl font-bold text-center">Acesse sua conta</h1>

        <fieldset :disabled="isSubmitting" class="space-y-4">
          <FormField name="name" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="name">Nome Completo</FormLabel>
              <FormControl>
                <Input
                  id="name"
                  type="text"
                  v-bind="componentField"
                  placeholder="Seu nome completo"
                  aria-describedby="name-help"
                  autocomplete="name"
                />
              </FormControl>
              <FormMessage id="name-help" />
            </FormItem>
          </FormField>

          <FormField name="email" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="email">E-mail</FormLabel>
              <FormControl>
                <Input
                  id="email"
                  type="email"
                  v-bind="componentField"
                  placeholder="seu@email.com"
                  aria-describedby="email-help"
                  autocomplete="email"
                />
              </FormControl>
              <FormMessage id="email-help" />
            </FormItem>
          </FormField>

          <FormField name="password" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="password">Senha</FormLabel>
              <FormControl>
                <Input
                  id="password"
                  type="password"
                  v-bind="componentField"
                  :placeholder="`Mínimo ${MIN_PASSWORD_LENGTH} caracteres`"
                  aria-describedby="password-help"
                  autocomplete="new-password"
                />
              </FormControl>
              <FormMessage id="password-help" />
            </FormItem>
          </FormField>

          <FormField name="password_confirmation" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="password_confirmation">Confirmar Senha</FormLabel>
              <FormControl>
                <Input
                  id="password_confirmation"
                  type="password"
                  v-bind="componentField"
                  placeholder="Digite a senha novamente"
                  aria-describedby="password-confirmation-help"
                  autocomplete="new-password"
                />
              </FormControl>
              <FormMessage id="password-confirmation-help" />
            </FormItem>
          </FormField>

          <Button type="submit" class="w-full" :disabled="isSubmitting || !meta.dirty">
            <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
            {{ isSubmitting ? "Registando..." : "Registrar" }}
          </Button>


            <p class="text-sm text-center text-muted-foreground">
              Já possuí conta?
              <Link
                :href="route('login')"
                class="text-sm font-medium text-primary underline hover:text-primary/80"
                aria-label="Já tem uma conta? Faça login"
              >
                Entrar
              </Link>
            </p>
          
        </fieldset>
      </form>
    </main>
  </GuestLayout>
</template>
