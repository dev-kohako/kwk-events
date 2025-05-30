import { router } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";
import {
    resetPasswordSchema,
    MIN_PASSWORD_LENGTH,
} from "@/schemas/auth/resetPassword.schema";
import { notify } from "@/utils/notify";

export const useResetPassword = (email: string, token: string) => {
    type Field = "email" | "password" | "password_confirmation" | "token";

    const { handleSubmit, isSubmitting, errors, meta, setFieldError } = useForm(
        {
            validationSchema: toTypedSchema(resetPasswordSchema),
            initialValues: {
                token,
                email,
                password: "",
                password_confirmation: "",
            },
        }
    );

    const onSubmit = handleSubmit((values) => {
        router.post(route("password.store"), values, {
            onSuccess: () => {
                notify.success(
                    "Senha alterada!",
                    "Sua senha foi redefinida com sucesso"
                );
            },
            onError: (errors) => {
                if (errors.message) {
                    notify.error(errors.message, "Erro ao redefinir senha");
                    return;
                }

                Object.entries(errors).forEach(([field, message]) => {
                    if (
                        [
                            "email",
                            "password",
                            "password_confirmation",
                            "token",
                        ].includes(field)
                    ) {
                        setFieldError(
                            field as Field,
                            Array.isArray(message) ? message[0] : message
                        );
                    }
                });

                if (
                    errors.email ||
                    errors.password ||
                    errors.password_confirmation
                ) {
                    notify.warning(
                        "Dados inválidos",
                        "Verifique os campos destacados"
                    );
                } else {
                    notify.error(
                        "Erro ao redefinir senha",
                        "Ocorreu um problema ao tentar redefinir sua senha"
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
        MIN_PASSWORD_LENGTH,
    };
};
