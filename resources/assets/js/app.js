
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

var emailList = new Vue({
	el: '#email_list',
	data: {
		emailList: [],
		from: '',
		to: '',
		subject: '',
		status_id: 0
	},
	created () {
		this.getEmailList()
	},
	methods: {
		getEmailList: function () {
			var self = this;
			
			$.ajax({
				url: '/get_emails',
				method: 'GET',
				data: {},
				success: function (data) {
					self.emailList = JSON.parse(data)
				}
			});	
		},
		
		submitSearch: function () {			
			var self = this;
			
			$.ajax({
				url: '/get_emails',
				method: 'GET',
				data: {
					from: self.from,
					to: self.to,
					subject: self.subject,
					status_id: self.status_id
				},
				success: function (data) {
					self.emailList = JSON.parse(data)
				}
			});		
		}
	}
});
