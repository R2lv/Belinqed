<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url(/img/background-login-2.jpg);">
		<div class="container">
			<h1></h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- pricing Section Start -->
	<section class="pricing">
		<div class="container loader-container">
			<spinner v-if="loading" />
			<div class="row" v-else>

				<div class="col-md-4 col-sm-4 col-centered" v-for="pkg in packages">
					<div class="pr-table">
						<div class="pr-plan">
							<h4>{{pkg.name}}</h4>
						</div>
						<div class="pr-price">
							<h3><sup>{{pkg.currency}}</sup>{{pkg.price}}<sub></sub></h3>
						</div>
						<div class="pr-features">
							<ul>
								<li><strong>{{pkg.vacancies}}</strong> Vacancies</li>
								<li><strong>{{pkg.candidates}}</strong> Candidates per vacancy ({{pkg.candidates * pkg.vacancies}} all)</li>
								<li><strong>{{pkg.days_active}}</strong> Vacancy active days</li>
								<li><i class="fa fa-check"></i> Email and SMS Notifications</li>
							</ul>
						</div>
						<div class="pr-buy-button">
							<a href="#" class="pr-btn" title="Price Button" @click.prevent="pay(pkg)">Get Started</a>
						</div>
					</div>
				</div>

			</div>

		</div>
	</section>
	<!-- End Pricing Section -->
</div>
</template>
<script>
export default {
	data() {
		return {
			loading: true,
			packages: []
		}
	},
	created() {
		this.$store.dispatch("fetchPackages")
			.then(res=> {
				if(res.data.success)
					this.packages = res.data.result;
				this.loading = false;
			})
	},
	methods: {
		pay(pkg) {
			if(this.$auth.isCompany()) {
				this.$root.$confirm.open({
					title: "Confirm",
					text: `You are going to buy <strong>${pkg.name}</strong>, are you sure ?`
				}, val => {
					this.$store.dispatch("buyPackage", {
						package_id: pkg.id
					}).then(res => {
						if(res.data.success) {
							let form = document.createElement("form");
							form.method = "POST";
							form.action = res.data.result.redirect_url;
							let input = document.createElement("input");
							input.type = "hidden";
							input.name = "trans_id";
							input.value = res.data.result.trans_id;
							form.append(input);
							form.style.display = "none";
							document.body.appendChild(form);
							form.submit();

						} else {
							this.$root.$alert.open("Failure", res.data.error);
						}
					});
				});
			}
		}
	}
}
</script>