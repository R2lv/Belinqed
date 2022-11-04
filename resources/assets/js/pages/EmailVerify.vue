<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url(/img/banner-1.jpeg);">
		<div class="container">
			<h1>Email Verification</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Top Features Section Start-->
	<section class="wp-process" >
		<div class="container">
			<div class="row">
				<div class="main-heading">
					<p v-if="status" class="status">{{status}}</p>
					<h2>{{text}}</h2>
				</div>
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
			status: '',
			text: ''
		}
	},
	created() {
		this.status = this.lang("please_wait");
		this.text = this.lang("verifying_your_email_address");
		console.log("ASF");
		this.$store.dispatch("verifyEmail", {
			id: this.$route.params.id,
			token: this.$route.params.token,
			type: this.$route.params.type
		}).then(res => {
			this.status = "";
			if(res.data.success) {
				this.text = res.data.result;
			} else {
				this.text = res.data.error;
			}
		});
	}
}
</script>