import { z } from 'zod';

export const confirmPasswordSchema = z.object({
  password: z.string()
    .min(1, { message: 'Senha é obrigatória' })
    .min(8, { message: 'Senha deve ter no mínimo 8 caracteres' }),
});