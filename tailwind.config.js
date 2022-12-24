const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.vue',
  ],
  theme: {
    screens: {
      sm: '640px',
      md: '768px',
      dark: { 'raw': '(prefers-color-scheme: dark)' },
    },
    extend: {
      colors: {
        // Custom "neutral" gray is very close to default gray palette but has
        // less-saturated colors on the darker end. It is used for dark themes
        // to provide a less blue-feeling UI.
        zinc: {
          ...colors.zinc,
          850: '#20262c', // extra color for more flexible bg colors
        },
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
    container: {
      padding: '1rem',
      center: true,
    },
  },
  variants: {},
  plugins: [],
};
