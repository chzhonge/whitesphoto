
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueRouter from 'vue-router';
import store from "./store/store";
// import Vuex from 'vuex'


Vue.use(VueRouter);

Vue.component('breadcrumb', require('./components/breadcrumb/Breadcrumb.vue'));


const routes = [
    { path: '/', component: require('./components/project/ProjectList.vue') },
    { path: '/example', component: require('./components/Example.vue') },
    { path: '/upload', component: require('./components/Upload.vue') },
    { path: '/projects/:id', component: require('./components/img/ImageList.vue') },
    { path: '/projects/:id/:imageID', component: require('./components/img/ImageInfo.vue') }
];

export const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    store,
    router
});
