/** @type {import('tailwindcss').Config} */
export default {
  // Forced rebuild at 2026-01-09 07:30
  darkMode: 'class',
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#4A90B8",
        "primary-dark": "#2E6B8A",
        "header-blue": "#3D7A9E",
        "header-dark": "#2A5A78",
        "background-light": "#F2F4F8",
        "background-dark": "#121212",
        "surface-light": "#FFFFFF",
        "surface-dark": "#1E1E1E",
        "text-main-light": "#2D3748",
        "text-sub-light": "#A0AEC0",
      },
      fontFamily: {
        display: ["Manrope", "sans-serif"],
      },
      borderRadius: {
        "2xl": "1rem",
        full: "9999px",
      },
    },
  },
  plugins: [
    require("@tailwindcss/forms"),
  ],
};
