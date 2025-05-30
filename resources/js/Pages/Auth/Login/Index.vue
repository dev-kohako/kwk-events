<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useLogin } from "./useLogin";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Loader2 } from "lucide-vue-next";

defineProps<{
  canResetPassword?: boolean;
  status?: string;
}>();

const FORM_ID = "login-form";
const { onSubmit, isSubmitting, meta } = useLogin();
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Login - KWK</title>
      <meta name="description" content="Faça login para acessar sua conta" />
    </Head>

    <main
      class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24"
    >
      <form
        :id="FORM_ID"
        @submit.prevent="onSubmit"
        class="space-y-4 rounded-xl w-full border p-4 lg:p-8"
        aria-labelledby="login-title"
      >
        <h1 id="login-title" class="text-2xl font-bold text-center">Acesse sua conta</h1>

        <FormField name="email" v-slot="{ componentField }">
          <FormItem>
            <FormLabel for="login-email">E-mail</FormLabel>
            <FormControl>
              <Input
                id="login-email"
                type="email"
                v-bind="componentField"
                placeholder="seu@email.com"
                autocomplete="email"
                aria-describedby="email-help"
                :disabled="isSubmitting"
              />
            </FormControl>
            <FormMessage id="email-help" />
          </FormItem>
        </FormField>

        <FormField name="password" v-slot="{ componentField }">
          <FormItem>
            <div class="flex items-center justify-between">
              <FormLabel for="login-password">Senha</FormLabel>
            </div>
            <FormControl>
              <Input
                id="login-password"
                type="password"
                v-bind="componentField"
                placeholder="••••••••"
                autocomplete="current-password"
                aria-describedby="password-help"
                :disabled="isSubmitting"
              />
            </FormControl>
            <FormMessage id="password-help" />
          </FormItem>
        </FormField>

        <FormField name="remember" v-slot="{ componentField }">
          <FormItem>
            <div class="flex items-center gap-2">
              <FormControl>
                <Checkbox
                  id="remember-me"
                  :modelValue="
                    componentField.modelValue === true ||
                    componentField.modelValue === 'on'
                  "
                  @update:modelValue="componentField.onChange"
                  :disabled="isSubmitting"
                />
              </FormControl>
              <FormLabel for="remember-me" class="!mt-0 cursor-pointer">
                Manter conectado
              </FormLabel>
            </div>
            <FormMessage />
          </FormItem>
        </FormField>

        <Button type="submit" class="w-full" :disabled="isSubmitting || !meta.dirty">
          <Loader2 v-if="isSubmitting" class="mr-2 h-4 w-4 animate-spin" />
          {{ isSubmitting ? "Entrando..." : "Entrar" }}
        </Button>

        <div class="space-y-2">
          <p class="text-sm text-center text-muted-foreground">
            Não tem uma conta?
            <Link
              :href="route('register')"
              class="font-medium text-primary underline hover:text-primary/80"
              aria-label="Cadastre-se"
            >
              Cadastre-se
            </Link>
          </p>
          <p class="text-sm text-center text-muted-foreground">
            Esqueceu sua senha?
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm font-medium text-primary underline hover:text-primary/80"
              aria-label="Recuperar senha"
            >
              Recuperar
            </Link>
          </p>
        </div>
      </form>
    </main>
  </GuestLayout>
</template>
