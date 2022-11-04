<template>
	<!-- Start Settings -->
	<div id="settings" class="tab-pane fade">
		<spinner v-if="loading" />
		<form class="row no-mrg" @submit.prevent="save">
			<h3>{{ lang('applicant_dashboard_edit_profile_title') }}</h3>
			<div class="edit-pro">
				<div class="col-md-4 col-sm-6">
					<label for="first_name">{{ lang("first_name") }}</label>
					<input type="text" id="first_name" v-model="mdl.name" class="form-control" :placeholder="lang('applicant_dashboard_edit_profile_form_name')" :disabled="!editable">
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="last_name">{{ lang("last_name") }}</label>
					<input type="text" id="last_name" v-model="mdl.surname" class="form-control" :placeholder="lang('')" :disabled="!editable">
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="personal_id">{{ lang("applicant_dashboard_edit_profile_personal_id") }}</label>
					<input type="text" id="personal_id" v-model="mdl.personal_id" class="form-control" :placeholder="lang('applicant_dashboard_edit_profile_form_personal_id')" :disabled="!editable">
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="mobile_number">{{ lang("email") }}</label>
					<input :class="{'error': errors.email}" type="email" id="email" v-model="mdl.email" class="form-control" :placeholder="lang('applicant_dashboard_edit_profile_form_email_address')">
					<div class="error-msg"> - {{$errorString(errors.email)}}</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="mobile_number">{{lang("applicant_dashboard_edit_profile_phone")}}</label>
					<input :class="{'error': errors.mobile_number}" type="text" id="mobile_number" v-model="mdl.mobile_number" class="form-control" :placeholder="lang('applicant_dashboard_edit_profile_form_phone_number')">
					<div class="error-msg"> - {{$errorString(errors.mobile_number)}}</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="gender">{{lang("gender")}}</label>
					<select v-model="mdl.gender" :disabled="!editable" class="form-control" id="gender">
						<option value="male">{{lang("male")}}</option>
						<option value="female">{{lang("female")}}</option>
					</select>
				</div>



				<div class="col-md-4 col-sm-6">
					<label for="country">{{lang('applicant_dashboard_edit_profile_country')}}</label>
					<select id="country" v-model="country" class="form-control">
						<option :value="{}">{{lang('select_country')}}</option>
						<option v-for="c in countries" :value="c">{{c.title}}</option>
					</select>
				</div>
				<div class="col-md-4 col-sm-6">
					<label for="city">{{lang('applicant_dashboard_edit_profile_city')}}</label>
					<select :class="{'error': errors.city_id}" id="city" v-model="mdl.city_id" class="form-control">
						<option value="">{{lang('select_city')}}</option>
						<option v-for="city in country.city" :value="city.id">{{city.title}}</option>
					</select>
					<div class="error-msg"> - {{$errorString(errors.city_id)}}</div>
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('birth_date')}}</label>
					<date-selector  :class="{'error': errors.birthday}" v-model="mdl.birthday" class="form-control" :placeholder="lang('applicant_dashboard_edit_profile_form_birth_date')" :disabled="!editable" />
					<div class="error-msg"> - {{$errorString(errors.birthday)}}</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('applicant_dashboard_edit_profile_form_new_password')}}</label>
					<input autocomplete="new-password" :class="{'error': errors.new_password}" type="password" v-model="mdl.new_password" class="form-control" placeholder="*********">
					<div class="error-msg"> - {{$errorString(errors.new_password)}}</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('applicant_dashboard_edit_profile_form_repeat_password')}}</label>
					<input autocomplete="new-password" :class="{'error': errors.new_password_confirmation}" type="password" v-model="mdl.new_password_confirmation" class="form-control" placeholder="*********">
					<div class="error-msg"> - {{$errorString(errors.new_password_confirmation)}}</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('applicant_dashboard_edit_profile_form_current_password')}} <small class="text-danger">(required)</small></label>
					<input :class="{'error': errors.password}" type="password" v-model="mdl.password" class="form-control" placeholder="*********">
					<div class="error-msg"> - {{$errorString(errors.password)}}</div>
				</div>
				<div class="col-md-12">
					<label>{{lang('applicant_dashboard_edit_profile_form_upload_pic')}}</label>
					<dropzone ref="dropzone" @dz:error="dropzoneError" class="no-progress full-width" :options="{maxFiles: 1, acceptedFiles: 'image/*'}">{{lang('applicant_dashboard_edit_profile_form_upload')}}</dropzone>
				</div>
				<div class="col-sm-12">
					<button type="submit" class="update-btn">{{lang('applicant_dashboard_edit_profile_form_update')}}</button>
				</div>
			</div>
		</form>
	</div>
	<!-- End Settings -->
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
		editable() {
			return !(this.profile.resume_submitted || this.profile.resume_accepted);
		}
	},
	methods: {
		setUser(user) {
			this.mdl = _.cloneDeep(user);
			this.setCountryById(user.city.country.id);
			this.loading = false;
		},
		setCountryById(id) {
			if(this.countries.length && id) {
				this.country = _(this.countries).find({id:id});
			}
		},
		dropzoneError(file,error) {
			this.$root.$alert.open("File error", error);
			this.$refs.dropzone.dropzone.removeFile(file);
		},
		save() {

			let formData = new FormData();

			let data = _(this.mdl).pick(['name','surname','personal_id','email','mobile_number','city_id','birthday','new_password','new_password_confirmation','password']).forEach((value,key) => {
				formData.append(key,value);
			});

			let profilePic = _(this.$refs.dropzone.dropzone.files).find({accepted: true});

			if(profilePic) {
				formData.append("profile_image", profilePic);
			}

			this.loading = true;
			this.errors = {};
			/*api.post("/user/update", formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(res => {
				this.loading = false;
				if(!res.data.success) {
					this.errors = res.data.error;
				} else {
					this.$store.dispatch("fetchProfile");
					this.$root.$alert.open("Success", "Profile updated successfully");
				}
			});*/

			this.$store.dispatch("saveProfile", formData).then(res => {
				this.loading = false;
				if(!res.data.success) {
					this.errors = res.data.error;
				} else {
					this.$store.dispatch("fetchProfile");
					this.$root.$alert.open("Success", "Profile updated successfully");
				}
			});

		}
	}

}
</script>