import z from "zod";

export const updateProfile = z.object({
    name: z.string().max(100, "Nome muito longo"),
    email: z.string().email("E-mail inválido").max(255, "E-mail muito longo"),
});
