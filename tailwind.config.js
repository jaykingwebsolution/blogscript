/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./public/**/*.html",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
        secondary: '#1E40AF',
        accent: '#F59E0B',
        spotify: {
          green: '#1db954',
          'green-light': '#1ed760',
          'green-dark': '#1aa34a',
          black: '#191414',
          dark: '#121212',
          'dark-gray': '#282828',
          gray: '#535353',
          'light-gray': '#b3b3b3'
        }
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}