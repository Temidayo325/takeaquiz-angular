module.exports = {
  content: [
       "./src/**/*.{html,ts}"
 ],
  theme: {
    extend: {
         backgroundImage: {
              'login-bg': 'src/app/assets/login.jpg'
         }
    },
  },
  mode: 'jit',
  plugins: [],
  corePlugins: {
    preflight: false,
  },
}
