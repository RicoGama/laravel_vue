import appConfig from './services/appConfig';
//import Vuex from 'vuex';

require('materialize-css');
window.Vue = require('vue');
//window.Vue.use(Vuex);
require('vue-resource');
require('vuex');
Vue.http.options.root = appConfig.api_url;

require('./services/interceptors');
require('./router');

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
