<template>
	<div role="tabpanel" class="tab-pane fade in active" id="login">
		<spinner v-if="loading" />
		<img src="/img/logo.png" class="img-responsive" alt="" />
		<div class="subscribe wow fadeInUp">
			<form class="form-inline" method="post" @submit.prevent="signIn">
				<div class="col-sm-12">
					<div class="form-group">

						<select title="Login type" v-model="mdl.company_login" class="form-control">
							<option :value="true">{{'company'|translate}}</option>
							<option :value="false">{{'applicant'|translate}}</option>
						</select>

						<input type="email"  name="email" class="form-control" :class="{'error': errors.email}" :placeholder="lang('login_email_placeholder')" v-model="mdl.email" required>
						<div class="error-msg"> - {{$errorString(errors.email)}}</div>

						<input type="password" name="password" class="form-control" :class="{'error': errors.password}" :placeholder="lang('login_password_placeholder')" v-model="mdl.password" required>
						<div class="error-msg"> - {{$errorString(errors.password)}}</div>

						<div class="center">
							<button type="submit" id="login-btn" class="submit-btn"> {{lang('login_button')}} </button>
							<button type="button" id="reset-btn" class="submit-btn" @click="lost_password"> {{lang('lost_password')}} </button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import api from '../api';
import {mapState} from 'vuex';
export default {
	name: "login-component",
	data() {
		return {
			mdl: {
				email: '',
				password: '',
				company_login: false
			},
			errors: {

			},
			country: '',
			loading: false
		}
	},
	methods: {
		signIn() {
			this.errors = {};
			this.loading = true;
			this.$store.dispatch('signIn',this.mdl)
				.then(res => {
					console.log("Signing in", res);
					this.loading = false;
					if(res.data.success) {
						this.$auth.login(res.data.result.isCompany);
						if(res.data.result.isCompany)
							location = "/company/dashboard";
						else
							location = "/applicant/dashboard";
					} else {
						this.errors = res.data.error;
					}
				})
		},

		lost_password() {
			this.$parent.$parent.$refs.pw_forgot_modal.open();
		}
	},
	computed: {
		...mapState(['countries'])
	}
}
</script>