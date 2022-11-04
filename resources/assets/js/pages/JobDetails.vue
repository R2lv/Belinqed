<template>
<div>

	<div class="disnone printLogoTop printblock">
		<img src="/img/logo.png" class="logo logo-display" alt="">
	</div>

	<spinner v-if="loading" />

	<!-- Title Header Start -->
	<section class="inner-header-title " style="background-image:url('/img/banner-4.jpg');">
		<div class="container">
			<h1 class="no-print">{{lang('company_job_detail_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Job Detail Start -->
	<section class="detail-desc tx-padding-0">
		<div class="container white-shadow">

			<div class="row">

				<div class="detail-pic">
					<img  :src="job.company ? '/storage/'+job.company.profile_image : ''" class="img containFit" alt="" />
				</div>

				<div class="detail-status no-print">
					<span>{{job.created_at}}</span>
				</div>

			</div>

			<div class="row bottom-mrg">
				<div class="col-md-8 col-sm-8">
					<div class="detail-desc-caption">
<!--						<h4>{{job.company ? job.company.company_name : ''}}</h4> todo remove if -->
						<h4>{{lang('company_details_job_job_description')}}</h4>
						<span class="designation"></span>
						<p class="description-text" style="overflow: hidden; " :class="{'fixedHaightFourHundred': replaceBreak(job).length > 1500 && !readMore }" v-html="replaceBreak(job)"></p>
						<a href="#" @click.prevent="readMore = !readMore" class="pull-right" v-if="replaceBreak(job).length > 1500"> <span v-if="readMore">{{lang('read_more')}}</span> <span v-else>{{lang('read_less')}}</span></a>
					</div>
				</div>

				<div class="col-md-4 col-sm-4">
					<div class="get-touch">
						<h4>{{lang('company_job_detail_general_information')}}</h4>
						<ul>
							<template v-if="job.matches">
								<li><i class="fa fa-map-marker"></i><span>{{job.company ? job.company.company_name : ''}}</span></li>
								<li><i class="fa fa-map-marker"></i><span>{{job.job_location}}</span></li>
								<li><i class="fa fa-envelope"></i><span>{{job.company ? job.company.email : ''}}</span></li>
								<li><i class="fa fa-globe"></i><span>{{job.company ? job.company.company_website : ''}}</span></li>
							</template>
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
	<section class="full-detail-description full-detail tx-padding-0">
		<div class="container">


			<div class="row row-bottom" v-if="job.matches" :class="{'no-print':!job.matches.length}">
				<h2 class="detail-title">{{lang('company_job_detail_matches')}}</h2>
				<div class="matches">

					<article v-for="resume in job.matches">
						<div class="mng-resume">
							<div class="col-md-2 col-sm-2">
								<div class="mng-resume-pic">
									<img :src="'/storage/'+resume.user.profile_picture_url" class="img-responsive containFit" alt="" />
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="mng-resume-name">
									<h4>{{resume.user.name}} {{resume.user.surname}} <span class="cand-designation"></span></h4>
								</div>
							</div>
							<div class="col-md-3 col-sm-4 col-md-offset-1  col-sm-offset-1">
								<div class="mng-employee-skill">
									<span>{{resume.current_job ? resume.current_job.title : ''}}</span>
								</div>
							</div>
							<div class="col-md-3 col-sm-2">
								<a :href="'/resume/'+resume.id+'/'+job.id" class="btn advance-search" title="View">{{lang('view')}}</a>
								<a href="javascript:void(0)" @click.prevent="playShortVideo(resume)" v-if="resume.pivot.short_video_url" class="btn advance-search" :title="'company_job_detail_request_csv' | translate">Play CSV</a>
							</div>
						</div>
					</article>

				</div>
			</div>

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('create_job_education_title')}}</h2>
				<p class="no-print">{{lang('company_job_detail_education_requirements')}}</p>
				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('company_job_detail_education_type')}}</th>
						<th>{{lang('company_job_detail_education_level')}}</th>
						<th>{{lang('start')}}</th>
						<th>{{lang('end')}}</th>
						<th>{{lang('graduated')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr data-valign="middle" v-if="job.education_field">
						<td>{{job.education_field.name}}</td>
						<td>{{job.education_level.name}}</td>
						<td>{{formatDate(job.education_start_date)}}</td>
						<td>{{formatDate(job.education_end_date)}}</td>
						<td>{{job.education_graduated ? lang('yes') : lang('no')}}</td>
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
				<h2 class="detail-title">{{lang('company_job_detail_employment_types')}}</h2>
				<p>{{lang('company_job_detail_employment_types_required')}}</p>
				<ul class="detail-list">
					<li v-for="type in job.job_employment_types">{{type.name}}</li>
				</ul>
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
			job: {},
			loading: true,
			isCompany: false,
			readMore: false
		}
	},
	created() {
		this.$store.dispatch("fetchJob", {id: this.$route.params.id})
			.then(res => {
				if(res.data.success) {
					this.job = res.data.result;
					this.initMap();
				}
			})
			.finally(() => {
				this.loading = false;
			});
	},
	methods: {
		playShortVideo(resume) {
			// window.open('/storage/'+resume.pivot.short_video_url, "_blank").focus();
			this.$root.$video.open('CSV Video','/storage/'+resume.pivot.short_video_url);
		},
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
	}
}
</script>