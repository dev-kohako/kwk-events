import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ["class"],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./index.html",
        "./src/**/*.{js,ts,jsx,tsx,vue}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
            },
            colors: {
                background: "hsl(var(--background))",
                foreground: "hsl(var(--foreground))",
                card: {
                    DEFAULT: "hsl(var(--card))",
                    foreground: "hsl(var(--card-foreground))",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover))",
                    foreground: "hsl(var(--popover-foreground))",
                },
                primary: {
                    DEFAULT: "hsl(var(--primary))",
                    foreground: "hsl(var(--primary-foreground))",
                },
                secondary: {
                    DEFAULT: "hsl(var(--secondary))",
                    foreground: "hsl(var(--secondary-foreground))",
                },
                muted: {
                    DEFAULT: "hsl(var(--muted))",
                    foreground: "hsl(var(--muted-foreground))",
                },
                accent: {
                    DEFAULT: "hsl(var(--accent))",
                    foreground: "hsl(var(--accent-foreground))",
                },
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                chart: {
                    1: "hsl(var(--chart-1))",
                    2: "hsl(var(--chart-2))",
                    3: "hsl(var(--chart-3))",
                    4: "hsl(var(--chart-4))",
                    5: "hsl(var(--chart-5))",
                },
            },
        },
    },

    safelist: [
        "bg-background",
        "text-foreground",

        "bg-card",
        "text-card-foreground",

        "bg-popover",
        "text-popover-foreground",

        "bg-primary",
        "text-primary-foreground",
        "hover:bg-primary/70",
        "hover:bg-primary/80",
        "hover:bg-primary/90",
        "hover:text-primary-foreground",
        "focus:ring-primary",

        "bg-secondary",
        "text-secondary-foreground",
        "hover:bg-secondary/90",
        "hover:bg-secondary/80",
        "hover:bg-secondary/70",
        "hover:text-secondary-foreground",
        "hover:bg-zinc-400/50",

        "bg-muted",
        "text-muted-foreground",
        "hover:bg-muted/90",
        "hover:text-muted-foreground",

        "bg-accent",
        "text-accent-foreground",
        "hover:bg-accent",
        "hover:bg-accent/90",
        "hover:text-accent-foreground",

        "bg-destructive",
        "text-destructive-foreground",
        "hover:bg-destructive/80",
        "hover:text-destructive-foreground",

        "border-border",
        "bg-input",
        "ring-ring",

        "text-chart-1",
        "text-chart-2",
        "text-chart-3",
        "text-chart-4",
        "text-chart-5",

        "rounded-lg",
        "rounded-md",
        "rounded-sm",
        "px-2",
        "px-4",
        "py-1",
        "py-2",
        "text-sm",
        "text-base",

        "h-9",
        "w-9",
        "w-px",
        "h-full",
        "h-px",
        "w-full",
        "shrink-0",
        "bg-border",
        "hover:bg-primary/90",
        "border-transparent",
        "focus:bg-accent",

        "focus:outline-none",
        "focus:ring-2",
        "focus:ring-offset-2",

        "underline",
        "hover:underline",
    ],

    plugins: [forms, require("tailwindcss-animate")],
};
