module.exports = {
  content: [
       "./src/**/*.{html,ts}",
       "./node_modules/flowbite/**/*.js"
 ],
  theme: {
    extend: {
         backgroundImage: {
              'login-bg': 'src/app/assets/login.jpg',
              'my-header-gradient': 'linear-gradient(to-r, #8e24aa 56%, #3d1b4a 80%)'
         },
         fontFamily: {
             'headline': 'Commissioner',
             'word': 'Fira sans'
        },
        colors: {
             'blueish': '#011064',
             'orangish': '#EA6549',
             'grayish': '#F5F5F5'
        }
    },
  },
  mode: 'jit',
  plugins: [
       require('flowbite/plugin')
 ],
  corePlugins: {
    preflight: false,
  },
}
