module.exports = {
  content: [
       "./src/**/*.{html,ts}"
 ],
  theme: {
    extend: {
         backgroundImage: {
              'login-bg': 'src/app/assets/login.jpg'
         },
         fontFamily: {
             'headline': 'Amaranth',
             'word': 'Poppins'
          }
    },
  },
  mode: 'jit',
  plugins: [],
  corePlugins: {
    preflight: false,
  },
}
