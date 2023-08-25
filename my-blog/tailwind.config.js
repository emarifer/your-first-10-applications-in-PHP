/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.php", "./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        primary: "#0f172a",
      },
      fontFamily: {
        Kanit: ["Kanit, sans-serif"],
      },
    },
  },
  plugins: [],
}

