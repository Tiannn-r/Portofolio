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
          950: '#071615', // Base background obsidian forest (bersih, pekat, tidak becek)
          900: '#0C201E', // Card surface
          800: '#142E2A', // Elevated surface & input background
          700: '#1D3D38', // Border kartu & garis pemisah halus
        },
        sage: {
          400: '#8EB69B', // Signature brand: subtitle, badge teknis, secondary accent
        },
        warm: {
          400: '#D4A574', // 10% High-intent warm amber focal accent (CTA, status, link)
          500: '#C29362', // Hover state warm amber
        },
        mint: {
          100: '#DAF1DE', // Warna teks utama/heading (high readability)
        },
      },
      boxShadow: {
        'subtle': '0 2px 10px rgba(0, 0, 0, 0.25)',
        'elevated': '0 10px 25px rgba(0, 0, 0, 0.4)',
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

