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
            "dark-header": "#242526",
            "dark-body": "#18191A",
            primary: "#330F57",
            "dark-primary": "#230B3C",
            "darken-primary": "#0D0316",
            "light-primary": "#581C87",
            "lighten-primary": "#6B21A8",
            secondary: "#E5E7EB",
            "dark-secondary": "#D1D5DB",
            "darken-secondary": "#9CA3AF",
            "light-secondary": "#F3F4F6",
            "lighten-secondary": "#F9FAFB",
            success: "#34D399",
            "dark-success": "#10B981",
            "light-success": "#6EE7B7",
            danger: "#EF4444",
            "dark-danger": "#DC2626",
            "light-danger": "#F87171",
            info: "#60A5FA",
            "dark-info": "#3B82F6",
            "light-info": "#93C5FD",
            warning: "#FBBF24",
            "dark-warning": "#F59E0B",
            "light-warning": "#FCD34D",
        },
    },
    plugins: [require("@tailwindcss/forms"), require("flowbite/plugin")],
};
