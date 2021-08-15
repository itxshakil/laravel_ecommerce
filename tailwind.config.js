module.exports = {
  purge: {
    // enabled: true,
    content: [
      "app/**/*.php",
      "resources/**/*.html",
      "resources/**/*.js",
      "resources/**/*.jsx",
      "resources/**/*.ts",
      "resources/**/*.tsx",
      "resources/**/*.php",
      "resources/**/*.vue",
      "resources/**/*.twig",
    ],
    options: {
      // defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
      safelist: ['bg-red-500', 'bg-yellow-500', 'bg-green-500',/-active$/, /-enter$/, /-leave-to$/, /show$/],
    }
  },
  theme: {
    extend: {
      width: {
        '96': '24rem',
      },
      colors: {
        'twitter': '#1da1f2',
        'google': '#DB4437',
      },
      flex: {
        'product': '1 1 320px',
        'shop': '1 1 240px',
      }
    }
  },
  variants: {},
  plugins: []
}
