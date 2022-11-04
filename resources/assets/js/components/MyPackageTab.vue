<template>
	<!-- Start Job List -->
	<div id="my-package" class="tab-pane fade">
		<spinner v-if="loading" />
		<h3>{{lang('company_dashboard_my_package_title')}}</h3>
		<div class="row">
			<div class="col-md-offset-4 col-sm-offset-4 col-md-4 col-sm-4">
				<br>
				<br>
				<template v-if="pkg && pkg.vacancies">
				<div class="pr-table">
					<div class="pr-plan">
						<h4>{{pkg.name}}</h4>
					</div>
					<div class="pr-price">
						<h3><sup>{{pkg.currency}}</sup>{{pkg.price}}<sub></sub></h3>
					</div>
					<div class="pr-features">
						<ul>
							<li><strong>{{pkg.vacancies}}</strong> {{lang('company_dashboard_my_package_vacancies_left')}}</li>
							<li><strong>{{pkg.candidates}}</strong> {{lang('company_dashboard_my_package_candidates_per_vacancy')}}</li>
							<li><strong>{{pkg.days_active}}</strong> {{lang('company_dashboard_my_package_vacancy_active_days')}}</li>
							<li><i class="fa fa-check"></i> {{lang('company_dashboard_my_package_email_and_sms')}}</li>
						</ul>
					</div>
				</div>
				</template>
				<template v-else-if="!loading">
					{{lang('company_dashboard_my_package_no_package')}} <router-link tag="a" to="/pricing">{{lang('company_dashboard_my_package_pricing')}}</router-link>
				</template>
			</div>
		</div>
	</div>
	<!-- End Job List -->
</template>

<script>
export default {
	name: "job-candidates",
	data() {
		return {
			pkg: {},
			loading: true,
			candidates: []
		}
	},
	created() {
		this.$store.dispatch('fetchMyPackage')
			.then(res => {
				this.pkg = res.data.result;
			})
			.finally(() => {
				this.loading = false;
			})
	},
	methods: {

	}
}
</script>