const forms = require('@tailwindcss/forms');

/** @type {import('tailwindcss').Config} */
module.exports = {
  theme: {
    extend: {},
  },

  plugins: [
    forms,
    require('preline/plugin'),
  ],
};
