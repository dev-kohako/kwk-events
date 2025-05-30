<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import * as z from "zod";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";

import { 
  FormField,
  FormItem,
  FormLabel,
  FormControl,
  FormMessage,
} from "@/components/ui/form";

import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { passwordSchema } from "@/schemas/profile/password.schema";

const { handleSubmit, errors, resetForm, setErrors, values, validate } = useForm({
  validationSchema: passwordSchema,
  initialValues: {
    current_password: "",
    password: "",
    password_confirmation: "",
  },
});

const currentPasswordInput = ref<HTMLInputElement | null>(null);
const passwordInput = ref<HTMLInputElement | null>(null);

const isSubmitting = ref(false);

const onSubmit = handleSubmit(async (values) => {
  isSubmitting.value = true;
  try {
    await router.put(
      route("password.update"),
      values,
      {
        preserveScroll: true,
        onSuccess: () => {
          resetForm();
        },
        onError: (serverErrors) => {
          setErrors(serverErrors);

          if (serverErrors.password) {
            passwordInput.value?.focus();
          } else if (serverErrors.current_password) {
            currentPasswordInput.value?.focus();
          }
        },
        onFinish: () => {
          isSubmitting.value = false;
        },
      }
    );
  } catch (e) {
    isSubmitting.value = false;
  }
});

</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium">Atualizar Senha</h2>
      <p class="mt-1 text-sm text-muted-foreground">
        Garanta que sua conta está usando uma senha longa e aleatória para se manter segura.
      </p>
    </header>

    <form @submit.prevent="onSubmit" class="mt-6 space-y-6">
      <FormField name="current_password" v-slot="{ field }">
        <FormItem>
          <FormLabel for="current_password">Senha Atual</FormLabel>
          <FormControl>
            <Input
              id="current_password"
              v-bind="field"
              type="password"
              autocomplete="current-password"
              ref="currentPasswordInput"
              class="mt-1 block w-full"
            />
          </FormControl>
          <FormMessage class="mt-2" :name="'current_password'" />
        </FormItem>
      </FormField>

      <FormField name="password" v-slot="{ field }">
        <FormItem>
          <FormLabel for="password">Nova Senha</FormLabel>
          <FormControl>
            <Input
              id="password"
              v-bind="field"
              type="password"
              autocomplete="new-password"
              ref="passwordInput"
              class="mt-1 block w-full"
            />
          </FormControl>
          <FormMessage class="mt-2" :name="'password'" />
        </FormItem>
      </FormField>

      <FormField name="password_confirmation" v-slot="{ field }">
        <FormItem>
          <FormLabel for="password_confirmation">Confirmar Nova Senha</FormLabel>
          <FormControl>
            <Input
              id="password_confirmation"
              v-bind="field"
              type="password"
              autocomplete="new-password"
              class="mt-1 block w-full"
            />
          </FormControl>
          <FormMessage class="mt-2" :name="'password_confirmation'" />
        </FormItem>
      </FormField>

      <div class="flex items-center gap-4">
        <Button :disabled="isSubmitting" type="submit">Salvar</Button>

        <transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="!isSubmitting && Object.keys(errors).length === 0 && values.current_password === '' && values.password === '' && values.password_confirmation === ''" class="text-sm text-gray-600">
            Salvo.
          </p>
        </transition>
      </div>
    </form>
  </section>
</template>
