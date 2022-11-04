<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url(/img/banner-1.jpeg);">
		<div class="container">
			<h1>Reset Password</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Top Features Section Start-->
	<section class="wp-process" >
		<div class="container">
			<div class="row">
				<form style="display: block; width: 350px; margin: 0 auto" @submit.prevent="reset">
					<div class="form-group">
						<input type="text" class="form-control" name="Password" v-model="email" placeholder="E-mail address">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="Password" v-model="password" placeholder="New password">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="Confirm Password" v-model="password_confirmation" placeholder="Confirm password">
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Reset Password</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Top Features Section End-->

</div>
</template>

<script>
export default {
	data() {
		return {
			email: '',
			password: '',
			password_confirmation: ''
		}
	},
	methods: {
		reset() {
			this.$store.dispatch("resetPassword", {
				token: this.$route.params.token,
				is_company: this.$route.params.is_company,
				email: this.email,
				password: this.password,
				password_confirmation: this.password_confirmation
			}).then(res => {
				if(res.data.success) {
					this.$auth.login(!!this.$route.params.is_company);
					this.$root.$alert.open("Success", res.data.result, () => {
						location.href = "/";
					});
				} else {
					this.$root.$alert.open("Failure", res.data.error);
				}
			})
		}
	}
}
</script>