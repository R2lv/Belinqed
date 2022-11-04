<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Forgot Password</h5>
			</div>
			<div class="modal-body">
				<form @submit.prevent="forgot" id="forgot_form">
					<div class="form-group">
						<input type="text" class="form-control" v-model="email" :placeholder="lang('forgot_email_placeholder')">
					</div>
					<div class="form-group">
						<select v-model="is_company" class="form-control">
							<option :value="true">{{'company'|translate}}</option>
							<option :value="false">{{'applicant'|translate}}</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-alrt" form="forgot_form">{{lang('forgot_send_link')}}</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
	data() {
		return {
			email: '',
			is_company: false
		}
	},
	mounted() {
	},
	methods: {
		forgot() {
			this.$store.dispatch("forgotPassword", {
				email: this.email,
				is_company: this.is_company
			}).then(res => {
				if(res.data.success) {
					this.$root.$alert.open("Success", res.data.result, () => {
						$(this.$el).modal("hide");
						this.email = '';
						this.is_company = false;
					});
				} else {
					this.$root.$alert.open("Failure", res.data.error);
				}
			})
		},
		open() {
			$(this.$el).modal("show");
		}
	}
}
</script>