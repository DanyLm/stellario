/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['app.vue', './pages/**/*.{html,js,vue,ts}', './components/**/*.{html,js,vue,ts}'],
  theme: {
    extend: {
      colors: {
        stellario: '#f0f0f7',
        'stellario-primary': '#00668A',
        'stellario-secondary': '#004E71'
      }
    },
    fontFamily: {
      Roboto: ['Roboto, sans-serif']
    },
    container: {
      padding: '2rem',
      center: true
    },
    letterSpacing: {
      widest: '0.3em'
    },
    screens: {
      sm: '640px',
      md: '768px'
    },
    minWidth: {
      'accordion-selected': '226px'
    }
  },
  plugins: []
}
