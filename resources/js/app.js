require('./bootstrap')
window.Vue = require('vue')

import 'js-loading-overlay'

let configs = {
	'overlayBackgroundColor': '#fff',
	'overlayOpacity': 0.6,
	'spinnerIcon': 'ball-circus',
	'spinnerColor': '#f26f24',
	'spinnerSize': '1x',
	'overlayIDName': 'overlay',
	'spinnerIDName': 'spinner',
	'offsetY': 0,
	'offsetX': 0,
	'lockScroll': false,
	'containerID': null,
};

// global variable
Vue.prototype.$configs = configs

// const
window.BASE_URL = process.env.BASE_URL

import client from './clients.js'
import administrator from './administrator'
import general from './general'
import staff from './staff'

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTablePlugin);

const app = new Vue({
    el: '#wrapper',
});