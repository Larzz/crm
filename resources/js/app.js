require('./bootstrap')
window.Vue = require('vue')
// const
window.BASE_URL = process.env.BASE_URL

import client from './clients.js'
import administrator from './administrator'
import general from './general'
import staff from './staff'

const app = new Vue({
    el: '#wrapper',
});