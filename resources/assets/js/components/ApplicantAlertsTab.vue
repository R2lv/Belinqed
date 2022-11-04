<template>
	<!-- Start Message -->
	<div id="alerts" class="tab-pane fade">
		<spinner v-if="loading" />
		<div class="inbox-body inbox-widget">
			<div v-if="!loading && !alerts.length">{{ lang("applicant_dashboard_alerts_no_alerts") }}</div>
			<div class="mail-card unread" v-for="alert in alerts">
				<header class="card-header cursor-pointer collapsed" data-toggle="collapse" data-target="#full-message" aria-expanded="false">
					<div class="card-title flexbox" style="width: 100%">
						<img style="object-fit: contain" class="img-responsive img-circle avatar" :src="'/storage/'+alert.company.profile_image" alt="...">
						<div style="width: 100%">

							<div class="col-md-3">
								<h6 style="line-height: 23px; margin-top: 0;">{{alert.title}} <span v-if="!alert.read">{{ lang('applicant_dashboard_alerts_new') }}</span></h6>
							</div>

							<div class="col-md-3">
								<small><i class="fa fa-clock-o"></i> {{alert.created_at}}</small>
							</div>

							<div class="col-md-3">
								<small v-html="alert.text"></small> <br>
								<span v-if="alert.job">{{alert.job.job_title.title}}</span>
							</div>

							<div class="col-md-3">
								<small v-if="alert.url"><router-link tag="a" :to="alert.url" class="text-info" >{{ lang("applicant_dashboard_alerts_view_detail") }}</router-link></small>
							</div>

						</div>
					</div>
				</header>
			</div>


		</div>
	</div>
	<!-- End Message -->
</template>

<script>
	export default {
		name: "alerts-tab",
		data() {
			return {
				alerts_length: 0,
				alerts: [],
				loading: true
			}
		},
		created() {
			this.$store.dispatch("fetchUserAlerts")
				.then(res => {
					if(res.data.success) {
						this.alerts = res.data.result.list;
						this.alerts_length = res.data.result.new_length
					}
				})
				.finally(() => {
					this.loading = false;
				});
		},
		methods: {
			shown() {
				this.$store.dispatch("readUserAlerts")
						.then(res => {
							this.alerts_length = 0;
						});
			}
		}
	}
</script>