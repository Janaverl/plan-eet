import Vue from 'vue';
import Users from './components/user/Users'

import '../css/app.css';

new Vue({
  render: h => h(Users),
}).$mount('#users')