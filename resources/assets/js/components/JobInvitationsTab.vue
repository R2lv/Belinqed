<template>
	<!-- Start Job List -->
	<div id="vacancy-matches" class="tab-pane fade">
		<spinner v-if="loading" />
		<h3>{{ lang("applicant_dashboard_matched_title") }}</h3>
		<div class="row">
			<article class="advance-search-job" v-for="job in matches">
				<div class="row no-mrg">
					<div class="col-md-3 col-sm-3">
						<a :href="'/job/'+job.id+'/public'" title="job Details">
							<div class="advance-search-img-box"><img :src="'/storage/'+job.company.profile_image" class="img-responsive" alt=""></div>
						</a>
						<div class="advance-search-caption"><a :href="'/job/'+job.id+'/public'" title="Job Dtail"><h4>{{job.job_title.title}}</h4></a><span>{{job.company.company_name}}</span></div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="advance-search-job-locat">
							<p><i class="fa fa-map-marker"></i>{{job.job_location}} <i class="fa fa-clock-o"></i>{{job.created_at}}</p>

						</div>

					</div>
					<div class="col-md-5 col-sm-5 text-right">
						<router-link tag="a" :to="'/job/'+job.id+'/public'" class="btn advance-search" title="View">{{lang('view')}}</router-link>
						<a href="javascript:void(0)" class="btn advance-search" v-if="job.pivot.requested_short_video && !job.pivot.short_video_url && !job.pivot.accepted_by_company && !job.pivot.accepted_by_user" @click="showSendCSV(job)" title="Send Custom Short Video">{{ lang("applicant_dashboard_matched_send_csv") }}</a>
						<a href="javascript:void(0)" @click.prevent="accept(job)" v-if="job.pivot.accepted_by_company===1" :disabled="!!job.pivot.accepted_by_user" class="btn advance-search" title="Accept">{{job.pivot.accepted_by_user===1 ? lang('accepted'):lang('accept')}}</a>
						<a href="javascript:void(0)" @click.prevent="decline(job)" v-if="job.pivot.accepted_by_company===1" :disabled="!!job.pivot.accepted_by_user" class="btn advance-search" title="Decline">{{job.pivot.accepted_by_user===-1 ? lang('declined'):lang('decline')}}</a>
					</div>
				</div>
				<!--<span class="tg-themetag tg-featuretag">Premium</span>-->
			</article>
			<send-csv ref="sendCSVModal" @submit="sendCSV"></send-csv>
		</div>
	</div>
	<!-- End Job List -->
</template>

<script>
export default {
	name: "job-invitations",
	data() {
		return {
			loading: true,
			matches: []
		}
	},
	created() {
		this.call();
	},
	methods: {
		call(){
			this.$store.dispatch('fetchMyMatches')
				.then(res => {
					this.matches = res.data.result;
				})
				.finally(() => {
					this.loading = false;
				})
		},
		accept(job) {
			if(!!job.pivot.accepted_by_user) return;
			this.$store.dispatch("acceptJob", {
				resume_id: this.$store.state.resume.id,
				job_id: job.id
			}).then(res => {
				if(res.data.success) {
					job.pivot.accepted_by_user = 1;
					this.$root.$alert.open("Success", "Accepted successfully");
				}
			})
		},
		decline(job) {
			if(!!job.pivot.accepted_by_user) return;

			this.$root.$prompt.open({
				title: "The reason",
				text: "Please explain the reason of decline (You can still leave it blank)"
			}, val => {
				this.$store.dispatch("declineJob", {
					resume_id: this.$store.state.resume.id,
					job_id: job.id,
					reason: val
				}).then(res => {
					if(res.data.success) {
						job.pivot.accepted_by_user = -1;
						this.$root.$alert.open("Success", "Declined successfully");
					}
				})
			});
		},
		showSendCSV(job) {
			this.$refs.sendCSVModal.open();
			this.csv_active_job = job;
		},
		sendCSV(file) {
			var that = this;
			this.loading = true;
			let formData = new FormData();
			formData.append("video", file);
			this.$store.dispatch("sendShortVideo", {
				formData,
				job_id: this.csv_active_job.id
			})
			.then(res=>{
				this.$root.$alert.open("Success", "Sent successfully",function(){
					that.call();
				});

			})
		}
	}
}
</script>