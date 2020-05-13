
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import MyHeader from "./components/MyHeader";
import MyFooter from "./components/MyFooter";
import about from "./components/about";
import home from "./components/home";



const routes = [
    { path: '/home', component: home },
    { path: '/about', component: about }
]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router,
   components:{
       myheader: MyHeader,
       myfooter: MyFooter,
   },
});
