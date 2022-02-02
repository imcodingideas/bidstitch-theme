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
        ...defaultTheme.screens,
        '2xl': false,
      }
    },
    extend: {
      colors: {},
      fontFamily: {
        'event': ['Montserrat', 'sans-serif']
      },
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
