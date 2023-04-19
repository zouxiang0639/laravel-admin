import Vue from 'vue'

import './styles/index.scss' // global css

import router from './router'
import App from './App'
import 'vant/lib/index.css';

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
