<template>
<div>

	<spinner v-if="loading_resume" :spinner-style="{'vertical-align': 'top', 'margin-top': '50vh'}" />

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url('/img/banner-7.jpg');">
		<div class="container">
			<h1>{{lang('resume_general_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Resume Detail Start -->
	<section class="detail-desc tx-padding-0">
		<div class="container white-shadow">
			<div class="row">
				<div class="detail-pic">
					<img  :src="'/storage/'+profile.profile_picture_url" class="img containFit" alt="" />
					<router-link :to="'/applicant/dashboard#settings.1100'" class="detail-edit" title="edit" ><i class="fa fa-pencil"></i></router-link>
				</div>
				<div class="detail-status">
					<!--<span>7 Hour Ago</span>-->
				</div>
			</div>
			<div class="row bottom-mrg">
				<div class="col-md-8 col-sm-8">
					<div class="detail-desc-caption">
						<h4>{{lang('resume_general_about_me')}}</h4>
						<p v-html="formatText(resume.about)"></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="get-touch">
						<h4>{{lang('resume_general_get_in_touch')}}</h4>
						<ul>
							<li><i class="fa fa-user icon-compact-info"></i><span>{{profile.name}} {{profile.surname}}</span></li>
							<li v-if="resume.current_job"><i class="fa fa-briefcase icon-compact-info"></i><span>{{resume.current_job.title}}</span></li>
							<li v-if="resume.current_job_sector"><i class="fa fa-file icon-compact-info"></i><span>{{resume.current_job_sector.title}}</span></li>
							<li><i class="fa fa-map-marker icon-compact-info"></i><span>{{userLocation}}</span></li>
							<li><i class="fa fa-envelope icon-compact-info"></i><span>{{profile.email}}</span></li>
							<li><i class="fa fa-phone icon-compact-info"></i><span>{{profile.mobile_number}}</span></li>
							<li><i class="fa fa-eye icon-compact-info"></i><span>{{lang('applicant_dashboard_about_viewed_by')}} {{profile.profile_viewed}}</span></li>
							<li><i class="fa fa-birthday-cake icon-compact-info"></i><span>{{age}} {{lang('applicant_dashboard_about_years_old')}}</span></li>
							<li v-if="last_education"><i class="fa fa-graduation-cap icon-compact-info"></i>
								<span>
									<template  >
										<span v-if="last_education.institution_name">
											{{last_education.institution_name}}
										</span>
										<span v-else class="text-custom-danger">
											{{lang('empty')}}
										</span>
									</template>

									<template  >
										<span v-if="last_education.education_field">
											{{last_education.education_field.name}}
										</span>
										<span v-else class="text-custom-danger">
											{{lang('empty')}}
										</span>
									</template>


								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row no-padd">
				<div class="detail pannel-footer">
					<div class="col-md-9 col-sm-9">
						<ul class="detail-footer-social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							<li>{{lang('resume_general_last_modified')}} {{formatDate(resume.updated_at)}}</li>
							<li>{{lang('resume_general_job_seeker')}} {{resume.looking_for_job ? lang('yes'):lang('no')}}</li>
							<li>{{lang('resume_general_visibility')}} public</li>

							<!--todo edit visibility public to live version-->
						</ul>
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="detail-pannel-footer-btn pull-right">
							<!--<a href="#" class="footer-btn grn-btn" title="">Apply Now</a>-->
							<router-link :to="'/resume-edit'" class="footer-btn blu-btn" title="">{{lang('edit')}}</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Resume Detail End -->

	<section class="full-detail-description full-detail tx-padding-0">
		<div class="container">

			<!-- <editor-fold desc="Video"> -->
			<div class="row row-bottom">
				<h2 class="detail-title" id="my-video">{{lang('video')}}</h2>
				<div style="text-align: center">
					<video v-if="videoUrl" height="450" controls preload="auto" width="70%" style="width: 100%" class="video-player video-js vjs-default-skin">
						<source :src="videoUrl" type="video/mp4">
					</video>
				</div>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Work Experience"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_work_experience')}}</h2>

				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('resume_general_company_name')}}</th>
						<th>{{lang('resume_general_job_sector')}}</th>
						<th>{{lang('resume_general_job_location')}}</th>
						<th>{{lang('resume_general_job_title')}}</th>
						<th>{{lang('resume_general_job_description')}}</th>
						<th>{{lang('start')}}</th>
						<th>{{lang('end')}}</th>
						<th>{{lang('resume_general_years_months')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="employment in resume.employment_history" data-valign="middle">
						<td>
							<span v-if="employment.title">
								{{employment.title}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>
						</td>
						<td>
							<span v-if="employment.job_sector">
								{{employment.job_sector.title}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>

						</td>
						<td>
							<span v-if="employment.job_location">
								{{employment.job_location}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>
						</td>
						<td>
							<span v-if="employment.job_title">
								{{employment.job_title.title}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>

						</td>
						<td>
							<span v-if="employment.job_description">
								<div style="max-width: 300px">{{emp_desc(employment)}}<a href="#" @click.prevent="toggleEmpDesc(employment)" v-if="employment.job_description.length > desc_max_length"><br>{{lang('read')}} <template v-if="employment._show_full_desc">{{lang('less')}}</template><template v-else>{{lang('more')}}</template></a></div>
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>
						</td>
						<td>
							<span v-if="employment.start_date">
								{{formatDate(employment.start_date)}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>

						</td>
						<td>
							<span v-if="employment.end_date">
								{{formatDate(employment.end_date)}}
							</span>
							<span v-else-if="employment.start_date && !employment.end_date">
								{{lang('resume_general_currently_working')}}
							</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>

						</td>
						<td>

							<span v-if="employment.start_date && employment.end_date" >{{ differenceInTime(employment.start_date, employment.end_date) }}</span>
							<span v-else-if="employment.start_date">{{ differenceInTime(employment.start_date) }}</span>
							<span v-else class="text-custom-danger">{{lang('empty')}}</span>

						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Software Knowledge"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_software_knowledge')}}</h2>

				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('name')}}</th>
						<th>{{lang('resume_general_software_knowledge_level')}}</th>
						<th>{{lang('resume_general_graduated')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="soft_knowledge in resume.software_knowledge" data-valign="middle">
						<td>
							<span v-if="soft_knowledge.software_id"> {{soft_knowledge.software.name}} </span>
							<span class="text-custom-danger" v-else> {{lang('empty')}} </span>
						</td>
						<td>
							<span v-if="soft_knowledge.knowledge_level_id"> {{soft_knowledge.knowledge.name}} </span>
							<span class="text-custom-danger" v-else> {{lang('empty')}} </span>
						</td>
						<td>
							<span v-if="soft_knowledge.graduated"> {{parseInt(soft_knowledge.graduated) ? lang('yes'):lang('no')}} </span>
							<span class="text-custom-danger" v-else> {{lang('empty')}} </span>


						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Education"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_education')}}</h2>

				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('resume_general_institution_name')}}</th>
						<th>{{lang('resume_general_education_level')}}</th>
						<th>{{lang('resume_general_education_direction')}}</th>
						<th>{{lang('start')}}</th>
						<th>{{lang('end')}}</th>
						<th>{{lang('resume_general_graduated')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="education in resume.education" data-valign="middle">
						<td>
							<span v-if="education.institution_name">
									{{education.institution_name}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
						<td>
							<span v-if="education.education_level">
									{{education.education_level.name}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
						<td>
							<span v-if="education.education_field">
									{{education.education_field.name}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
						<td>
							<span v-if="education.start_date ">
									{{formatDate(education.start_date)}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
						<td>
							<span v-if="education.end_date">
									{{formatDate(education.end_date)}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
						<td>
							<span v-if="education.completed">
									{{education.completed ? lang('yes'):lang('no')}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>

						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Competencies"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_core_competencies')}}</h2>
				<div class="detail-list-table">
					<div class="detail-list-row" v-for="competency in resume.competencies">
						<div class="detail-list-title detail-list-cell">{{competency.name}}</div><div class="detail-list-value detail-list-cell"><star-select :max="5" :value="competency.pivot.level" :readonly="true" /></div>
					</div>
				</div>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Driver licenses"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_driver_licenses')}}</h2>

				<ul class="detail-list">
					<li v-for="license in resume.driver_licenses">{{license.name}}</li>
				</ul>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Languages"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_languages')}}</h2>
				<table class="table table-condensed table-default table-hover">
					<thead>
					<tr>
						<th>{{lang('resume_general_language')}}</th>
						<th>{{lang('resume_general_language_speaking_level')}}</th>
						<th>{{lang('resume_general_language_writing_level')}}</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="language in resume.languages">
						<td>
							<span v-if="language.name">
								{{language.name}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>
						</td>
						<td>
							<span v-if="getLangLevel(language.pivot.level_speaking)">
								{{getLangLevel(language.pivot.level_speaking)}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>
						</td>
						<td>
							<span v-if="getLangLevel(language.pivot.level_writing)">
								{{getLangLevel(language.pivot.level_writing)}}
							</span>
							<span v-else class="text-custom-danger">
								{{lang('empty')}}
							</span>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Hobbies & Interests"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_hobbies')}}</h2>
				<p>
					{{resume.hobbies}}
				</p>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Characteristics"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_skills')}}</h2>
				<p>
					{{resume.characteristics}}
				</p>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Current situation"> -->

			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_current_situation')}}</h2>

				<ul class="detail-list">
					<li>
						{{lang('resume_general_employer')}}
						<span v-if="resume.current_employer">
							<strong>{{resume.current_employer}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>
						{{lang('resume_general_job_title')}}:
						<span v-if="resume.current_job">
							<strong>{{resume.current_job.title}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>
						{{lang('resume_general_job_sector')}}:
						<span v-if="resume.current_job_sector">
							<strong>{{resume.current_job_sector.title}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>
						{{lang('resume_general_career_level')}}
						<span v-if="resume.current_career_level">
							<strong>{{resume.current_career_level.name}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>
						{{lang('resume_general_availability')}}
						<span v-if="resume.available_from">
							<strong>{{resume.available_from.name}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>
						{{lang('resume_general_employment_types')}}
						<span v-if="job_data.current_employment_types">
							<strong>{{job_data.current_employment_types}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

				</ul>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Looking for job"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_looking_for_job')}}</h2>

				<ul class="detail-list">
					<li>
						{{lang('resume_general_situation')}}
						<span v-if="resume.looking_for_job">
							<strong>{{resume.looking_for_job ? "Job seeker" : "Not looking for a job"}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>
					</li>

					<li>

						{{lang('resume_general_job_title')}}:
						<span v-if="job_data.job_titles">
							<strong>{{job_data.job_titles}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>

						{{lang('resume_general_job_sector')}}:

						<span v-if="job_data.job_sectors">
							<strong>{{job_data.job_sectors}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>

						{{lang('resume_general_employment_types')}}

						<span v-if="job_data.employment_types">
							<strong>{{job_data.employment_types}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>

						{{lang('resume_general_job_hours')}}

						<span v-if="job_data.availability">
							<strong>{{job_data.availability}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>

						{{lang('resume_general_career_level')}}

						<span v-if="resume.career_level">
							<strong>{{resume.career_level.name}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>

						{{lang('resume_general_job_salary')}}

						<span v-if="resume.job_salary">
							<strong>{{resume.job_salary.name}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>


					</li>
					<li>
						{{lang('resume_general_work_experience')}}:

						<span v-if="resume.work_experience">
							<strong>{{resume.work_experience}}</strong>
						</span>
						<span v-else class="text-custom-danger">
							{{lang('empty')}}
						</span>

					</li>
				</ul>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Working Areas"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('resume_general_job_location')}}</h2>
				<div>
					<div id="map" style="height: 400px"></div>
				</div>
			</div>
			<!-- </editor-fold> -->

			<!-- <editor-fold desc="Documents"> -->
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('documents')}}</h2>
				<div>

					<div class="doc-list">
						<div class="doc" v-for="(doc,index) in resume.documents" :class="[doc.type]" :key="doc.id" >
							<div class="icon" @click="openDoc(doc)"></div>
							<div class="name" @click="openDoc(doc)">{{doc.name}}</div>
						</div>
					</div>
				</div>
			</div>
			<!-- </editor-fold> -->

			<div class="row no-padd">
				<div class="detail pannel-footer">
					<div class="col-md-9 col-sm-9">

					</div>
					<div class="col-md-3 col-sm-3">
						<div class="detail-pannel-footer-btn pull-right">
							<router-link :to="'/resume-edit'" class="footer-btn blu-btn" title="">{{lang('edit')}}</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
</template>
<script>
import {mapState} from 'vuex';
export default {
	name: 'Resume',
	data() {
		return {
			map: null,
			circleList: [],
			mapBounds: null,
			desc_max_length: 120
		};
	},
	watch: {
		resume() {
			this.initMapStuff()
		},
	},
	mounted() {
		this.initMap();
		this.initMapStuff();
	},
	methods: {
		calculateAge(birthday) { // birthday is a date
			var ageDifMs = Date.now() - new Date(birthday);
			var ageDate = new Date(ageDifMs); // miliseconds from epoch
			return Math.abs(ageDate.getUTCFullYear() - 1970);
		},
		openDoc(doc) {
			window.open("/storage/docs/"+doc.url, "_blank").focus();
		},
		initMap() {
			this.map = new google.maps.Map($(this.$el).find("#map").get(0), {
				center: {lat: -34.397, lng: 150.644},
				zoom: 8
			});
		},
		videoReady() {
			this.$nextTick().then(() => {
				videojs(this.$el.querySelector(".video-player"));
			});
		},
		initMapStuff() {

			if(!(this.map && this.resume.working_places)) {
				return;
			}

			for(let i = 0; i < this.circleList.length; i++) {
				this.circleList[i].setMap(null);
			}

			this.circleList.length = 0;

			this.mapBounds = new google.maps.LatLngBounds();
			for(let i = 0; i<this.resume.working_places.length; i++) {
				if (this.resume.working_places[i].name !== "" ) {
					let place = this.resume.working_places[i];
					if (!(place.radius && place.lat && place.lng)) return;


					let circle = new google.maps.Circle({
						center: {lat: place.lat, lng: place.lng},
						clickable: false,
						fillColor: '#004de8',
						fillOpacity: 0.27,
						map: this.map,
						radius: place.radius * 1000,
						strokeColor: '#004de8',
						strokeOpacity: 0.62,
						strokeWeight: 1,
					});

					this.circleList.push(circle);

					this.mapBounds.union(circle.getBounds());
				}else{
					// console.log("logging 1");
				}

			}



			this.map.fitBounds(this.mapBounds);
		},
		formatText(about) {
			return about ? about.replace(/\n/ig, "<br>") : "";
		},
		getLangLevel(level) {
			return this.languageLevels[level];
		},
		emp_desc(emp) {
			if(!emp._show_full_desc) {
				Vue.set(emp, '_show_full_desc', false);
			}

			if(emp._show_full_desc || this.desc_max_length >= emp.job_description.length) {
				return emp.job_description;
			}

			return emp.job_description.substring(0,this.desc_max_length)+"...";
		},
		toggleEmpDesc(emp) {
			emp._show_full_desc = !emp._show_full_desc;
		},
		differenceInTime(date1, date2=new Date()){
			var diffInDays = this.dayDifference(new Date(date1), new Date(date2));

			if(diffInDays / 31 > 12){
				return "Up to " +Math.ceil((diffInDays/31/12)) + " Years "
			}

			return "Up to " +Math.ceil((diffInDays / 31)) + " Month "

		},

		dayDifference(date1, date2) {
			var MILLISECONDS_PER_DAY = 1000 * 60 * 60 * 24;
			var timeDiff = Math.abs(date2.getTime() - date1.getTime());
			var diffDays = Math.ceil(timeDiff / MILLISECONDS_PER_DAY);
			return diffDays;
		}
	},
	computed: {
		...mapState(['resume','profile']),
		...mapState({
			loading_resume: state =>{
				return state.loadings.resume
			}
		}),
		age() {
			// return moment().diff(moment(this.profile.birthday, "YYYY-DD-MM"), "years");
			return this.calculateAge(this.profile.birthday);
		},
		last_education() {
			if(this.resume) {
				let sortedEducation = _(this.resume.education).sortBy('end_date').reverse().value();
				return sortedEducation[0];
			}
			return {};
		},
		userLocation() {
			if(this.profile && this.profile.city && this.profile.city.country) {
				return this.profile.city.title+", "+this.profile.city.country.title;
			}
			return "";
		},
		videoUrl() {
			if(this.resume && this.resume.video_url) {
				this.videoReady();
				return "/storage/videos/"+this.resume.video_url;
			}
			return false;
		},
		languageLevels() {
			return {
				1: "Bad",
				2: "Normal",
				3: "Good",
				4: "Excellent"
			};
		},
		job_data() {
			if(!this.resume) return {};
			let job_titles = _(this.resume.job_titles).map(v => v.title).join(", ");
			let job_sectors = _(this.resume.job_sectors).map(v => v.title).join(", ");
			let employment_types = _(this.resume.employment_types).map(v => v.name).join(", ");
			let current_employment_types = _(this.resume.current_employment_types).map(v => v.name).join(", ");
			let availability = _(this.resume.job_hours).map(v => v.name).join(", ");

			return {
				job_titles, job_sectors, employment_types, current_employment_types, availability
			}
		}
	}

}
</script>