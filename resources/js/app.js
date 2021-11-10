
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

axios = require('axios');

require('vue-form-wizard');
require('vue-loading-overlay');
require('vue-swal');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('number-table', require('./components/NumberTable').default);
Vue.component('number-entry', require('./components/NumberEntry').default);
Vue.component('topup-wizard', require('./components/TopupWizard.vue').default);
Vue.component('send-topup', require('./components/SendTopup.vue').default);
Vue.component('wallet-transfer', require('./components/WalletTransfer.vue').default);
Vue.component('gifts-wizard', require('./components/GiftCards/GiftsWizard').default);
Vue.component('gift-items', require('./components/GiftCards/GiftForm').default);
Vue.use(require('vue-moment'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
