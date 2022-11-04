<template>
<!-- Start Message -->
<div id="alerts" class="tab-pane fade">
	<spinner v-if="loading" />
	<div class="inbox-body inbox-widget">
		<div class="mail-card unread" v-for="alert in alerts">
			<header class="card-header cursor-pointer collapsed" data-toggle="collapse" data-target="#full-message" aria-expanded="false">
				<div class="card-title flexbox">
					<img class="img-responsive img-circle avatar" :src="'/storage/'+alert.company.profile_image" alt="...">
					<div>
						<h6>{{alert.title}}</h6>
						<small>{{alert.text}}</small>
						<!--<small><a class="text-info collapsed" href="#detail-view" data-toggle="collapse" aria-expanded="false">View Detail</a></small>-->

						<div class="no-collapsing cursor-text collapse" id="detail-view" aria-expanded="false" style="height: 0px;">
							<small class="d-inline-block">From:</small>
							<small>theadmin@thetheme.io</small>
							<br>
							<small class="d-inline-block">To:</small>
							<small>subscriber@yahoo.com</small>
						</div>
					</div>
				</div>
			</header>
			<!--
			<div class="collapse" id="full-message" aria-expanded="false" style="height: 0px;">
				<div class="card-body">
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia.</p>
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				</div>
			</div>-->
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
			alerts: [],
			loading: true
		}
	},
	created() {
		this.$store.dispatch("fetchCompanyAlerts")
			.then(res => {
				if(res.data.success) {
					this.alerts = res.data.result;
				}
			})
			.finally(() => {
				this.loading = false;
			});
	}
}
</script>