import { toast } from "vue-sonner";

export const notify = {
  success: (msg: string, desc?: string) =>
    toast.success(msg, {
      description: desc,
      style: {
        backgroundColor: "#16a34a",
        color: "#e4e4e7",
        border: "none",
        fontWeight: "400"
      },
      richColors: true,
    }),

  error: (msg: string, desc?: string) =>
    toast.error(msg, {
      description: desc,
      style: {
        backgroundColor: "#dc2626",
        color: "#e4e4e7",
        border: "none",
      },
      richColors: true,
    }),

  warning: (msg: string, desc?: string) =>
    toast.warning(msg, {
      description: desc,
      style: {
        backgroundColor: "#f59e0b",
        color: "#e4e4e7",
        border: "none",
      },
      richColors: true,
    }),

  info: (msg: string, desc?: string) =>
    toast.info(msg, {
      description: desc,
      style: {
        backgroundColor: "#3b82f6",
        color: "#e4e4e7",
        border: "none",
      },
      richColors: true,
    }),
};
