<template>
<div>

	<spinner v-if="loading" />

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url('/img/banner-4.jpg');">
		<div class="container">
			<h1 class="no-print">{{lang('company_job_detail_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Job Detail Start -->
	<section class="detail-desc">
		<div class="container white-shadow">

			<div class="row">

				<div class="detail-pic">
					<img :src="job.company ? '/storage/'+job.company.profile_image : ''" class="img containFit" alt="" />
				</div>

				<div class="detail-status">
					<span>{{job.created_at}}</span>
				</div>

			</div>

			<div class="row bottom-mrg">
				<div class="col-md-8 col-sm-8">
					<div class="detail-desc-caption">
						<h4>{{job.company ? job.company.company_name : ''}}</h4>
						<span class="designation"></span>
						<p class="description-text" v-html="replaceBreak(job)"></p>
					</div>
				</div>

				<div class="col-md-4 col-sm-4">
					<div class="get-touch">
						<h4>{{lang('company_public_job_detail_general_information')}}</h4>
						<ul>
							<li><i class="fa fa-map-marker"></i><span>{{job.company ? job.company.company_name : ''}}</span></li>
							<li><i class="fa fa-map-marker"></i><span>{{job.job_location}}</span></li>
						</ul>

						<h4 style="margin-top: 10px">{{lang('company_public_job_detail_job_requirements')}}</h4>
						<ul>
							<li> <span class=" tx-bold-underline" >{{lang('resume_general_job_title')}}: </span> <span>{{job.job_title ? job.job_title.title : ''}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_details_job_sector')}}: </span> <span>{{job.job_sector ? job.job_sector.title : ''}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_job_detail_job_salary')}}: </span> <span>{{job.job_salary ? job.job_salary.name : ''}}/ {{lang('month')}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_details_job_job_hours')}}: </span> <span>{{job.job_hours ? job.job_hours.name : ''}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_job_detail_min_work_exp')}}: </span> <span>{{job.minimum_experience}} {{lang('year_exp')}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_job_detail_availability')}}: </span> <span v-if="job.available_from">{{job.available_from.name}}</span></li>
							<li> <span class=" tx-bold-underline" >{{lang('company_details_job_career_level')}}: </span> <span v-if="job.job_career_level">{{job.job_career_level.name}}</span></li>
						</ul>
					</div>
				</div>

			</div>

			<div class="row no-padd">
				<div class="detail pannel-footer">
					<div class="col-md-5 col-sm-5">
						<ul class="detail-footer-social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>

					<div class="col-md-7 col-sm-7">

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Job Detail End -->

	<!-- Job full detail Start -->
	<section class="full-detail-description full-detail">
		<div class="container">
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('company_public_job_detail_match_options')}}</h2>
				<p v-if="match.job.job_title">{{lang('company_public_job_detail_matched_to_job')}} <strong>{{match.job.job_title.title}}</strong>.</p>
				<div style="text-align: center">
					<div class="match-option-buttons">
						<button class="btn btn-primary" v-if="match.requested_short_video && !match.short_video_url && !match.accepted_by_company && !match.accepted_by_user" @click.prevent="showSendCSV"> {{lang('Send Custom Short Video')}}</button>
						<button class="btn btn-primary accept" v-if="match.accepted_by_company===1" :disabled="!!match.accepted_by_user" @click="acceptJob"><i class="fa fa-check"></i> {{match.accepted_by_user===1 ? lang('company_public_job_detail_invitation_accepted'):lang('company_public_job_detail_accept_invitation')}}</button>
						<button class="btn btn-primary reject" v-if="match.accepted_by_company===1" :disabled="!!match.accepted_by_user" @click="declineJob"><i class="fa fa-times"></i> {{match.accepted_by_user===-1 ? lang('company_public_job_detail_invitation_declined'):lang('company_public_job_detail_decline_invitation')}}</button>
					</div>
				</div>
				<p v-if="match.requested_short_video">{{match.csv_questions}}</p>
				<send-csv ref="sendCSVModal" @submit="sendCSV"></send-csv>
			</div>
			<!-- </editor-fold> -->

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('create_job_education_title')}}</h2>
				<p class="no-print">{{lang('company_job_detail_education_requirements')}}</p>
				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('company_job_detail_education_type')}}</th>
						<th>{{lang('company_job_detail_education_level')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr data-valign="middle" v-if="job.education_field">
						<td>{{job.education_field.name}}</td>
						<td>{{job.education_level.name}}</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('create_job_Competencies_title')}}</h2>
				<p>{{lang('company_job_detail_competencies_required')}}</p>
				<ul class="detail-list">
					<li v-for="competency in job.job_competencies">{{competency.name}}</li>
				</ul>
			</div>

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('company_job_detail_driver_licenses')}}</h2>
				<p>{{lang('company_job_detail_driver_licenses_required')}}</p>
				<ul class="detail-list">
					<li v-for="driver_license in job.job_driver_licenses">{{driver_license.name}}</li>
				</ul>
			</div>

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('create_job_languages_title')}}</h2>
				<p>{{lang('company_job_detail_languages_required')}}</p>
				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('create_job_languages_title')}}</th>
						<th>{{lang('company_job_detail_speaking_level')}}</th>
						<th>{{lang('company_job_detail_writing_level')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="language in job.job_languages">
						<td>{{language.name}}</td>
						<td>{{getLangLevel(language.pivot.level_speaking)}}</td>
						<td>{{getLangLevel(language.pivot.level_writing)}}</td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('company_job_detail_employment_types')}}</h2>
				<p>{{lang('company_job_detail_employment_types_required')}}</p>
				<ul class="detail-list">
					<li v-for="type in job.job_employment_types">{{type.name}}</li>
				</ul>
			</div>

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('create_job_software_knowledge_title')}}</h2>
				<p>{{lang('company_job_detail_software_required')}}</p>

				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('company_job_detail_software_name')}}</th>
						<th>{{lang('company_details_job_education_level')}}</th>
						<th>{{lang('graduated')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="soft_knowledge in job.software_knowledge" data-valign="middle" v-if="soft_knowledge.software">
						<td>{{soft_knowledge.software.name}}</td>
						<td>{{soft_knowledge.knowledge.name}}</td>
						<td>{{soft_knowledge.graduated ? lang('yes'):lang('no')}}</td>
<!--						<td><star-select :max="5" :value="soft_knowledge.knowledge_level" :readonly="true" /></td>-->
					</tr>
					</tbody>
				</table>
			</div>


			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('company_job_detail_job_location')}}</h2>
				<div id="location_map" style="height: 400px"></div>
			</div>


		</div>
	</section>
	<!-- Job full detail End -->

</div>
</template>

<script>
export default {
	data() {
		return {
			match: {
				job:{},
				accepted_by_user:1,
				accepted_by_company:1

				},
			loading: true,
			isCompany: false
		}
	},
	created() {
		this.$store.dispatch("fetchPublicJob", {id: this.$route.params.id})
			.then(res => {
				if(res.data.success) {
					this.match = res.data.result;
					this.initMap();
				}
			})
			.finally(() => {
				this.loading = false;
			});
	},
	methods: {
		getLangLevel(level) {
			return this.languageLevels[level];
		},
		initMap() {
			let latlng = {lat: this.job.job_location_lat, lng: this.job.job_location_lng};
			this.map = new google.maps.Map($(this.$el).find("#location_map").get(0), {
				center: latlng,
				zoom: 10
			});

			this.marker = new google.maps.Marker({
				position: latlng,
				map: this.map,
				title: 'Job Location'
			});
		},
		acceptJob() {
			this.$store.dispatch("acceptJob", {
				resume_id: this.$store.state.resume.id,
				job_id: this.job.id
			}).then(res => {
				if(res.data.success) {
					this.match.accepted_by_user = 1;
					// this.match.job.pivot.accepted_by_user = 1;
					this.$root.$alert.open("Success", "Accepted");


				}
			})
		},
		declineJob() {
			this.$root.$prompt.open({
				title: "The reason",
				text: "Please explain the reason of decline (You can still leave it blank)"
			}, val => {
				this.$store.dispatch("declineJob", {
					resume_id: this.$store.state.resume.id,
					job_id: this.job.id,
					reason: val
				}).then(res => {
					if(res.data.success) {
						// this.match.job.pivot.accepted_by_user = -1;
						this.match.accepted_by_user = 1;
						this.$root.$alert.open("Success", "Declined");

					}
				})
			});
		},
		showSendCSV() {
			this.$refs.sendCSVModal.open();
		},
		sendCSV(file) {
			let formData = new FormData();
			formData.append("video", file);
			this.$store.dispatch("sendShortVideo", {
				formData,
				job_id: this.job.id
			})
		},
		replaceBreak(job){
			return job.job_description ? job.job_description.replace(/(?:\r\n|\r|\n)/g, '<br />') : "";
		}
	},
	computed: {
		languageLevels() {
			return {
				1: this.lang("bad"),
				2: this.lang("normal"),
				3: this.lang("good"),
				4: this.lang("excellent")
			};
		},
		job() {
			return this.match.job;
		}
	}
}
</script>