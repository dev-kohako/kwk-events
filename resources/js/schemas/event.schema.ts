import { calendarDateToString, preprocessDateInput } from "@/utils/date";
import { toTypedSchema } from "@vee-validate/zod";
import dayjs from "dayjs";
import z from "zod";

const timeObjectSchema = z.object({
    hour: z
        .string({ required_error: "Hórario do evento é obrigatório" })
        .regex(/^\d{2}$/, "Hora inválida")
        .refine(
            (h) => {
                const n = Number(h);
                return n >= 0 && n <= 23;
            },
            { message: "Hora deve ser entre 00 e 23" }
        ),

    minute: z
        .string({ required_error: "Hórario do evento é obrigatório" })
        .regex(/^\d{2}$/, "Minuto inválido")
        .refine(
            (m) => {
                const n = Number(m);
                return n >= 0 && n <= 59;
            },
            { message: "Minuto deve ser entre 00 e 59" }
        ),
});

export const EventformSchema = toTypedSchema(
    z.object({
        eventInfo: z.object({
            name: z
                .string({ required_error: "Nome do evento é obrigatório" })
                .min(3, "Nome do evento deve ter pelo menos 3 caracteres")
                .max(100, "Nome do evento muito longo"),
            description: z
                .string()
                .max(500, "Descrição muito longa")
                .optional(),
        }),

        address: z.object({
            address: z
                .string({ required_error: "Endereço é obrigatório" })
                .min(3, "Endereço obrigatório")
                .max(200, "Endereço muito longo"),

            number: z
                .string({ required_error: "Número é obrigatório" })
                .min(1, "Número obrigatório")
                .max(10, "Número muito longo"),

            complement: z
                .string()
                .max(100, "Complemento muito longo")
                .optional(),

            zipcode: z
                .string({ required_error: "CEP é obrigatório" })
                .min(8, { message: "CEP deve ter no mínimo 8 dígitos" })
                .max(9, { message: "CEP inválido" })
                .transform((val) => {
                    const onlyDigits = val.replace(/\D/g, "");
                    if (onlyDigits.length !== 8) return val;
                    return onlyDigits.replace(/^(\d{5})(\d{3})$/, "$1-$2");
                })
                .refine((val) => /^\d{5}-\d{3}$/.test(val), {
                    message: "Formato inválido (use XXXXX-XXX)",
                }),

            city: z
                .string({ required_error: "Cidade é obrigatória" })
                .min(2, "Cidade deve ter pelo menos 2 caracteres")
                .max(100, "Cidade muito longa"),

            state: z
                .string({ required_error: "Estado é obrigatório" })
                .min(2, "Estado deve ter 2 caracteres")
                .max(2, "Estado deve ter 2 caracteres")
                .toUpperCase(),
        }),

        schedule: z
            .object({
                starts_at: z.preprocess(
                    calendarDateToString,
                    z
                        .string({
                            required_error: "Data de início é obrigatória",
                        })
                        .min(10, "Data de início obrigatória")
                        .refine(
                            (date) => {
                                const today = dayjs().startOf("day");
                                return (
                                    dayjs(date).isSame(today, "day") ||
                                    dayjs(date).isAfter(today, "day")
                                );
                            },
                            {
                                message:
                                    "A data de início deve ser hoje ou uma data futura",
                            }
                        )
                ),

                starts_time: timeObjectSchema,

                ends_at: z.preprocess(
                    preprocessDateInput,
                    z
                        .string({
                            required_error: "Data de término é obrigatória",
                        })
                        .min(10, "Data de fim obrigatória")
                        .refine(
                            (date) => {
                                const today = dayjs().startOf("day");
                                return (
                                    dayjs(date).isSame(today, "day") ||
                                    dayjs(date).isAfter(today, "day")
                                );
                            },
                            {
                                message:
                                    "A data de fim deve ser hoje ou uma data futura",
                            }
                        )
                ),

                ends_time: timeObjectSchema,
            })
            .refine(
                (data) => {
                    const start = dayjs(
                        `${data.starts_at} ${data.starts_time.hour}:${data.starts_time.minute}`,
                        "YYYY-MM-DD HH:mm"
                    );
                    const end = dayjs(
                        `${data.ends_at} ${data.ends_time.hour}:${data.ends_time.minute}`,
                        "YYYY-MM-DD HH:mm"
                    );
                    return end.isAfter(start);
                },
                {
                    message:
                        "A data e hora de término devem ser posteriores à de início",
                    path: ["ends_time"],
                }
            )
            .refine(
                (data) => {
                    const pad = (n: any) => String(n).padStart(2, "0");

                    const start = dayjs(
                        `${data.starts_at} ${pad(data.starts_time.hour)}:${pad(
                            data.starts_time.minute
                        )}`,
                        "YYYY-MM-DD HH:mm"
                    );

                    const end = dayjs(
                        `${data.ends_at} ${pad(data.ends_time.hour)}:${pad(
                            data.ends_time.minute
                        )}`,
                        "YYYY-MM-DD HH:mm"
                    );

                    return end.isAfter(start);
                },
                {
                    message:
                        "A data e hora de término devem ser posteriores à de início",
                    path: ["ends_time", "hour"],
                }
            ),

        vacancy: z.object({
            max_subscription: z.preprocess(
                (val) => Number(val),
                z
                    .number({
                        required_error: "Número de vagas é obrigatório",
                        invalid_type_error: "Número de vagas inválido",
                    })
                    .int("Deve ser um número inteiro")
                    .min(1, "Deve ter pelo menos 1 vaga")
                    .max(1000, "Número máximo de vagas é 1000")
            ),
        }),
    })
);
