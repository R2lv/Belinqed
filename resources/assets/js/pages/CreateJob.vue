<template>
<div style="position: relative;">

	<spinner v-if="loading" />
	<!-- Header Title Start -->
	<section class="inner-header-title blank">
		<div class="container">
			<h1>{{lang('create_job_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Header Title End -->

	<form @submit.prevent="save">
	<!-- General Detail Start -->
	<div class="detail-desc section">
		<div class="container white-shadow">

			<div class="row">
				<br>
			</div>

			<div class="row bottom-mrg">
				<div class="add-feild">
					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<select2 :placeholder="lang('create_job_title_placeholder')" :list="resume_data.job_titles" :id-model="true" v-model="mdl.job_title_id" />
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<select2 :placeholder="lang('create_job_sector_placeholder')" :list="resume_data.job_sectors" :id-model="true" v-model="mdl.job_sector_id" />
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<select2 :placeholder="lang('create_job_career_level_placeholder')" :list="resume_data.career_levels" :id-model="true" v-model="mdl.job_career_level_id" display-field="name"  />
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<select2 :placeholder="lang('create_job_hours_placeholder')" :list="resume_data.job_hours" :id-model="true" v-model="mdl.job_hour_id" display-field="name" />
						</div>
					</div>


					<div class="full-detail">

						<div class="col-md-12 col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-globe"></i></span>
								<input type="text" v-model="mdl.job_location" class="form-control no-mar" id="job-location" :placeholder="lang('create_job_location_placeholder')">
								<a href="#" class="input-group-addon" @click.prevent="showMap">{{lang('create_job_choose_on_map')}}</a>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-bar-chart"></i></span>
								<input type="text" v-model.number="mdl.minimum_experience" class="form-control no-mar" :placeholder="lang('create_job_minimum_years_experience_placeholder')">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money"></i></span>
								<select2 :placeholder="lang('create_job_salary_placeholder')" :list="resume_data.job_salaries" class="no-mar" :id-model="true" v-model="mdl.job_salary_id" display-field="name" />
							</div>
						</div>


						<div class="col-md-12 col-sm-12">
							<select2 :list="resume_data.available_from_times" display-field="name" :id-model="true" :placeholder="lang('create_job_available_from_placeholder')" v-model="mdl.available_from_id" />
						</div>

						<div class="col-md-12 col-sm-12">
							<select2 :list="resume_data.employment_types" display-field="name" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('create_job_employment_types_placeholder')" v-model="mdl.employment_types" />
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<textarea class="form-control" :placeholder="lang('create_job_description_placeholder')" v-model="mdl.job_description"></textarea>
					</div>

				</div>

			</div>

		</div>
	</div>
	<!-- General Detail End -->

	<!-- Basic Full Detail Form Start -->
	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('create_job_education_title')}}</h2>


				<div class="col-md-6 col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-pencil"></i></span>
						<select2 :placeholder="lang('create_job_education_direction_placeholder')" :list="resume_data.education_fields" class="no-mar" :id-model="true" v-model="mdl.education_field_id" display-field="name" />
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag"></i></span>
						<select2 :placeholder="lang('create_job_education_education_level')" :list="resume_data.education_levels" class="no-mar" :id-model="true" v-model="mdl.education_level_id" display-field="name" />
					</div>
				</div>

				<div class="col-md-4 col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag"></i></span>
						<date-selector :placeholder="lang('create_job_education_start_date_placeholder')" v-model="mdl.education_start_date" class="form-control" />
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag"></i></span>
						<date-selector :placeholder="lang('create_job_education_end_date_placeholder')" v-model="mdl.education_end_date" class="form-control" />
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag"></i></span>
						<select2 type="text" class="no-mar" :list="[{title: lang('edit_resume_software_knowledge_select_graduated'), id: 1},{title: lang('edit_resume_software_knowledge_select_not_graduated'),id: 0}]" v-model="mdl.education_graduated" :id-model="true" :placeholder="lang('create_job_education_graduated_or_not_placeholder')" />
					</div>
				</div>

			</div>


			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('create_job_Competencies_title')}}</h2>

				<div class="extra-field-box">
					<div class="multi-box">
						<div class="dublicat-box">
							<div class="col-md-12 col-sm-12">
								<level-selector v-for="(competency,index) in mdl.competencies" :placeholder="lang('create_job_Competencies_placeholder')" :list="resume_data.competencies" level-field="level" v-model="mdl.competencies[index]" :key="index" @delete="removeField('competencies',index)" />
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<button type="button" class="add-field" @click.prevent="addField('competencies')">{{lang('add_field')}}</button>
				</div>
			</div>

			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('create_job_software_knowledge_title')}}</h2>

				<div class="extra-field-box">
					<div class="multi-box">

						<div class="duplicat-box" v-for="(soft,index) in mdl.software_knowledge" style="margin-bottom: 20px">
							<div class="col-md-5 col-sm-12">
								<div class="input-group">
									<a href="#" class="input-group-addon" @click.prevent="removeField('software_knowledge',index)">X</a>
									<div class="input-wrapper">
										<select2 ref="select" :placeholder="lang('create_job_software_knowledge_placeholder')" class="no-mar" :list="resume_data.software" :id-model="true" display-field="name" v-model="mdl.software_knowledge[index].software_id" />
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<select2 :list="resume_data.knowledge_levels" display-field="name" :id-model="true" :placeholder="lang('create_job_software_knowledge_level_placeholder')" v-model="mdl.software_knowledge[index].knowledge_level_id" />
							</div>


							<div class="col-md-3 col-sm-12">
								<select2 type="text" :list="[{title: lang('edit_resume_software_knowledge_select_graduated'), id: 1},{title: lang('edit_resume_software_knowledge_select_not_graduated'),id: 0}]" v-model="mdl.software_knowledge[index].graduated" :id-model="true" :placeholder="lang('create_job_software_knowledge_graduated_or_not')" />
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<button type="button" class="add-field" @click.prevent="addField('software_knowledge')">{{lang('add_field')}}</button>
				</div>
			</div>


			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('create_job_languages_title')}}</h2>


				<div class="extra-field-box">
					<div class="multi-box">
						<div class="dublicat-box">
							<div class="col-md-12 col-sm-12">
								<double-level-selector v-for="(lg,index) in mdl.languages" :list="resume_data.languages" v-model="mdl.languages[index]" :key="index" @delete="removeField('languages',index)"
								                       level-field1="level_speaking" level-field2="level_writing"
													   :level1-placeholder='lang("resume_general_language_writing_level")' :level2-placeholder='lang("resume_general_language_speaking_level")' :placeholder="lang('create_job_languages_placeholder')"
								                       :levelList="languageLevels"/>
							</div>

							<div class="clearfix"></div>
							<button type="button" class="add-field" @click.prevent="addLanguageField">{{lang('add_field')}}</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('create_job_driving_license_title')}}</h2>


				<div class="extra-field-box">
					<div class="multi-box">
						<div class="dublicat-box">
							<div class="col-md-12 col-sm-12">
								<select2 :list="resume_data.driver_licenses" display-field="name" id-field="id" :placeholder="lang('create_job_driving_license_placeholder')" v-model="mdl.driver_licenses" :options="{multiple: true}" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row bottom-mrg extra-mrg">
				<div class="col-md-12 col-sm-12">
					<button class="btn btn-success btn-primary small-btn">{{lang('create_job_submit')}}</button>
				</div>
			</div>
		</div>

		<div id="mapModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{lang('map')}}</h5>
					</div>
					<div class="modal-body">
						<div id="map"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{{lang('close')}}</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	</form>

</div>
</template>

<script>
export default {
	data() {
		return {
			mdl: {
				languages: [],
				competencies: [],
				software_knowledge: []
			},
			resume_data: {},
			loading: true,
		}
	},
	created() {
		this.$store.dispatch('fetchResumeData')
			.then(res => {
				if(res.data.success) {
					// this.loadings.loading_resume_data = false;
					this.resume_data = res.data.result;
					this.loading = false;
				}
			});
	},
	mounted() {
		$(this.$el).find('#edu-end').dateDropper();
		$(this.$el).find('#edu-start').dateDropper();
		$(this.$el).find('#exp-end').dateDropper();
		$(this.$el).find('#exp-start').dateDropper();
		$(this.$el).find('#dob').dateDropper();
		$(this.$el).find('.datedropper').dateDropper();
		this.initMap();
	},
	methods: {

		save() {

			let data = _(this.mdl).pick('job_title_id','job_sector_id','job_location','job_location_lat','job_location_lng','minimum_experience','job_career_level_id',
			'job_description','job_hour_id','education_level_id','education_field_id','education_start_date','education_end_date','education_graduated','job_salary_id','company_id','available_from_id')
				.assign({
					competencies: _(this.mdl.competencies).filter(c => !!c.id).map(c => {
						return {
							id: c.id,
							pivot: c.pivot
						}
					}).value(),
					employment_types: _(this.mdl.employment_types).filter(c=>!!c.id).map(c=>c.id).value(),
					driver_licenses: _(this.mdl.driver_licenses).filter(c=>!!c.id).map(c => c.id).value(),
					languages: _(this.mdl.languages).filter(c=>!!c.id).map(c=> {
						return {
							id: c.id,
							pivot: c.pivot
						}
					}).value(),
					software_knowledge: _(this.mdl.software_knowledge).filter(c=>c.software_id&&c.knowledge_level_id&&c.graduated).map(c=> {
						return {

							software_id: c.software_id,
							knowledge_level_id: c.knowledge_level_id,
							graduated: c.graduated

						};
					}).value()
				})
				.value();


			this.loading = true;
			this.$store.dispatch('saveJob', data)
				.then(res => {
					if(res.data.success) {
						this.$root.$alert.open("Success", res.data.result, () => {
							this.$router.push('/company-details');
						});
					} else {
						this.$root.$alert.open("Fail", res.data.result);
					}
				}).finally(r => {
					this.loading = false;
			});
		},
		initMap() {
			this.map = new google.maps.Map($(this.$el).find("#map").get(0), {
				center: {lat: -34.397, lng: 150.644},
				zoom: 8
			});

			google.maps.event.addListener(this.map, "click", (e) => this.setMarker(e.latLng));

			let input = this.$el.querySelector("#job-location");
			let options = {
				types: ['geocode']
			};
			this.autocomplete = new google.maps.places.Autocomplete(input, options);
			this.autocomplete.addListener("place_changed", this.placeChanged);
		},
		placeChanged() {
			let place = this.autocomplete.getPlace();
			this.mdl.job_location = place.formatted_address;
			this.mdl.job_location_lat = place.geometry.location.lat();
			this.mdl.job_location_lng = place.geometry.location.lng();
			this.setMarker(place.geometry.location);
		},
		setMarker(latlng) {
			if(this.marker) this.marker.setMap(null);
			this.marker = new google.maps.Marker({
				position: latlng,
				map: this.map,
				title: 'Job Location'
			});
		},
		showMap() {
			if(this.map != null) {
				$(this.$el).find("#mapModal").modal("show");
				if(this.marker) {
					let bounds = new google.maps.LatLngBounds();
					bounds.extend(this.marker.getPosition());
					this.map.fitBounds(bounds);
					this.map.setZoom(12);
				}
			}
		},

		addField(fieldName) {
			this.mdl[fieldName].push({
				name: '',
				pivot: {
					knowledge_level: 0
				}
			})
		},
		addLanguageField() {
			this.mdl.languages.push({
				name: '',
				pivot: {
					level_speaking: 0,
					level_writing: 0
				}
			});
		},
		removeField(fieldName, index) {
			if(this.mdl[fieldName].length>1 && this.mdl[fieldName].length > index)
				this.mdl[fieldName].splice(index,1);
		},
	},
	computed: {
		languageLevels() {
			return [
				{
					id: 1,
					name: this.lang("resume_general_language_level_bad")
				},
				{
					id: 2,
					name: this.lang("resume_general_language_level_normal")
				},
				{
					id: 3,
					name: this.lang("resume_general_language_level_good")
				},
				{
					id: 4,
					name: this.lang("resume_general_language_level_excellent")
				}
			];
		}
	}
}
</script>