const defaultTheme  = require('tailwindcss/defaultTheme')

module.exports = {
  purge: {
    content: [
      './app/**/*.php',
      './resources/**/*.{php,vue,js}',
      './dokan/**/*.php'
    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    borderColor: theme => ({
      ...theme('colors'),
       DEFAULT: theme('colors.gray.200', 'currentColor'),
    }),
    container: {
      center: true,
      padding: {
        DEFAULT: '2rem',
      },
      screens: {
        sm: '600px',
        md: '728px',
        lg: '984px',
        xl: '1337px',
        '2xl': '1337px',
      },
    },
    extend: {
      colors: {
        'newgray': '#686868',
      },
      fontFamily: {
        'event': ['Montserrat', 'sans-serif']
      },
    },
    fontWeight: {
      hairline: 100,
      thin: 200,
      light: 300,
      normal: 400,
      medium: 500,
      semibold: 600,
      bold: 700,
    },
  },
  variants: {
    extend: {
      borderWidth: ['last'],
      margin: ['first', 'last'],
      backgroundColor: ['even']
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
};
