<script setup lang="ts">
import { ref, nextTick } from "vue";
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

import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { notify } from "@/utils/notify";

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const schema = toTypedSchema(
  z.object({
    password: z.string().min(1, "Senha é obrigatória"),
  })
);

const { handleSubmit, resetForm, setErrors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    password: "",
  },
});

const openDialog = () => {
  confirmingUserDeletion.value = true;
  nextTick(() => passwordInput.value?.focus());
};

const closeDialog = () => {
  confirmingUserDeletion.value = false;
  resetForm();
};

const onDeleteUser = handleSubmit(async (values) => {
  router.delete(route("profile.destroy"), {
    data: values,
    preserveScroll: true,
    onSuccess: () => {
      closeDialog();
      notify.success;
    },
    onError: (serverErrors) => {
      setErrors(serverErrors);
      nextTick(() => passwordInput.value?.focus());
    },
    onFinish: () => {
      resetForm();
    },
  });
});
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium">Excluir Conta</h2>
      <p class="mt-1 text-sm text-muted-foreground">
        Uma vez que sua conta for excluída, todos os seus dados e recursos serão removidos
        permanentemente. Antes de excluir, baixe as informações que desejar manter.
      </p>
    </header>

    <Dialog v-model:open="confirmingUserDeletion" @open="openDialog" @close="closeDialog">
      <DialogTrigger asChild>
        <Button variant="destructive">Excluir Conta</Button>
      </DialogTrigger>

      <DialogContent>
        <DialogHeader class="ml-0">
          <DialogTitle>Tem certeza que deseja excluir sua conta?</DialogTitle>
          <DialogDescription>
            Esta ação é irreversível. Digite sua senha para confirmar a exclusão
            permanente.
          </DialogDescription>
        </DialogHeader>

        <form @submit.prevent="onDeleteUser" class="mt-2">
          <FormField name="password" v-slot="{ field }">
            <FormItem>
              <FormLabel for="password" class="sr-only">Senha</FormLabel>
              <FormControl>
                <Input
                  id="password"
                  v-bind="field"
                  type="password"
                  placeholder="Senha"
                  ref="passwordInput"
                  autocomplete="current-password"
                  class="w-full"
                />
              </FormControl>
              <FormMessage class="mt-2" :name="'password'" />
            </FormItem>
          </FormField>

          <DialogFooter class="mt-8 flex justify-end gap-3">
            <Button variant="outline" type="button" @click="closeDialog">Cancelar</Button>
            <Button variant="destructive" type="submit" :disabled="isSubmitting">
              Excluir Conta
            </Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  </section>
</template>
