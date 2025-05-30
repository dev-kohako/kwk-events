<script setup lang="ts">
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import * as z from "zod";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";
import { Badge } from "@/components/ui/badge";

import {
  FormField,
  FormItem,
  FormLabel,
  FormControl,
  FormMessage,
} from "@/components/ui/form";

import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";
import { updateProfile } from "@/schemas/profile/updateProfile.schema";

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>();

const user = usePage().props.auth.user;

const { handleSubmit, resetForm, setErrors } = useForm({
  validationSchema: updateProfile,
  initialValues: {
    name: user.name,
    email: user.email,
  },
});

const nameInput = ref<HTMLInputElement | null>(null);
const emailInput = ref<HTMLInputElement | null>(null);

const isSubmitting = ref(false);

const onSubmit = handleSubmit(async (values) => {
  isSubmitting.value = true;
  try {
    await router.patch(route("profile.update"), values, {
      preserveScroll: true,
      onSuccess: () => {
        resetForm({
          values,
        });
      },
      onError: (serverErrors) => {
        setErrors(serverErrors);
        if (serverErrors.name) {
          nameInput.value?.focus();
        } else if (serverErrors.email) {
          emailInput.value?.focus();
        }
      },
      onFinish: () => {
        isSubmitting.value = false;
      },
    });
  } catch (e) {
    isSubmitting.value = false;
  }
});
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium">Informações da conta</h2>

      <p class="mt-1 text-sm text-muted-foreground">
        Atualize as informações do perfil e o endereço de e-mail da sua conta.
      </p>
    </header>

    <form @submit.prevent="onSubmit" class="mt-6 space-y-6">
      <FormField name="name" v-slot="{ value, handleChange, errorMessage }">
        <FormItem>
          <FormLabel for="name">Nome</FormLabel>
          <FormControl>
            <Input
              id="name"
              type="text"
              autocomplete="name"
              autofocus
              class="mt-1 block w-full"
              :modelValue="value"
              @update:modelValue="handleChange"
              ref="nameInput"
            />
          </FormControl>
          <FormMessage class="mt-2">{{ errorMessage }}</FormMessage>
        </FormItem>
      </FormField>

      <FormField name="email" v-slot="{ value, handleChange, errorMessage }">
        <FormItem>
          <FormLabel for="email">E-mail</FormLabel>
          <FormControl>
            <Input
              id="email"
              type="email"
              autocomplete="username"
              class="mt-1 block w-full"
              :modelValue="value"
              @update:modelValue="handleChange"
              ref="emailInput"
            />
          </FormControl>
          <FormMessage class="mt-2" :name="'email'" />
        </FormItem>
      </FormField>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="mt-2 text-md text-primary">
          <Badge>Seu endereço de e-mail não foi verificado.</Badge>
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="text-sm hover:underline text-muted-foreground hover:text-primary/80"
          >
            Clique aqui para reenviar o e-mail de verificação.
          </Link>
        </p>

        <div
          v-show="status === 'verification-link-sent'"
          class="mt-2 text-sm font-medium text-green-600"
        >
          Um novo link de verificação foi enviado para seu e-mail.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <Button :disabled="isSubmitting" type="submit">Salvar</Button>
      </div>
    </form>
  </section>
</template>
