<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfirmPassword } from './useConfirmPassword';
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

const { onSubmit, isSubmitting, errors } = useConfirmPassword();
</script>

<template>
  <GuestLayout>
    <Head>
      <title>Confirmar Senha - KWK</title>
      <meta name="description" content="Confirme sua senha para continuar" />
    </Head>

    <div class="relative flex min-h-screen flex-col items-center justify-center w-full max-w-96 py-24 max-lg:landscape:py-24">
      <div class="w-full max-w-96 space-y-6">
        <p class="text-sm text-muted-foreground">
          Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
        </p>

        <form
          @submit.prevent="onSubmit"
          class="space-y-4 rounded-xl w-full border p-4 lg:p-8 relative"
          aria-labelledby="confirm-password-title"
        >
          <h1 id="confirm-password-title" class="text-2xl font-bold text-center">
            Confirmar Senha
          </h1>

          <FormField name="password" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="password">Senha</FormLabel>
              <FormControl>
                <Input
                  id="password"
                  type="password"
                  v-bind="componentField"
                  placeholder="Digite sua senha"
                  autocomplete="current-password"
                  :disabled="isSubmitting"
                  aria-describedby="password-error"
                />
              </FormControl>
              <FormMessage id="password-error" />
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
              {{ isSubmitting ? 'Confirmando...' : 'Confirmar' }}
            </Button>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>