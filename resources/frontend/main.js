import Vue from 'vue'

import 'normalize.css/normalize.css' // a modern alternative to CSS resets
import './styles/app.scss' // global css
import 'element-ui/lib/theme-chalk/table.css';
import 'element-ui/lib/theme-chalk/table-column.css';
import 'element-ui/lib/theme-chalk/card.css';
import 'element-ui/lib/theme-chalk/tab-pane.css';
import 'element-ui/lib/theme-chalk/tabs.css';
import 'element-ui/lib/theme-chalk/select.css';
import 'element-ui/lib/theme-chalk/option.css';
import 'element-ui/lib/theme-chalk/message-box.css';
import 'element-ui/lib/theme-chalk/message.css';

import router from './router'
import App from './App'
import { Message, MessageBox} from 'element-ui'  //引入Message, MessageBox

Vue.prototype.$message = Message                //vue实例上挂载Message
Vue.prototype.$messagebox = MessageBox             //vue实例上挂载MessageBox
Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
