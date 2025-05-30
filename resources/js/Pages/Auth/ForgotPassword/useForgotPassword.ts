import { router } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";
import { forgotPasswordSchema } from "@/schemas/auth/forgotPassword.schema";
import { notify } from "@/utils/notify";

export const useForgotPassword = () => {
    type Field = "email";

    const { handleSubmit, isSubmitting, errors, meta, setFieldError } = useForm(
        {
            validationSchema: toTypedSchema(forgotPasswordSchema),
            initialValues: {
                email: "",
            },
        }
    );

    const onSubmit = handleSubmit((values) => {
        router.post(route("password.email"), values, {
            onSuccess: () => {
                notify.success(
                    "Link enviado!",
                    "Verifique seu e-mail para redefinir sua senha"
                );
            },
            onError: (errors) => {
                if (errors.message) {
                    notify.error(errors.message, "Erro ao enviar link");
                    return;
                }

                Object.entries(errors).forEach(([field, message]) => {
                    if (field === "email") {
                        setFieldError(
                            field as Field,
                            Array.isArray(message) ? message[0] : message
                        );
                    }
                });

                if (!errors.email) {
                    notify.error(
                        "Erro inesperado",
                        "Ocorreu um problema ao enviar o e-mail de recuperação"
                    );
                } else {
                    notify.warning(
                        "Corrija os erros",
                        "Verifique os campos destacados"
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
