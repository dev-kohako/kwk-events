import { ref, watch } from "vue";
import { useForm } from "vee-validate";
import { router } from "@inertiajs/vue3";
import { EventformSchema } from "@/schemas/event.schema";
import { notify } from "@/utils/notify";
import { TimeProps } from "@/types";

export function useCreate() {
    const isSubmitting = ref(false);

    const hours = Array.from({ length: 24 }, (_, i) => i)
    const minutes = Array.from({ length: 60 }, (_, i) => i)

    const { handleSubmit, resetForm, setFieldValue, values } = useForm({
        validationSchema: EventformSchema,
    });

    function formatTime({ hour, minute }: TimeProps): string {
        return `${hour}:${minute}`;
    }

    const onSubmit = handleSubmit(async (formValues) => {
        isSubmitting.value = true;

        const starts_time = formatTime(formValues.schedule.starts_time);
        const ends_time = formatTime(formValues.schedule.ends_time);

        const payload = {
            ...formValues,
            schedule: {
                ...formValues.schedule,
                starts_time,
                ends_time,
            },
        };

        try {
            await router.post(route("events.store"), payload, {
                onSuccess: () => {
                    notify.success("Evento criado com sucesso!");

                    setTimeout(() => {
                        router.visit(route("events.my-events"));
                    }, 3000);
                },
                onError: (errors) => {
                    notify.error("Erro ao criar o evento. Verifique os dados.");
                    console.error("Erros de validação:", errors);
                },
                onFinish: () => {
                    isSubmitting.value = false;
                },
            });
        } catch (error) {
            notify.error("Erro inesperado ao tentar criar o evento.");
            console.error("Erro inesperado:", error);
            isSubmitting.value = false;
        }
    });

    async function fetchAddressByCep(cepRaw: string) {
        const cep = cepRaw.replace(/\D/g, "");
        if (cep.length !== 8) return;

        try {
            const response = await fetch(
                `https://viacep.com.br/ws/${cep}/json/`
            );
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();

            if (data.erro) {
                clearAddressFields();
                notify.warning("CEP não encontrado.");
                return false;
            }

            setFieldValue("address.address", data.logradouro || "");
            setFieldValue("address.city", data.localidade || "");
            setFieldValue("address.state", data.uf || "");
            return true;
        } catch (error) {
            clearAddressFields();
            notify.error("Erro ao consultar o CEP.");
            console.error("Erro ao consultar CEP:", error);
            return false;
        }
    }

    function clearAddressFields() {
        setFieldValue("address.address", "");
        setFieldValue("address.city", "");
        setFieldValue("address.state", "");
    }

    watch(
        () => values.address?.zipcode,
        (newCep) => {
            if (!newCep) return;

            const digits = newCep.replace(/\D/g, "").slice(0, 8);
            let formattedCep = digits;

            if (digits.length > 5) {
                formattedCep = digits.replace(/^(\d{5})(\d{1,3})$/, "$1-$2");
            }

            if (formattedCep !== newCep) {
                setFieldValue("address.zipcode", formattedCep);
            }

            if (digits.length === 8) {
                fetchAddressByCep(formattedCep);
            }
        }
    );

    return {
        isSubmitting,
        values,
        hours,
        minutes,
        onSubmit,
        setFieldValue,
    };
}
