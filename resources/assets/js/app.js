import 'es6-promise/auto';

require('./bootstrap');
require("bootstrap-datepicker");


// require("../lib/js/custom");

import Vuex from 'vuex'
import VueLanguages from "vue-languages";
import VueMixins from './mixins';
import Vuelidate from 'vuelidate';
import Dropzone from 'dropzone';
import moment from 'moment';
import v from 'video.js';
window.moment = moment;
window.Dropzone = Dropzone;
window.Vue = require('vue');
// window.PhotoSwipe = require('photoswipe');
// window.PhotoSwipeUI_Default = require('photoswipe/dist/photoswipe-ui-default.min');
require("lightgallery.js");
// require("lightgallery.js/src/js/lg-utils");
window.videojs = v;
require("../plugins/owl-carousel/js/owl.carousel.min");

import App from './components/App';

import api from './api';

Vue.use(Vuex);

Vue.use(VueLanguages, {
	ka: require("../locale/ka.json"),
	en: require("../locale/en.json")
});

var VueCookie = require('vue-cookie');
Vue.use(VueCookie);



Vue.use(VueMixins);
Vue.use(Vuelidate);

let router = require('./router').default;
let store = require('./store/index').default;

Vue.component("Spinner", require("./components/Spinner").default);
Vue.component("Notifications", require("./components/Notifications").default);
Vue.component("EditProfileTab", require("./components/EditProfileTab").default);
Vue.component("EditCompanyProfileTab", require("./components/EditCompanyProfileTab").default);

Vue.component("EditCompanyTab", require("./components/EditCompanyTab").default);

Vue.component("JobInvitationsTab", require("./components/JobInvitationsTab").default);
Vue.component("JobCandidatesTab", require("./components/JobCandidatesTab").default);
Vue.component("VideoTab", require("./components/VideoTab").default);
Vue.component("AboutTab", require("./components/AboutTab").default);
Vue.component("CompanyAlertsTab", require("./components/CompanyAlertsTab").default);
Vue.component("ApplicantAlertsTab", require("./components/ApplicantAlertsTab").default);
Vue.component("MyPackageTab", require("./components/MyPackageTab").default);
Vue.component("Dropzone", require("./components/Dropzone").default);

Vue.component("AlertModal", require("./components/AlertModal").default);
Vue.component("PromptModal", require("./components/PromptModal").default);
Vue.component("ConfirmModal", require("./components/ConfirmModal").default);
Vue.component("VideoModal", require("./components/VideoModal").default);

Vue.component("Registration", require("./components/RegistrationComponent").default);
Vue.component("Login", require("./components/LoginComponent").default);
Vue.component("LevelSelector", require("./components/LevelSelector").default);
Vue.component("DoubleLevelSelector", require("./components/DoubleLevelSelector").default);
Vue.component("PlaceSelector", require("./components/PlaceSelector").default);
Vue.component("Select2", require("./components/Select").default);
Vue.component("StarSelect", require("./components/StarSelect").default);
Vue.component("SendCsv", require("./components/SendCSV").default);
Vue.component("DateSelector", require("./components/DateSelector").default);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.prototype.formatDate = function(date) {
	if(date) {
		return moment(date).format("DD-MM-YYYY");
	}
	return "...";
};

router.beforeEach((to,b,next) => {

	$(".modal").modal("hide");
	if(to.matched.some(a => a.meta.auth_only)) {
		if (!router.app.$auth.isLoggedIn()) {
			next('/');
			return;
		}
	}
	if(to.matched.some(a => a.meta.company_only)) {
		if(!router.app.$auth.isCompany()) {
			next('/');
			return;
		}
	}
	if(to.matched.some(a => a.meta.applicant_only)) {
		if(router.app.$auth.isCompany()) {
			next('/');
			return;
		}
	}

	next();
});


let app = new Vue({
	data() {
		return {
			$alert: {}
		}
	},
	template: '<App />',
	router,
	store,
	components: {
		App
	}
});

api.interceptors.response.use(null, function (error) {
	if (error.response.status === 401) {
		// console.log('unauthorized, logging out ...');
		app.$auth.logout();
		app.$router.go('/');
	}
	return Promise.reject(error);
});


if(!app.$cookie.get("lang")){
	app.$cookie.set("lang","en");
}

Vue.setLanguage(app.$cookie.get("lang") || "en");



app.$mount("#app");