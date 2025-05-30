import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import { router } from "@inertiajs/vue3";
import { registerSchema } from "@/schemas/auth/register.schema";
import { notify } from "@/utils/notify";

export const useRegister = () => {
    type Field = "name" | "email" | "password" | "password_confirmation";

    const {
        handleSubmit,
        resetForm,
        isSubmitting,
        errors,
        meta,
        setFieldError,
    } = useForm({
        validationSchema: toTypedSchema(registerSchema),
        initialValues: {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        },
    });

    const onSubmit = handleSubmit((values) => {
        router.post(route("register"), values, {
            onFinish: () => {
                resetForm();
                notify.success(
                    "Cadastro realizado!",
                    "Sua conta foi criada com sucesso"
                );
            },
            onError: (errors) => {
                Object.entries(errors).forEach(([field, message]) => {
                    if (
                        [
                            "name",
                            "email",
                            "password",
                            "password_confirmation",
                        ].includes(field)
                    ) {
                        setFieldError(
                            field as Field,
                            Array.isArray(message) ? message[0] : message
                        );
                    }
                });

                notify.warning(
                    "Corrija os erros",
                    "Verifique os campos destacados"
                );
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
