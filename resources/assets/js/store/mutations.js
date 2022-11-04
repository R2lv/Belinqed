export default {
	updateProfile(state, profile) {
		state.profile = profile;
	},
	updateResume(state, resume) {
		state.resume = resume;
	},
	updateProfileField(state, payload) {
		state.profile[payload.field] = payload.value;
	},
	setCountries(state, payload) {
		state.countries = payload;
	},
	setNotifications(state, payload) {
		state.notifications = payload;
	},
	updateCompany(state, company) {
		state.company = company;
	},
	loading(state,payload) {
		state.loadings[payload] = true;
	},
	finishLoading(state,payload) {
		state.loadings[payload] = false;
	},
	updateAnalytics(state,payload) {
		state.analytics = payload;
	},
	addJob(state,job) {
		if(state.company) {
			state.company.jobs.push(job);
		}
	}
}