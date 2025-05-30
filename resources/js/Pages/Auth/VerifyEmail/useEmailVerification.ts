import { useForm as useInertiaForm } from "@inertiajs/vue3";
import { useForm as useVeeForm } from "vee-validate";
import { computed } from "vue";
import { notify } from "@/utils/notify";

export const useEmailVerification = (status?: string) => {
    const inertiaForm = useInertiaForm({});

    const { handleSubmit } = useVeeForm({});

    const verificationLinkSent = computed(
        () =>
            inertiaForm.recentlySuccessful ||
            status === "verification-link-sent"
    );

    const onSubmit = handleSubmit(() => {
        inertiaForm.post(route("verification.send"), {
            preserveScroll: true,
            onSuccess: () => {
                notify.success(
                    "Link enviado!",
                    "Um novo link de verificação foi enviado para seu e-mail"
                );
            },
            onError: (errors) => {
                if (errors.serverError) {
                    notify.error("Erro no servidor", errors.serverError);
                } else if (errors.message) {
                    notify.error("Erro ao enviar", errors.message);
                } else {
                    notify.error(
                        "Erro ao enviar",
                        "Ocorreu um problema ao enviar o e-mail de verificação"
                    );
                }
            },
        });
    });

    return {
        onSubmit,
        isSubmitting: computed(() => inertiaForm.processing),
        verificationLinkSent,
    };
};
