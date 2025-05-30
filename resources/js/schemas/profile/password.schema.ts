import z from "zod";

export const passwordSchema = z
    .object({
        current_password: z.string().min(1, "Senha atual é obrigatória"),
        password: z
            .string()
            .min(8, "A nova senha deve ter no mínimo 8 caracteres"),
        password_confirmation: z.string(),
    })
    .refine((data) => data.password === data.password_confirmation, {
        message: "As senhas não coincidem",
        path: ["password_confirmation"],
    });
