export default {
	install(Vue, options = {storage: localStorage, profile_key: "profile"}) {
		Vue.prototype.$profile = {
			get() {
				return JSON.parse(options.storage.getItem(options.profile_key));
			},
			set(profile) {
				if(typeof profile === 'object') {
					options.storage.setItem(options.profile_key, JSON.stringify(profile));
				}
			},
			setField(field, value) {
				let profile = get();
				if(profile === null) {
					profile = {};
				}

				profile[field] = value;

				set(profile);
			},
			getField(field) {
				return get() && get()[field];
			}
		};

		Vue.prototype.$storage = {
			set(key, value) {
				options.storage.setItem("data_"+key, value);
			},
			get(key) {
				return options.storage.getItem("data_"+key);
			}
		};



		Vue.prototype.$auth = {
			isLoggedIn: function() {
				return options.storage.getItem("logged_in") || false;
			},
			login(company=0) {
				options.storage.setItem("logged_in", '1');
				options.storage.setItem("is_company", company.toString());
			},
			logout() {
				options.storage.removeItem("logged_in");
				options.storage.removeItem("is_company");
			},
			isCompany() {
				return options.storage.getItem("is_company")==="true" || false;
			}
		};


		Vue.prototype.$errorString = function(err) {
			if(Array.isArray(err)) {
				return err[0];
			} else {
				return err;
			}
		}
	}
}