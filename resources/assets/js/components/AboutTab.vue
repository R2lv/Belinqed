<template>
<div id="about" class="tab-pane fade" style="min-height: 230px">
	<spinner v-if="loading" />
	<div class="row">
		<div class="col-md-9">
			<h3>{{ lang("applicant_dashboard_about_title") }}</h3>
			<div v-html="formatText(resume.about)">
			</div>
		</div>
		<div class="col-md-3">
			<div class="get-touch">
				<h4>{{ lang("applicant_dashboard_get_in_touch" )}}</h4>
				<ul>
					<li><i class="fa fa-user icon-compact-info"></i><span>{{profile.name}} {{profile.surname}}</span></li>
					<li v-if="resume.current_job"><i class="fa fa-briefcase icon-compact-info"></i><span>{{resume.current_job.title}}</span></li>
					<li v-if="resume.current_job_sector"><i class="fa fa-file icon-compact-info"></i><span>{{resume.current_job_sector.title}}</span></li>
					<li><i class="fa fa-map-marker icon-compact-info"></i><span>{{userLocation}}</span></li>
					<li><i class="fa fa-envelope icon-compact-info"></i><span>{{profile.email}}</span></li>
					<li><i class="fa fa-phone icon-compact-info"></i><span>{{profile.mobile_number}}</span></li>
					<li><i class="fa fa-eye icon-compact-info"></i><span>{{ lang("applicant_dashboard_about_viewed_by") }} {{profile.profile_viewed}}</span></li>
					<li><i class="fa fa-birthday-cake icon-compact-info"></i><span>{{age}} {{ lang("applicant_dashboard_about_years_old") }}</span></li>
					<li v-if="last_education"><i class="fa fa-graduation-cap icon-compact-info"></i><span>{{last_education.institution_name}} <span v-if="last_education.education_field"> ({{last_education.education_field.name}})</span></span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</template>

<script>
import {mapState} from 'vuex';
export default {
	name: "about-tab",
	methods: {
		formatText(about) {
			return about ? about.replace(/\n/ig, "<br>") : "";
		},
		calculateAge(birthday) { // birthday is a date
			var ageDifMs = Date.now() - new Date(birthday);
			var ageDate = new Date(ageDifMs); // miliseconds from epoch
			return Math.abs(ageDate.getUTCFullYear() - 1970);
		}
	},
	computed: {
		...mapState(['resume','profile']),
		loading() {
			return this.$store.state.loadings.resume || this.$store.state.loadings.profile;
		},
		userLocation() {
			if(this.profile && this.profile.city && this.profile.city.country) {
				return this.profile.city.title+", "+this.profile.city.country.title;
			}
			return "";
		},
		age() {
			return this.calculateAge(this.profile.birthday);
			// return moment().diff(moment(this.profile.birthday, "YYYY-DD-MM"), "years");
		},
		last_education() {
			if(this.resume) {
				let sortedEducation = _(this.resume.education).sortBy('end_date').reverse().value();
				return sortedEducation[0];
			}
			return {};
		},
	}
}
</script>