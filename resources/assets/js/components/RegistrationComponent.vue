<template>
	<div role="tabpanel" class="tab-pane fade spinner-holder" id="register">

		<spinner v-if="loading" />

		<img src="/img/logo.png" class="img-responsive" alt="" />
		<form class="form-inline" method="post" @submit.prevent="signUp">
			<div class="col-sm-12">
				<div class="form-group" v-show="company_step!==2">
					<select name="company" class="form-control" v-model="mdl.isCompany" required>
						<option :value="true">{{'company'|translate}}</option>
						<option :value="false">{{'applicant'|translate}}</option>
					</select>
				</div>

				<template v-if="mdl.isCompany">

					<div class="signup-step step-1" v-show="company_step===1">

						<div class="form-group half-first half">
							<input type="text" name="company_name" class="form-control" v-model="mdl.company.company_name" :class="{'error': errors.company.company_name}" :placeholder="'company_name'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_name)}}</div>
						</div>

						<div class="form-group half">
							<input type="text" name="identification_number" class="form-control" v-model="mdl.company.company_id_number" :class="{'error': errors.company.company_id_number}" :placeholder="'identification_number'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_id_number)}}</div>
						</div>

						<div class="form-group half half-first">
							<input type="email" name="company_email" class="form-control" v-model="mdl.company.company_email" :class="{'error': errors.company.company_email}" :placeholder="'company_email'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_email)}}</div>
						</div>

						<div class="form-group half">
							<input type="text" name="company_phone_number" class="form-control" v-model="mdl.company.company_phone_number" :class="{'error': errors.company.company_phone_number}" :placeholder="'company_phone_number'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_phone_number)}}</div>
						</div>

						<div class="form-group half half-first">
							<select name="country" class="form-control" v-model="country">
								<option value="" disabled>{{'select_country'|translate}}</option>
								<option v-for="c in countries" :value="c">{{c.title}}</option>
							</select>
						</div>

						<div class="form-group half">
							<select name="city" class="form-control" :class="{'error': errors.company.company_city_id}" v-model="mdl.company.company_city_id">
								<option value="" disabled>{{'select_city'|translate}}</option>
								<option v-for="c in country.city" :value="c.id">{{c.title}}</option>
							</select>
							<div class="error-msg">{{$errorString(errors.company.company_city_id)}}</div>
						</div>

						<div class="form-group half half-first">
							<input type="text" name="address_1" class="form-control" v-model="mdl.company.company_address_1" :class="{'error': errors.company.company_address_1}" :placeholder="'company_address_1'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_address_1)}}</div>
						</div>

						<div class="form-group half">
							<input type="text" name="address_2" class="form-control" v-model="mdl.company.company_address_2" :class="{'error': errors.company.company_address_2}" :placeholder="'company_address_2'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.company_address_2)}}</div>
						</div>

						<div class="form-group">
							<textarea name="about" class="form-control" v-model="mdl.company.company_about" :class="{'error': errors.company.company_about}" :placeholder="'company_about'|translate" required title=""></textarea>
							<div class="error-msg">{{$errorString(errors.company.company_about)}}</div>
						</div>


						<div class="clearfix"></div>
						<div class="center">
							<button type="submit" class="submit-btn" @click.prevent="companyNextStep"> {{'next_step'|translate}} </button>
						</div>

					</div>
					<div class="signup-step step-2" v-show="company_step===2">

						<div class="form-group half half-first">
							<input type="text" name="name" class="form-control" v-model="mdl.company.user_name" :class="{'error': errors.company.user_name}" :placeholder="'first_name'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.user_name)}}</div>
						</div>

						<div class="form-group half">
							<input type="text" name="surname" class="form-control" v-model="mdl.company.user_lastname" :class="{'error': errors.company.user_lastname}" :placeholder="'last_name'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.user_lastname)}}</div>
						</div>

						<div class="form-group half half-first">
							<input type="email" name="email" class="form-control" v-model="mdl.company.user_email" :class="{'error': errors.company.user_email}" :placeholder="'email'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.user_email)}}</div>
						</div>

						<div class="form-group half">
							<input type="text" name="email" class="form-control" v-model="mdl.company.user_phone_number" :class="{'error': errors.company.user_phone_number}" :placeholder="'phone_number'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.user_phone_number)}}</div>
						</div>

						<div class="form-group half half-first">
							<input type="password" name="password" class="form-control" v-model="mdl.company.password" :class="{'error': errors.company.password}" :placeholder="'password'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.password)}}</div>
						</div>

						<div class="form-group half">
							<input type="password" name="password_confirmation" class="form-control" v-model="mdl.company.password_confirmation" :class="{'error': errors.company.password_confirmation}" :placeholder="'confirm_password'|translate" required>
							<div class="error-msg">{{$errorString(errors.company.password_confirmation)}}</div>
						</div>
						<div class="clearfix"></div>

						<div style="margin-top: 10px;">
							<button type="submit" class="submit-btn back-btn" @click.prevent="companyPrevStep"> {{'back'|translate}} </button>
							<button type="submit" class="submit-btn pull-right" @click.prevent="signUp"> {{'register'|translate}} </button>
						</div>

						<div class="flex agreement ">
							<p v-html="lang('therms')">{{lang('therms')}}</p>
						</div>

					</div>

				</template>
				<template v-else>

					<div class="form-group half half-first">
						<input type="text" name="name" class="form-control" v-model="mdl.applicant.name" :class="{'error': errors.applicant.name}" :placeholder="'first_name'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.name)}}</div>
					</div>

					<div class="form-group half">
						<input type="text" name="surname" class="form-control" v-model="mdl.applicant.surname" :class="{'error': errors.applicant.surname}" :placeholder="'last_name'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.surname)}}</div>
					</div>

					<div class="form-group half half-first">
						<input type="email" name="email" class="form-control" v-model="mdl.applicant.email" :class="{'error': errors.applicant.email}" :placeholder="'email'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.email)}}</div>
					</div>

					<div class="form-group half">
						<input type="text" name="mobile_number" class="form-control" v-model="mdl.applicant.mobile_number" :class="{'error': errors.applicant.mobile_number}" :placeholder="'mobile_number'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.mobile_number)}}</div>
					</div>

					<div class="form-group half half-first">
						<input type="password" name="password" class="form-control" v-model="mdl.applicant.password" :class="{'error': errors.applicant.password}" :placeholder="'password'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.password)}}</div>
					</div>

					<div class="form-group half">
						<input type="password" name="password_confirmation" class="form-control" v-model="mdl.applicant.password_confirmation" :class="{'error': errors.applicant.password_confirmation}" :placeholder="'confirm_password'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.password_confirmation)}}</div>
					</div>

					<div class="form-group half half-first">
						<select name="country" class="form-control" v-model="country">
							<option value="" disabled>{{'select_country'|translate}}</option>
							<option v-for="c in countries" :value="c">{{c.title}}</option>
						</select>
					</div>

					<div class="form-group half">
						<select name="city" class="form-control" :class="{'error': errors.applicant.city_id}" v-model="mdl.applicant.city_id">
							<option value="" disabled>{{'select_city'|translate}}</option>
							<option v-for="c in country.city" :value="c.id">{{c.title}}</option>
						</select>
						<div class="error-msg">{{$errorString(errors.applicant.city_id)}}</div>
					</div>

					<div class="form-group half half-first">
						<select name="country" class="form-control" v-model="mdl.applicant.gender">
							<option value="" disabled>{{'gender'|translate}}</option>
							<option value="male">{{'male'|translate}}</option>
							<option value="male">{{'female'|translate}}</option>
						</select>
					</div>

					<div class="form-group half">
						<date-selector v-model="mdl.applicant.birthday" class="form-control" name="birthday" :class="{'error': errors.applicant.birthday}" :placeholder="'birth_date'|translate" required />
						<div class="error-msg">{{$errorString(errors.applicant.birthday)}}</div>
					</div>


					<div class="form-group">
						<input type="text" name="personal_number" class="form-control" v-model="mdl.applicant.personal_id" :class="{'error': errors.applicant.personal_id}" :placeholder="'personal_number'|translate" required>
						<div class="error-msg">{{$errorString(errors.applicant.personal_id)}}</div>
					</div>

					<div class="clearfix"></div>
					<div class="center">
						<button type="submit" class="submit-btn"> {{'create_account'|translate}} </button>
					</div>

					<div class="flex agreement">
						<p>{{'agreement_part1'|translate}}<a href="/blog/privacy-policy" target="_blank">{{'agreement_part2'|translate}}</a> {{'agreement_part3'|translate}} <a href="/blog/terms-of-use" target="_blank">{{'agreement_part4'|translate}}</a></p>
					</div>
				</template>

			</div>
		</form>
	</div>
</template>

<script>
import api from '../api';
import {mapState} from 'vuex';
export default {
	name: "registration-component",
	data() {
		return {
			mdl: {
				applicant: {
					name: '',
					surname: '',
					email: '',
					password: '',
					password_confirmation: '',
					city_id: '',
					mobile_number: '',
					personal_id: '',
					gender: '',
					birthday: ''
				},
				company: {
					company_name: '',
					company_id_number: '',
					company_phone_number: '',
					company_email: '',
					company_website: '',
					company_vacancies_per_year: '',
					company_city_id: '',
					company_address_1: '',
					company_address_2: '',
					company_about: '',
					user_name: '',
					user_lastname: '',
					user_phone_number: '',
					user_email: '',
					password: '',
					password_confirmation: ''
				},
				isCompany: false,
			},
			errors: {
				applicant: {},
				company: {},
			},
			country: '',
			loading: false,
			company_step: 1
		}
	},
	methods: {
		companyNextStep() {
			let validated = true;
			let errors = {};
			if(!minLength(this.mdl.company.company_name, 1)) {
				errors.company_name = [this.lang("company_name_empty")];
				validated = false;
			}
			if(!minLength(this.mdl.company.company_id_number, 1)) {
				errors.company_id_number = [this.lang("company_id_number_empty")];
				validated = false;
			}
			if(!minLength(this.mdl.company.company_phone_number, 1)) {
				errors.company_phone_number = [this.lang("company_phone_number_empty")];
				validated = false;
			}
			if((this.mdl.company.company_email && this.mdl.company.company_email.indexOf("@") === -1) || !this.mdl.company.company_email) {
				errors.company_email = [this.lang("company_email_wrong")];
				validated = false;
			}
			if(!minLength(this.mdl.company.company_address_1,1)) {
				errors.company_address_1 = [this.lang("company_address_1_empty")];
				validated = false;
			}
			if(!this.mdl.company.company_city_id) {
				errors.company_city_id = [this.lang("company_city_id_empty")];
				validated = false;
			}

			if(validated) {
				this.company_step = 2;
			} else {
				this.errors.company = errors;
			}

			function minLength(x, length) {
				return x.length && x.length >= length;
			}
		},
		companyPrevStep() {
			this.company_step = 1;
		},
		signUp() {
			let self = this;
			let mdlKey = this.mdl.isCompany ? 'company' : 'applicant';
			this.errors[mdlKey] = {};
			this.loading = true;

			let data = _({company: this.mdl.isCompany}).assign(this.mdl.isCompany ? this.mdl.company : this.mdl.applicant);
			this.$store.dispatch("signUp", data.value())
				.then(res => {
					this.loading = false;
					if(res.data.success) {
						this.$auth.login(res.data.result.isCompany);
						if(res.data.result.message) {
							let message = res.data.result.message;
							$(".modal").modal("hide");
							let loc = res.data.result.isCompany ? '/company/dashboard' : '/applicant/dashboard';
							this.$root.$alert.open(message.title, message.text, {
								successCallback() {
									location = loc;
								},
								exitCallback() {
									location = loc;
								},
							});
						}
					} else {
						this.errors[mdlKey] = res.data.error;
						if(_(['company_name','company_id_number','company_email', 'company_city_id','company_address_1','company_phone_number']).some(key => res.data.error.hasOwnProperty(key))) {
							this.companyPrevStep();
						}
					}
				})
		}
	},
	computed: {
		...mapState(['countries'])
	},
	mounted() {
		let self = this;
	}
}
</script>

<style scoped>

	.agreement {
		text-align: left;
		color: #5D5D5D;
		font-family: sans-serif !important;
		margin: 20px 0 0 0;
	}
	.agreement a {
		text-decoration: underline;
		color: #656565;

	}
	.agreement a:hover {
		color: #36a8e0;
	}
</style>