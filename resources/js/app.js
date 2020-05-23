require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


import AboutComponent from './components/AboutComponent'
import PostComponent from './components/PostComponent'
import PortalComponent from './components/PortalComponent'

import User from './components/User'

import VueChat from './components/VueChat'
import VueChatChannels from './components/VueChatChannels'
import VueChatMessages from './components/VueChatMessages'
import VueChatNewMessage from './components/VueChatNewMessage'
import VueChatParticipants from './components/VueChatParticipants'

Vue.component('user', require('./components/User.vue').default);

Vue.component('vue-chat', require('./components/VueChat.vue').default);
Vue.component('vue-chat-channels', require('./components/VueChatChannels.vue').default);
Vue.component('vue-chat-messages', require('./components/VueChatMessages.vue').default);
Vue.component('vue-chat-new-message', require('./components/VueChatNewMessage.vue').default);
Vue.component('vue-chat-participants', require('./components/VueChatParticipants.vue').default);


const router = new VueRouter({
        base: '/',
        mode: 'history',
        history: true,
    	
		routes: [
        {
            path: '/',
            name: 'home',
            component: PostComponent
        },

        {
           path: '/about',
	   name: 'about',
           component: AboutComponent
	},	
		{ 	path: '/portal/:id', 
			component: PortalComponent 
		},
        
    ],
});

const app = new Vue({
    el: '#app',
    components: {  VueChat, VueChatChannels, VueChatMessages, VueChatNewMessage, VueChatParticipants, User },
    router,
   
});



