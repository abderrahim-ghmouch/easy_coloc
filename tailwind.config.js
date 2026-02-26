/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        // These match the bright green and deep forest dark mode in your image
        "primary": "#13ec49",
        "background-light": "#f6f8f6",
        "background-dark": "#102215",
      },
      fontFamily: {
        "display": ["Manrope", "sans-serif"],
      },
      borderRadius: {
        "xl": "0.75rem",
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
