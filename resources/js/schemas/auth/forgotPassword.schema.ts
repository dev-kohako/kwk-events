import { z } from 'zod';

export const forgotPasswordSchema = z.object({
  email: z.string()
    .min(1, { message: 'E-mail é obrigatório' })
    .email({ message: 'Por favor, insira um e-mail válido' })
    .trim()
    .toLowerCase(),
});