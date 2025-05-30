// resources/js/Pages/Events/Show/useShow.ts
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { notify } from "@/utils/notify";

export function useShow(event: { uuid_code: string }) {
    const isSubmitting = ref(false);

    const setErrors = (errors: Record<string, string | string[]>) => {
        const messages = Object.values(errors)
            .flatMap((value) => (Array.isArray(value) ? value : [value]))
            .join("\n");

        notify.error(messages);
    };
    const onSubscribe = async () => {
        isSubmitting.value = true;

        try {
            await router.post(
                route("events.subscribe", event.uuid_code),
                {},
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        notify.success("Inscrição realizada com sucesso!");
                    },
                    onError: (errors) => {
                        setErrors(errors);
                    },
                    onFinish: () => {
                        isSubmitting.value = false;
                    },
                }
            );
        } catch (e) {
            notify.error("Erro inesperado ao tentar se inscrever.");
            isSubmitting.value = false;
        }
    };

    const onUnsubscribe = async () => {
        isSubmitting.value = true;

        try {
            await router.delete(route("events.unsubscribe", event.uuid_code), {
                preserveScroll: true,
                onSuccess: () => {
                    notify.success("Inscrição cancelada com sucesso.");
                },
                onError: (errors) => {
                    setErrors(errors);
                },
                onFinish: () => {
                    isSubmitting.value = false;
                },
            });
        } catch (e) {
            notify.error("Erro inesperado ao cancelar inscrição.");
            isSubmitting.value = false;
        }
    };

    return {
        isSubmitting,
        onSubscribe,
        onUnsubscribe,
    };
}
