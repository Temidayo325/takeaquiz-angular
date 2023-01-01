/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
       "./src/**/*.{html,ts}"
     ],
  theme: {
    extend: {},
    theme: {
         colors: {
              yellow: '#FBAE3C',
              dark: '#001220'
         },
         backgroundImage: theme => ({
              'register-bg': "url('../src/assets/images/blob-scene-haikei.svg')",
              'login': "url('./src/assets/images/low-poly-grid-haikei.svg')",
         }),
         fontFamily: {
            header: ['"Amaranth"', 'sans-serif']
          }
    }
  },
  plugins: [
 ],
}
