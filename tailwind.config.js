/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        forest: {
          950: '#051F20', // Background utama paling gelap
          900: '#0B2B26', // Background sekunder & base kartu gelap
          800: '#163832', // Surface kartu glassmorphism & background input form
          700: '#235347', // Border kartu, tombol sekunder, & state hover
        },
        sage: {
          400: '#8EB69B', // Aksen utama, neon glow, progress bar, & indikator aktif
        },
        mint: {
          100: '#DAF1DE', // Warna teks utama/heading & highlight terang
        },
      },
      boxShadow: {
        'sage-glow': '0 0 20px rgba(142, 182, 155, 0.3)',
        'sage-glow-lg': '0 0 30px rgba(142, 182, 155, 0.45)',
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

