/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      boxShadow: {
        'table': '0 4px 6px 0px rgb(0 0 0 / 0.1), 0 -2px 4px 0px rgb(0 0 0 / 0.1)',
      }
    },
  },
  plugins: [],
}