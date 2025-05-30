<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useResetPassword } from './useResetPassword';
import {
  FormControl,
  FormLabel,
  FormMessage,
  FormField,
  FormItem,
} from '@/components/ui/form';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Loader2 } from 'lucide-vue-next';

const props = defineProps<{
  email: string;
  token: string;
}>();

const { onSubmit, isSubmitting, errors, MIN_PASSWORD_LENGTH } = useResetPassword(
  props.email,
  props.token
);
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Redefinir Senha - KWK</title>
      <meta name="description" content="Redefina sua senha de acesso" />
    </Head>

    <div class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24">
      <div class="w-full max-w-96 space-y-6">
        <form
          @submit.prevent="onSubmit"
          class="space-y-4 rounded-xl w-full border p-4 lg:p-8 relative"
          aria-labelledby="reset-password-title"
        >
          <h1 id="reset-password-title" class="text-2xl font-bold text-center">
            Redefinir Senha
          </h1>

          <input type="hidden" name="token" :value="token">

          <FormField name="email" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="reset-email">E-mail</FormLabel>
              <FormControl>
                <Input
                  id="reset-email"
                  type="email"
                  v-bind="componentField"
                  placeholder="seu@email.com"
                  autocomplete="username"
                  :disabled="isSubmitting"
                  aria-describedby="email-error"
                />
              </FormControl>
              <FormMessage id="email-error" />
            </FormItem>
          </FormField>

          <FormField name="password" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="reset-password">Nova Senha</FormLabel>
              <FormControl>
                <Input
                  id="reset-password"
                  type="password"
                  v-bind="componentField"
                  :placeholder="`Mínimo ${MIN_PASSWORD_LENGTH} caracteres`"
                  autocomplete="new-password"
                  :disabled="isSubmitting"
                  aria-describedby="password-error"
                />
              </FormControl>
              <FormMessage id="password-error" />
            </FormItem>
          </FormField>

          <FormField name="password_confirmation" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="reset-password-confirmation">Confirmar Senha</FormLabel>
              <FormControl>
                <Input
                  id="reset-password-confirmation"
                  type="password"
                  v-bind="componentField"
                  placeholder="Digite a senha novamente"
                  autocomplete="new-password"
                  :disabled="isSubmitting"
                  aria-describedby="password-confirmation-error"
                />
              </FormControl>
              <FormMessage id="password-confirmation-error" />
            </FormItem>
          </FormField>

          <div class="flex justify-end pt-2">
            <Button
              type="submit"
              :disabled="isSubmitting"
              class="w-full sm:w-auto"
            >
              <Loader2
                v-if="isSubmitting"
                class="mr-2 h-4 w-4 animate-spin"
              />
              {{ isSubmitting ? 'Redefinindo...' : 'Redefinir Senha' }}
            </Button>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>