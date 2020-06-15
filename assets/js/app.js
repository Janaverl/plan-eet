/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import Vue from 'vue';
import Users from './components/user/Users'

import '../css/app.css';

new Vue({
  render: h => h(Users),
}).$mount('#users')