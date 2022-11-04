import api from '../api';
export default {

	initialFetchUser({dispatch}) {
		dispatch("fetchProfile");
		dispatch("fetchResume");
		dispatch("fetchNotifications");
	},
	initialFetchCompany({dispatch}) {
		dispatch("fetchProfileCompany");
		dispatch("fetchCompany");
		dispatch("fetchNotificationsCompany");
		dispatch("fetchAnalytics")
	},

	initialFetch({dispatch}) {
		dispatch("fetchCountries");
	},

	fetchAnalytics({commit}) {
		return api.get("/company/analytics").then(res => {
			commit('updateAnalytics', res.data.result);
		});
	},

	fetchProfile({commit}) {
		commit("loading", 'profile');
		return api.get("/user").then(res => {
			if(res.data.success) {
				commit('updateProfile', res.data.result);
				commit("finishLoading", 'profile');
			}

			return res.data;
		});
	},

	fetchProfileCompany({commit}) {
		commit("loading", 'profile');
		return api.get("/company-user").then(res => {
			if(res.data.success) {
				commit('updateProfile', res.data.result);
				commit("finishLoading", 'profile');
			}

			return res.data;
		});
	},

	fetchCompany({commit}) {
		commit("loading", 'company');
		return api.get("/company").then(res => {
			if(res.data.success) {
				commit('updateCompany', res.data.result);
				commit("finishLoading", 'company');
			}

			return res.data;
		});
	},



	fetchCompanyJobs(ignored,payload) {
		return api.get("/company/jobs/?page="+payload.page+payload.search);
	},

	fetchResumeData() {
		return api.get("/resume-data");
	},

	fetchResume({commit}) {
		commit("loading", 'resume');
		return api.get("/resume").then(res => {
			if(res.data.success) {
				commit('updateResume', res.data.result);
				commit("finishLoading", 'resume');
			}

			return res.data;
		});
	},

	saveJob(ignored,payload) {
		return api.post("/job", payload);
	},

	updateJob(ignored,payload) {
		return api.post(`/job/${payload.id}`, Object.assign({_method: 'PUT'},payload));
	},

	startMatching(ignored, payload) {
		return api.post(`/job/${payload.id}/publish`);
	},

	fetchJob(ignored, payload) {
		return api.get("/job/"+payload.id);
	},

	duplicateJob(ignored, id) {
		return api.get("/job/"+id+"/copy");
	},



	fetchBlogPost(ignored, payload){
		return api.get("/blog/"+payload.id);
	},

	fetchBlog(ignored, payload){
		return api.get("/blog?category="+payload.id);
	},

	fetchLocale(){
		return api.get("/locale");
	},
	setLocale(locale,payload){
		return api.post("/locale",payload);
	},

	fetchLastPosts(){
		return api.get("/lastPosts");
	},
	fetchBlogCategories(){
		return api.get("/categories");
	},
	fetchPublicJob(ignored, payload) {
		return api.get("/job/"+payload.id+"/public");
	},

	fetchMyMatches(ignored,payload) {
		return api.get("/my-matches");
	},

	fetchJobCandidates(ignored,payload) {
		return api.get("/job-candidates");
	},

	fetchMatchPreview(ignored,payload) {
		return api.get("/resume/"+payload.resume_id+"/"+payload.job_id);
	},

	fetchCompanyAlerts(ignored,payload) {
		return api.get("/company/alerts");
	},
	readCompanyAlerts(ignored,payload) {
		return api.get("/company/alerts/read");
	},

	forgotPassword(ignored,payload) {
		return api.post("/forgot",payload)
	},

	resetPassword(ignored,payload) {
		return api.post("/reset/"+payload.token,payload);
	},

	uploadDoc(ignored, file) {
		let formData = new FormData();
		formData.append("file", file);
		return api.post("/resume/save-doc", formData, {
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		});
	},

	deleteDoc(ignored, doc_id) {
		return api.get(`/resume/delete-doc/${doc_id}`);
	},

	acceptResume(ignored,payload) {
		return api.get(`/match/resume/accept/${payload.job_id}/${payload.resume_id}`);
	},

	declineResume(ignored, payload) {
		return api.post(`/match/resume/decline/${payload.job_id}/${payload.resume_id}`, {
			reason: payload.reason||""
		});
	},

	acceptJob(ignored,payload) {
		return api.get(`/match/job/accept/${payload.job_id}/${payload.resume_id}`);
	},

	declineJob(ignored,payload) {
		return api.post(`/match/job/decline/${payload.job_id}/${payload.resume_id}`, {
			reason: payload.reason||""
		});
	},

	requestShortVideo(ignored,payload) {
		return api.post(`/match/resume/request-csv/${payload.job_id}/${payload.resume_id}`, {csv_questions: payload.text});
	},

	sendShortVideo(ignored, payload) {
		return api.post(`/match/resume/send-csv/${payload.job_id}`, payload.formData, {
			headers: {
				'Content-Type': "multipart/form-data"
			}
		});
	},

	fetchUserAlerts(ignored,payload) {
		return api.get("/user/alerts");
	},

	readUserAlerts(ignored,payload) {
		return api.get("/user/alerts/read");
	},

	saveResume({commit},payload) {
		return api.post("/resume/update",payload,{
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		})
	},

	saveProfile({commit, dispatch}, formData) {
		return api.post("/user/update", formData, {
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		});
	},
	saveProfileCompany({commit, dispatch}, formData) {
		return api.post("/company-user/update", formData, {
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		});
	},

	saveCompany({commit, dispatch}, formData) {
		return api.post("/company/update", formData, {
			headers: {
				'Content-Type': 'multipart/form-data'
			}
		});
	},

	fetchCountries({commit,dispatch}) {
		commit("loading", 'countries');
		return api.post("/countries")
			.then(res => {
				if(res.data.success) {
					commit("setCountries", res.data.result);
				}
			})
			.finally(() => {
				commit("finishLoading", 'countries');
			});
	},

	fetchNotifications({commit,dispatch}) {
		commit("loading", 'notifications');
		return api.post("/notifications")
			.then(res => {
				if(res.data.success) {
					commit("setNotifications", res.data.result);
				}
			})
			.finally(() => {
				commit("finishLoading", 'notifications');
			});
	},

	fetchNotificationsCompany({commit,dispatch}) {
		commit("loading", 'notifications');
		return api.post("/notificationsCompany")
			.then(res => {
				if(res.data.success) {
					commit("setNotifications", res.data.result);
				}
			})
			.finally(() => {
				commit("finishLoading", 'notifications');
			});
	},

	/* Verification */
	verifyEmail({commit,dispatch}, payload) {
		return api.get("/verify/"+payload.id+"/"+payload.token+"/"+payload.type)
	},



	/* SignIn / SignUp */

	signIn({commit}, payload) {
		return api.post("/login", payload).then(res => {
			console.log(res);

			return res;
		});
	},

	signUp({commit}, payload) {
		return api.post("/register", payload);
	},

	signOut() {
		return api.get("/logout");
	},

	fetchPackages() {
		return api.get("/packages");
	},

	fetchMyPackage() {
		return api.get("/my-package");
	},

	buyPackage(ignored,payload) {
		return api.get(`/package/${payload.package_id}/buy`);
	},

	fetchHomePartners(){
		return api.get("/partners");
	},

	fetchHomeFeatures(){
		return api.get("/features");
	},

	fetchHomeWorkflow(){
		return api.get("/workflow");
	},

	fetchHomeStats(){
		return api.get("/home-stats");
	},

	fetchFooterInfo() {
		return api.get("/footer-info");
	}
}

/*
პრობლემა:

Vue, vue-router & Vuex + ajax

Vue-ს გაშვებისას იტვირთება მომხმარებლის პროფილის მონაცემები, Vuex State-ში, {profile: {}}, რომელიც საჭიროა ვებსაიტზე მომხმარებლის სახელის, სურათის და ა.შ საჩვენებლად,
როდესაც მომხმარებელი შედის პროფილის რედაქტირების გვერდზე, საჭიროა Vuex-ის profile ობიექტი EditProfile კომპონენტში გადაკოპირდეს ლოკალურად რადგან დარედაქტირდეს და
გაიგზავნოს შესანახად,

როდესაც მომხმარებელი vue-router-ის საშუალებით გადამყავს პროფილის რედაქტირების გვერდზე, profile უკვე ჩატვირთულია და შემიძლია უბრალოდ mounted ან created
მეთოდში ავიღო და გადავაკოპირო Vuex-ის profile ობიექტი ლოკალურად,

მაგრამ თუ მომხმარებელი პირდაპირ პროფილის გვერდზე შედის computed და created მეთოდები მანამ ეშვება სანამ profile ობიექტი შეივსება ajax-ით

*/