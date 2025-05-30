import { router } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm } from "vee-validate";
import { loginSchema } from "@/schemas/auth/login.schema";
import { notify } from "@/utils/notify";

export const useLogin = () => {
    type Field = "email" | "password";

    const {
        handleSubmit,
        resetForm,
        isSubmitting,
        errors,
        meta,
        setFieldError,
    } = useForm({
        validationSchema: toTypedSchema(loginSchema),
        initialValues: {
            email: "",
            password: "",
            remember: false,
        },
    });

    const onSubmit = handleSubmit((values) => {
        router.post(route("login"), values, {
            onSuccess: () => {
                resetForm();
                notify.success("Login realizado!", "Bem-vindo de volta");
            },
            onError: (errors) => {
                if (errors.message) {
                    notify.error(errors.message, "Erro ao logar");
                } else {
                    Object.entries(errors).forEach(([field, message]) => {
                        if (["email", "password"].includes(field)) {
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
