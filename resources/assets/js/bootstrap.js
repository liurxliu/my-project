
import moment from 'moment';
import InstantSearch from 'vue-instantsearch';
import VModal from 'vue-js-modal';
import VueTextareaAutosize from 'vue-textarea-autosize';

window.moment = moment;
window.Vue = require('vue');

Vue.use(VModal, { dialog: true });
Vue.use(InstantSearch);
Vue.use(VueTextareaAutosize)

window.events = new Vue;

window.flash = function (message, type = 'success') {
	window.events.$emit('flash', {
		msg: message,
		type: type
	});
};

window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

if (window.location.hash && window.location.hash == '#_=_') {
	window.location.href = '/';
}

if (window.location.pathname && window.location.href.split('#').length == 2) {
	window.location.href = '/';
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
