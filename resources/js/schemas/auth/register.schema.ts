import { z } from "zod";

export const MIN_PASSWORD_LENGTH = 6;

export const registerSchema = z.object({
  name: z
    .string({ required_error: "Nome é obrigatório" })
    .min(2, { message: "Nome deve ter pelo menos 2 caracteres" })
    .trim(),
  email: z
    .string({ required_error: "Email é obrigatório" })
    .email({ message: "Por favor, insira um e-mail válido" })
    .toLowerCase()
    .trim(),
  password: z
    .string({ required_error: "Senha é obrigatória" })
    .min(MIN_PASSWORD_LENGTH, {
      message: `Senha deve ter no mínimo ${MIN_PASSWORD_LENGTH} caracteres`,
    }),
  password_confirmation: z.string({
    required_error: "Confirmação de senha é obrigatória",
  }),
}).refine(
  (data) => data.password === data.password_confirmation,
  {
    message: "As senhas não coincidem",
    path: ["password_confirmation"],
  }
);