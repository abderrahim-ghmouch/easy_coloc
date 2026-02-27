/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#13ec49",
        "background-light": "#f6f8f6",
        "background-dark": "#102215",
        "sidebar-dark": "#0a140d",
    },
      fontFamily: {
        "display": ["Manrope", "sans-serif"],
    },
    borderRadius: {
        "lg": "0.5rem",
        "xl": "0.75rem",
    },
    },
},
plugins: [require('@tailwindcss/forms')],
}
