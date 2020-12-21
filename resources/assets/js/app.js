
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
		status_id: 0,
		first_page_url: '',
		prev_page_url: '',
		next_page_url: '',
		last_page_url: '',
		total_results: 0,
		current_page: 0,
		last_page: 0
	},
	created () {
		this.submitSearch();
	},
	methods: {
		submitSearch: function (event, url) {
			var self = this;
						
			if(url === undefined || url == null || url == '') {
				url = '/get_emails';
			}
			
			$.ajax({
				url: url,
				method: 'GET',
				data: {
					from: self.from,
					to: self.to,
					subject: self.subject,
					status_id: self.status_id
				},
				success: function (data) {
										
					var data_array = JSON.parse(data);
					
					self.emailList = data_array.data;
					self.first_page_url = data_array.first_page_url;
					self.prev_page_url = data_array.prev_page_url;
					self.next_page_url = data_array.next_page_url;
					self.last_page_url = data_array.last_page_url;
					self.total_results = data_array.total;
					self.current_page = data_array.current_page;
					self.last_page = data_array.last_page;					
				}
			});		
		},
		
		firstPage: function(event) {
			this.submitSearch(event, this.first_page_url);
		},
		
		prevPage: function(event) {
			this.submitSearch(event, this.prev_page_url);
		},
		
		nextPage: function(event) {
			this.submitSearch(event, this.next_page_url);
		},
		
		lastPage: function(event) {
			this.submitSearch(event, this.last_page_url);
		},
		
		processQueue: function(event) {					
			$.ajax({
				url: '/process_email_queue',
				method: 'GET',
				data: {					
				},
				success: function (data) {
					this.submitSearch(event);
				}.bind(this)
			});
		},
	}
});
