import { z } from 'zod';

export const MIN_PASSWORD_LENGTH = 8;

export const resetPasswordSchema = z.object({
  email: z.string()
    .min(1, { message: 'E-mail é obrigatório' })
    .email({ message: 'Por favor, insira um e-mail válido' })
    .trim()
    .toLowerCase(),
  token: z.string().min(1, { message: 'Token inválido' }),
  password: z.string()
    .min(1, { message: 'Senha é obrigatória' })
    .min(MIN_PASSWORD_LENGTH, { 
      message: `Senha deve ter no mínimo ${MIN_PASSWORD_LENGTH} caracteres` 
    }),
  password_confirmation: z.string()
    .min(1, { message: 'Confirmação de senha é obrigatória' }),
}).refine(
  (data) => data.password === data.password_confirmation,
  {
    message: "As senhas não coincidem",
    path: ["password_confirmation"],
  }
);