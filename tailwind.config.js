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
    },
    extend: {
      colors: {},
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
};
