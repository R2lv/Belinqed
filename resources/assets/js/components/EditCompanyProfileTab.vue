<template>
	<div id="user-profile" class="tab-pane fade in active">
		<spinner v-if="loading" />
		<div class="row no-mrg">
			<h3>{{lang('company_dashboard_edit_company_profile_edit_user_profile')}}</h3>
			<div class="edit-pro">
				<form @submit.prevent="save">
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_profile_name')}}</label>
						<input type="text" :class="{'error': errors.name}" class="form-control" v-model="mdl.name" :placeholder="lang('company_dashboard_edit_user_profile_name_placeholder')">
						<div class="error-msg"> - {{$errorString(errors.name)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_profile_last_name')}}</label>
						<input type="text" :class="{'error': errors.lastname}" class="form-control" v-model="mdl.lastname" :placeholder="lang('company_dashboard_edit_user_profile_last_name_placeholder')">
						<div class="error-msg"> - {{$errorString(errors.lastname)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_profile_email')}}</label>
						<input type="email" :class="{'error': errors.email}" class="form-control" v-model="mdl.email" :placeholder="lang('company_dashboard_edit_user_profile_email_placeholder')">
						<div class="error-msg"> - {{$errorString(errors.email)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_phone_number')}}</label>
						<input type="text" :class="{'error': errors.phone_number}" class="form-control" v-model="mdl.phone_number" :placeholder="lang('company_dashboard_edit_user_profile_phone_placeholder')">
						<div class="error-msg"> - {{$errorString(errors.phone_number)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_new_password')}}</label>
						<input autocomplete="new-password" :class="{'error': errors.new_password}" type="password" v-model="mdl.new_password" class="form-control" placeholder="*********">
						<div class="error-msg"> - {{$errorString(errors.new_password)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_repeat_password')}}</label>
						<input autocomplete="new-password" :class="{'error': errors.new_password_confirmation}" type="password" v-model="mdl.new_password_confirmation" class="form-control" placeholder="*********">
						<div class="error-msg"> - {{$errorString(errors.new_password_confirmation)}}</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_current_password')}} <small class="text-danger">({{lang('company_dashboard_edit_company_current_password_required')}})</small></label>
						<input :class="{'error': errors.password}" type="password" v-model="mdl.password" class="form-control" placeholder="*********">
						<div class="error-msg"> - {{$errorString(errors.password)}}</div>
					</div>
					<div class="col-sm-12">
						<button class="update-btn">{{lang('company_dashboard_edit_user_profile_update_now')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import {mapState} from 'vuex';
import api from '../api';
export default {
	name: "edit-profile",
	data() {
		return {
			mdl: {},
			errors: {},
			loading: true,
			country:{},
		}
	},
	mounted() {
		if(!this.$store.state.loadings.profile)
			this.setUser(this.$store.state.profile);

		if (this.mdl.city)
			this.setCountryById(this.mdl.city.country.id);
	},
	watch: {
		profile(user) {
			this.setUser(user);
		}
	},
	computed: {
		...mapState(['profile','countries','loadings']),
	},
	methods: {
		setUser(user) {
			this.mdl = _.cloneDeep(user);
			this.loading = false;
		},
		save() {

			let formData = new FormData();

			let data = _(this.mdl).pick(['name','lastname','email','phone_number','new_password','new_password_confirmation','password']).forEach((value,key) => {
				formData.append(key,value);
			});

			this.loading = true;
			this.errors = {};

			this.$store.dispatch("saveProfileCompany", formData).then(res => {
				this.loading = false;
				if(!res.data.success) {
					this.errors = res.data.error;
				} else {
					this.$store.dispatch("fetchProfileCompany");
					this.$root.$alert.open("Success", "Profile updated successfully");
				}
			});

		}
	}

}
</script>