module.exports = {
  content: [
       "./src/**/*.{html,ts}"
 ],
  theme: {
    extend: {
         backgroundImage: {
              'login-bg': 'src/app/assets/login.jpg',
              'my-header-gradient': 'linear-gradient(to-r, #8e24aa 56%, #3d1b4a 80%)'
         },
         fontFamily: {
             'headline': 'Amaranth',
             'word': 'Poppins'
        },
        colors: {
             'blueish': '#011064',
             'orangish': '#EA6549',
             'grayish': '#F5F5F5'
        }
    },
  },
  mode: 'jit',
  plugins: [],
  corePlugins: {
    preflight: false,
  },
}
