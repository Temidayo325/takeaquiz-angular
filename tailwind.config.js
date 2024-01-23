/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
       "./src/**/*.{html,ts}"
     ],
  theme: {
    extend: {},
    theme: {
         colors: {
              dark_yellow: '#ffc300',
              dark: '#000814',
              dark_blue: '#001D3D',
              light_yellow: '#ffd60a'
         },
         backgroundImage: {
              'register-bg': "url('../src/assets/images/blob-scene-haikei.svg')",
              'login': "url('./src/assets/images/low-poly-grid-haikei.svg')",
              'admin-logo': "url('/src/assets/images/scattered-forcefields.svg')",
              'logo': "url('src/assets/images/logo.svg')"
         },
         fontFamily: {
            header: ['"Amaranth"', 'sans-serif']
          }
    }
  },
  plugins: [
 ],
}
