
import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
 
Vue.use(VueRouter)
Vue.use(Vuex)

Vue.component('auto-logout', require('./components/AutoLogout.vue').default);


const app = new Vue({
    el: '#app',
    // router : new VueRouter(routes),
    // store: new Vuex.Store(store)
});
