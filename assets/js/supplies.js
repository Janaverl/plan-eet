import Vue from 'vue';
import Supplies from './components/supplies/Supplies'

import '../css/app.css';

export const SuppliesEventBus = new Vue();

new Vue({
  render: h => h(Supplies),
}).$mount('#supplies')