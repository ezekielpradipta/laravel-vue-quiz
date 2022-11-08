/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            keyframes: {
                "fade-in-down": {
                    from: {
                        transform: "translateY(-0.75rem)",
                        opacity: "0",
                    },
                    to: {
                        transform: "translateY(0rem)",
                        opacity: "1",
                    },
                },
            },
            animation: {
                "fade-in-down": "fade-in-down 0.2s ease-in-out both",
            },
        },
        colors: {
            transparent: "transparent",
            current: "currentColor",
            primary: "#8b5cf6",
            success: "#10b981",
            danger: "#ef4444",
            warning: "#f59e0b",
            info: "#3b82f6",
            light: "#6b7280",
            dark: "#111827",
        },
    },
    plugins: [require("@tailwindcss/forms"), require("flowbite/plugin")],
};
