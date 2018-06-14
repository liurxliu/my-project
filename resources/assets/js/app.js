
require('./bootstrap');




Vue.component('flash', require('./components/Flash.vue'));
Vue.component('question', require('./pages/Question.vue'));
Vue.component('home', require('./pages/Home.vue'));
Vue.component('navigation', require('./pages/Navigation.vue'));


Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));
Vue.component('ask-question', require('./components/AskQuestion.vue'));
Vue.component('tabs', require('./components/tabs/Tabs.vue'));
Vue.component('tab', require('./components/tabs/Tab.vue'));

const app = new Vue({
    el: '#app'
});
