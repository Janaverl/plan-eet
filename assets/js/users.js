import Vue from 'vue';
import Users from './components/user/Users'

import '../css/app.css';

export const ApiEventBus = new Vue();

new Vue({
  render: h => h(Users),
}).$mount('#users')