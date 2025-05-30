import { router } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { confirmPasswordSchema } from '@/schemas/auth/confirmPassword.schema';
import { notify } from '@/utils/notify';

export const useConfirmPassword = () => {
  type Field = 'password';

  const {
    handleSubmit,
    isSubmitting,
    errors,
    meta,
    setFieldError,
  } = useForm({
    validationSchema: toTypedSchema(confirmPasswordSchema),
    initialValues: {
      password: '',
    },
  });

const onSubmit = handleSubmit((values) => {
  router.post(route('password.confirm'), values, {
    onSuccess: () => {
      notify.success('Senha confirmada!', 'Você pode continuar agora');
    },
    onError: (errors) => {
      if (errors.message) {
        notify.error('Erro ao confirmar', errors.message);
        return;
      }

      Object.entries(errors).forEach(([field, message]) => {
        if (field === 'password') {
          setFieldError(
            field as Field,
            Array.isArray(message) ? message[0] : message
          );
        }
      });

      if (errors.password) {
        notify.warning(
          'Senha incorreta',
          'Por favor, verifique sua senha e tente novamente'
        );
      } else {
        notify.error(
          'Erro ao confirmar',
          'Ocorreu um problema ao confirmar sua senha'
        );
      }
    },
  });
});


  return {
    onSubmit,
    isSubmitting,
    errors,
    meta,
  };
};