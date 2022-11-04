<template>
	<!-- Start Job List -->
	<div id="job-candidates" class="tab-pane fade">
		<spinner v-if="loading" />
		<h3>{{lang('company_dashboard_candidates_title')}}</h3>
		<div class="row">
			<template v-for="job in candidates">
				<article class="advance-search-job" v-for="resume in job.matches">
					<div class="row no-mrg">
						<div class="col-md-3 col-sm-3">
							<a :href="'/resume/'+resume.id+'/'+job.id" title="job Details">
								<div class="advance-search-img-box"><img :src="'/storage/'+resume.user.profile_picture_url" class="img-responsive" alt=""></div>
							</a>
							<div class="advance-search-caption"><a :href="'/resume/'+resume.id+'/'+job.id" title="Job Dtail"><h4>{{resume.user.name}} {{resume.user.surname}}</h4></a>
								<span>{{job.job_title.title}}</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<div class="advance-search-job-locat">
								<p><i class="fa fa-map-marker"></i>{{job.job_location}} <i class="fa fa-clock-o"></i>{{job.created_at}}</p>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 text-right">
							<a :href="'/resume/'+resume.id+'/'+job.id" class="btn advance-search" title="View">{{lang('view')}}</a>

							<a href="javascript:void(0)" @click.prevent="requestShortVideo(resume,job)" v-if="!resume.pivot.requested_short_video" :disabled="!!resume.pivot.accepted_by_company" class="btn advance-search" title="Request Custom Short Video">{{lang('company_dashboard_candidates_request_csv')}}</a>
							<a href="javascript:void(0)" @click.prevent="playShortVideo(resume)" v-else-if="resume.pivot.short_video_url" class="btn advance-search" title="Request Custom Short Video">{{lang('company_dashboard_candidates_play_csv')}}</a>
							<a href="javascript:void(0)" v-else class="btn advance-search disabled" title="Custom Short Video Requested">{{lang('company_dashboard_candidates_csv_requested')}}</a>

							<a href="javascript:void(0)" @click.prevent="acceptResume(resume,job)" :disabled="!!resume.pivot.accepted_by_company" class="btn advance-search" title="Accept"><i class="fa fa-check"></i> {{resume.pivot.accepted_by_company===1 ? lang('accepted'):lang('accept')}}</a>
							<a href="javascript:void(0)" @click.prevent="declineResume(resume,job)" :disabled="!!resume.pivot.accepted_by_company" class="btn advance-search" title="Decline"><i class="fa fa-times"></i> {{resume.pivot.accepted_by_company===-1 ? lang('declined'):lang('decline')}}</a>
						</div>
					</div>

				</article>
			</template>
		</div>
	</div>
	<!-- End Job List -->
</template>

<script>
export default {
	name: "job-candidates",
	data() {
		return {
			loading: true,
			candidates: []
		}
	},
	created() {
		this.$store.dispatch('fetchJobCandidates')
			.then(res => {
				this.candidates = res.data.result;
			})
			.finally(() => {
				this.loading = false;
			})
	},
	methods: {
		acceptResume(resume, job) {
			this.$store.dispatch("acceptResume", {
				job_id: job.id,
				resume_id: resume.id
			}).then(res => {
				if(res.data.success) {
					resume.pivot.accepted_by_company = 1;
					this.$root.$alert.open("Success", "Accepted successfully");
				} else {
					this.$root.$alert.open(res.data.error);
				}
			})
		},
		declineResume(resume, job) {
			this.$root.$prompt.open({
				title: "The reason",
				text: "Please explain the reason of decline (You can still leave it blank)"
			}, val => {
				this.$store.dispatch("declineResume", {
					job_id: job.id,
					resume_id: resume.id,
					reason: val
				}).then(res => {
					if(res.data.success) {
						resume.pivot.accepted_by_company = -1;
						this.$root.$alert.open("Success", "Declined successfully");
					} else {
						this.$root.$alert.open(res.data.error);
					}
				});
			});
		},

		requestShortVideo(resume,job) {

			this.$root.$prompt.open({
					title: "The CSV Request",
					text: "Please ask questions for Short Video"
				}, val => {
					this.$store.dispatch("requestShortVideo", {
						job_id: job.id,
						resume_id: resume.id,
						text: val
					}).then(res => {
						if (res.data.success) {
							resume.pivot.requested_short_video = 1;
							this.$root.$alert.open("Success", "Requested successfully");
						} else {
							this.$root.$alert.open(res.data.error);
						}
					})
			});
		},
		playShortVideo(resume) {
			// window.open('/storage/'+resume.pivot.short_video_url, "_blank").focus();

			this.$root.$video.open('CSV Video','/storage/'+resume.pivot.short_video_url);
		},
	}
}
</script>