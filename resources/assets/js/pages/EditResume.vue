<template>
<div>

	<spinner v-if="loading" :spinner-style="{'vertical-align': 'top', 'margin-top': '50vh'}" />
	<!-- Header Title Start -->
	<section class="inner-header-title blank">
		<div class="container">
			<h1>{{lang('applicant_dashboard_my_resume')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Header Title End -->

	<form @submit.prevent="submit">
	<!-- General Detail Start -->
	<div class="section detail-desc">
		<div class="container white-shadow">
			<div class="row">
				<br>
			</div>
			<div class="row bottom-mrg">
				<div id="video" class="tab-pane fade in active text-center">
					<dropzone style="width: 70%; position: relative;" ref="videoFile" :options="{acceptedFiles: 'video/*', maxFiles: 1}">{{lang('edit_resume_form_video_text')}}</dropzone>
				</div>
			</div>
		</div>
		<div class="row bottom-mrg extra-mrg"><div class="col-md-12"><button class="btn btn-success btn-primary small-btn">{{lang('edit_resume_form_submit_resume')}}</button></div></div>
	</div>
	<!-- General Detail End -->
		<section class="full-detail">
			<div class="container">
				<div class="row bottom-mrg extra-mrg">
					<div>
						<h2 class="detail-title">{{lang('resume_general_about_me')}}</h2>
						<div class="extra-field-box">
							<textarea class="form-control" style="min-height: 120px" v-model="mdl.about" :placeholder="lang('edit_resume_about_placeholder')"></textarea>
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- Working Experience -->

	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('edit_resume_employment_history')}}</h2>
					<div class="extra-field-box">
						<div class="multi-box">
							<div class="dublicat-box" v-for="(employment_item,index) in mdl.employment_history" :key="index">
								<div class="col-md-6 col-sm-12">
									<div class="input-group">
										<a href="#" class="input-group-addon" @click.prevent="removeField('employment_history',index)">X</a>
										<input type="text" class="form-control" v-model="mdl.employment_history[index].title" :placeholder="lang('resume_general_company_name')">
									</div>
								</div>


								<div class="col-md-3 col-sm-12">
									<div class="input-group">
										<date-selector :placeholder="lang('edit_resume_employment_history_start_day')" v-model="mdl.employment_history[index].start_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="input-group">
										<date-selector :placeholder="lang('edit_resume_employment_history_end_day')" v-model="mdl.employment_history[index].end_date" class="form-control" />
									</div>
								</div>

								<div class="col-md-4 col-sm-12">
									<div class="input-group">
										<select2 :list="resume_data.job_titles" display-field="title" :id-model="true" :placeholder="lang('edit_resume_employment_history_job_title')" v-model="mdl.employment_history[index].job_title_id" />
									</div>
								</div>

								<div class="col-md-4 col-sm-12">
									<div class="input-group">
										<select2 :list="resume_data.job_sectors" display-field="title" :id-model="true" :placeholder="lang('edit_resume_employment_history_job_sector')" v-model="mdl.employment_history[index].job_sector_id" />
									</div>
								</div>

								<div class="col-md-4 col-sm-12">
									<div class="input-group">
										<input type="text" v-model="mdl.employment_history[index].job_location" class="form-control" :placeholder="lang('edit_resume_employment_history_job_location')">
									</div>
								</div>

								<div class="col-md-12 col-sm-12">
									<div class="input-group">
										<textarea class="form-control" :placeholder="lang('edit_resume_employment_history_job_description')" rows="4" v-model="mdl.employment_history[index].job_description"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<button type="button" class="add-field" @click.prevent="addEmploymentHistoryField">{{lang('Add Field')}}</button>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_software_knowledge')}}</h2>
					<div class="extra-field-box">
						<div class="multi-box">
							<div class="duplicat-box" v-for="(soft,index) in mdl.software_knowledge" style="margin-bottom: 20px">
								<div class="col-md-5 col-sm-12">
									<div class="input-group">
										<a href="#" class="input-group-addon" @click.prevent="removeField('software_knowledge',index)">X</a>
										<div class="input-wrapper">
											<select2 ref="select" :placeholder="lang('edit_resume_software_knowledge_select_placeholder')" class="no-mar" :list="resume_data.software" :id-model="true" display-field="name" v-model="mdl.software_knowledge[index].software_id" />
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-12">
									<select2 :list="resume_data.knowledge_levels" display-field="name" :id-model="true" :placeholder="lang('edit_resume_software_knowledge_level')" v-model="mdl.software_knowledge[index].knowledge_level_id" />
								</div>

								<div class="col-md-3 col-sm-12">
									<select2 type="text" :list="[{title: lang('edit_resume_software_knowledge_select_graduated'), id: '1'},{title: lang('edit_resume_software_knowledge_select_not_graduated'),id: '0'}]" v-model="mdl.software_knowledge[index].graduated" :id-model="true" :placeholder="lang('edit_resume_software_knowledge_graduated')" />
								</div>
								<div class="clearfix"></div>
							</div>

						</div>
						<div class="clearfix"></div>
						<button type="button" class="add-field" @click.prevent="addField('software_knowledge')">{{lang('add_field')}}</button>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('edit_resume_add_education_title')}}</h2>
					<div class="extra-field-box">
						<div class="multi-box">
							<div class="dublicat-box" v-for="(education, index) in mdl.education" :key="index">
								<div class="col-md-8 col-sm-12">
									<div class="input-group">
										<a href="#" class="input-group-addon" @click.prevent="removeField('education',index)">X</a>
										<input type="text" class="form-control" :placeholder="lang('edit_resume_add_education_institution')" v-model="mdl.education[index].institution_name">
									</div>
								</div>
								<div class="col-md-2 col-sm-12">
									<div class="input-group">
										<date-selector :placeholder="lang('start_date')" v-model="mdl.education[index].start_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-2 col-sm-12">
									<div class="input-group">
										<date-selector :placeholder="lang('end_date')" v-model="mdl.education[index].end_date" class="form-control" />
									</div>
								</div>

								<div class="col-md-4">
									<select2 type="text" :list="resume_data.education_levels" display-field="name" v-model="mdl.education[index].education_level_id" :id-model="true" :placeholder="lang('resume_general_education_level')" />
								</div>

								<div class="col-md-4 col-sm-12">
									<div class="input-group">
										<select2 type="text" :list="resume_data.education_fields" display-field="name" v-model="mdl.education[index].education_field_id" :id-model="true" :placeholder="lang('edit_resume_add_education_direction')" />
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="input-group">
										<select2 type="text" :list="[{title: lang('edit_resume_software_knowledge_select_graduated'), id: 1},{title: lang('edit_resume_software_knowledge_select_not_graduated'),id: 0}]" v-model="mdl.education[index].completed" :id-model="true" :placeholder="lang('edit_resume_software_knowledge_graduated')" />
									</div>
								</div>
							</div>
						</div>

						<div class="clearfix"></div>
						<button type="button" class="add-field" @click.prevent="addEducationField">{{lang('add_field')}}</button>
					</div>
				</div>
			</div>
		</div>
	</section>



	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_core_competencies')}}</h2>
					<div class="extra-field-box">
						<div class="multi-box">
							<level-selector v-for="(competency,index) in mdl.competencies" :list="resume_data.competencies" level-field="level" v-model="mdl.competencies[index]" :key="index" @delete="removeField('competencies',index)" />

						</div>
						<div class="clearfix"></div>
						<button type="button" class="add-field" @click.prevent="addField('competencies')">{{lang('resume_general_core_competencies')}}</button>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_driver_licenses')}}</h2>


					<div class="extra-field-box">
						<div class="multi-box">
							<div class="dublicat-box">
								<div class="col-md-12 col-sm-12">
									<select2 :list="resume_data.driver_licenses" display-field="name" id-field="id" :placeholder="lang('edit_resume_driver_license_select')" v-model="mdl.driver_licenses" :options="{multiple: true}" />
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

					<h2 class="detail-title">{{lang('resume_general_languages')}}</h2>


					<div class="extra-field-box">
						<div class="multi-box">

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
	</section>



	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_hobbies')}}</h2>

					<div class="col-md-12 col-sm-12">
						<textarea class="form-control" :placeholder="lang('edit_resume_hobbies')" style="min-height: 150px;" v-model="mdl.hobbies"></textarea>
					</div>


				</div>
			</div>
		</div>
	</section>

	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_skills')}}</h2>

					<div class="col-md-12 col-sm-12">
						<textarea class="form-control" :placeholder="lang('edit_resume_skills_placeholder')" style="min-height: 150px;" v-model="mdl.characteristics"></textarea>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<div>
					<h2 class="detail-title">{{lang('resume_general_current_situation')}}</h2>

					<div class="col-md-12 col-sm-12">
						<input type="text" class="form-control" :placeholder="lang('edit_resume_current_situation_employer')" v-model="mdl.current_employer" />
					</div>

					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_titles" display-field="title" :id-model="true" :placeholder="lang('edit_resume_current_situation_job_title')" v-model="mdl.current_job_title_id" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_sectors" display-field="title" :id-model="true" :placeholder="lang('edit_resume_current_situation_job_sector')" v-model="mdl.current_sector_id" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.career_levels" display-field="name" :id-model="true" :placeholder="lang('edit_resume_current_situation_career_level')" v-model="mdl.current_career_level_id" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.available_from_times" display-field="name" :id-model="true" :placeholder="lang('resume_general_availability')" v-model="mdl.available_from_id" />
					</div>

					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.employment_types" display-field="name" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('edit_resume_current_situation_employment_types')" v-model="mdl.current_employment_types" />
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{lang('edit_resume_looking_for_job_title')}}</h2>

				<div class="col-md-12 col-sm-12">
					<label>{{lang('edit_resume_looking_for_job_question')}}</label>
					&emsp;&emsp;&emsp;
					<label><input type="radio" v-model="mdl.looking_for_job" :value="1"> {{ lang('yes') }}</label>&emsp;
					<label><input type="radio" v-model="mdl.looking_for_job" :value="0"> {{ lang('no') }}</label>
					<br>
				</div>

				<div v-show="mdl.looking_for_job">
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_titles" display-field="title" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('edit_resume_looking_for_job_title_placeholder')" v-model="mdl.job_titles" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_sectors" display-field="title" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('edit_resume_looking_for_job_sectors_placeholder')" v-model="mdl.job_sectors" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.employment_types" display-field="name" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('edit_resume_looking_for_job_types_placeholder')" v-model="mdl.employment_types" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_hours" display-field="name" :options="{multiple: true, width: '100%', maximumSelectionLength: 3}" :placeholder="lang('edit_resume_looking_for_job_hours_placeholder')" v-model="mdl.job_hours" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.job_salaries" display-field="name" :id-model="true" :options="{width: '100%'}" :placeholder="lang('edit_resume_looking_for_job_salary_placeholder')" v-model="mdl.job_salary_id" />
					</div>
					<div class="col-md-12 col-sm-12">
						<input type="text" class="form-control" :placeholder="lang('edit_resume_looking_for_job_experience_placeholder')" v-model.number="mdl.work_experience" />
					</div>
					<div class="col-md-12 col-sm-12">
						<select2 :list="resume_data.career_levels" display-field="name" :id-model="true" :options="{width: '100%'}" :placeholder="lang('edit_resume_looking_for_job_career_level_placeholder')" v-model="mdl.career_level_id" />
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
					<h2 class="detail-title">{{ lang('edit_resume_job_location_title') }}</h2>

				<div class="multi-box">
					<place-selector v-for="(working_place, index) in mdl.working_places" :checkForErrors="checkForErrors" :value="mdl.working_places[index]" @selected="setWorkingPlace(index, $event)" :key="index" @delete="removeField('working_places', index)" />
				</div>

				<div class="clearfix"></div>
				<button type="button" class="btn add-field" @click.prevent="addField('working_places')">{{lang('add_field')}}</button>
				<button type="button" class="btn remove-field" @click.prevent="showMap">{{lang('edit_resume_view_map')}}</button>
			</div>
		</div>

	</section>
	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<h2 class="detail-title">{{ lang('edit_resume_my_documents') }}</h2>
				<div class="doc-list">
					<div class="doc" v-for="(doc,index) in mdl.documents" :class="[doc.type, doc.loading&&'uploading']" :key="doc.id" >
						<div class="icon" @click="openDoc(doc)"></div>
						<div class="name" @click="openDoc(doc)">{{doc.name}}</div>
						<span class="delete" @click.prevent="deleteDoc(doc)">&times;</span>
					</div>
					<div class="doc uploading" v-for="(doc,index) in upload_docs" :key="doc.id" >
						<div class="icon"></div>
						<div class="name">{{doc.name}}</div>
					</div>

					<div class="doc add" @click.prevent="selectDoc" data-toggle="modal">
						<div class="icon"></div>
						<div class="name">{{lang('edit_resume_add_document')}}</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row bottom-mrg extra-mrg"><div class="col-md-12"><button class="btn btn-success btn-primary small-btn">{{lang('edit_resume_form_submit_resume')}}</button></div></div>
	</section>

	</form>

	<div id="mapModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{lang('edit_resume_map')}}</h5>
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
	<div id="addDocModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{lang('edit_resume_document_upload')}}</h5>
				</div>
				<div class="modal-body">
					<br>
					<div class="row">
						<div class="col col-md-12">
							<input type="text" class="form-control" v-model="upload_doc_name" :placeholder="lang('edit_resume_document_name_placeholder')">
						</div>
						<div class="col col-md-12">
							<dropzone ref="docUpload">{{lang('edit_resume_document_drag_drop')}}</dropzone>
						</div>
					</div>
					<br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" @click.prevent="uploadDocument">{{lang('edit_resume_add_document')}}</button>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
import {mapState} from 'vuex';
export default {
	data() {
		return {
			checkForErrors:true,
			mdl: {

			},
			delete_doc_ids: [],
			resume_data: {},
			loadings: {
				loading_resume_data: true,
				saving: false
			},
			map: null,
			circleList: [],
			mapBounds: null,
			upload_doc_name: "",
			upload_docs: [],
		}
	},
	created() {
		if(!this.loading_resume) {
			this.setResume(this.$store.state.resume);
		}
		this.$store.dispatch('fetchResumeData')
			.then(res => {
				if(res.data.success) {
					this.loadings.loading_resume_data = false;
					this.resume_data = res.data.result;
				}
			});
	},
	watch: {
		resume(resume) {
			this.setResume(resume);

			var that = this;

			this.$refs.videoFile.dropzone.on("addedfile", function(){
				that.submit()
			});

		}
	},
	computed: {
		...mapState(['profile','resume']),
		...mapState({
			// loading: state=>state.loadings.resume,
			// loadings: {
				loading_resume: state =>{
					return state.loadings.resume
				}
			// }
		}),
		loading() {
			return (this.loading_resume || this.loadings.loading_resume_data || this.loadings.saving);
		},
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
	},
	methods: {
		submit() {
			let data = this.processData();
			this.loadings.saving = true;
			this.$store.dispatch("saveResume", data).then(res => {
				console.log(res.data);
				if(res.data.success) {

					this.upload_docs.length = 0;

					this.$store.dispatch("fetchResume");
					this.$root.$alert.open("Success", "Resume saved successfully",function(){
						window.location.href = '/resume';
					});
				}
			})
			.finally(() => {
				this.loadings.saving = false;
			});
		},
		processData() {
			let data = _(this.mdl).pick(['about','looking_for_job','available_from_id','current_career_level_id','career_level_id','characteristics','current_employer','current_job_title_id','current_sector_id','hobbies','job_salary_id','work_experience'])
			.assign({
				competencies: _(this.mdl.competencies).filter(c => !!c.id).map(c => {
					return {
						id: c.id,
						pivot: c.pivot
					}
				}).value(),
				driver_licenses: _(this.mdl.driver_licenses).filter(c=>!!c.id).map(c => c.id).value(),
				// languages: _(this.mdl.languages).filter(c=>!!c.id).map(c=> {
				languages: _(this.mdl.languages).map(c=> {
					return {
						id: c.id,
						pivot: c.pivot
					}
				}).value(),

				employment_types: _(this.mdl.employment_types).map(c=>c.id).value(), // +
				current_employment_types: _(this.mdl.current_employment_types).map(c=>c.id).value(),
				job_hours: _(this.mdl.job_hours).map(c=>c.id).value(), // +
				job_sectors: _(this.mdl.job_sectors).map(c=>c.id).value(), // +
				job_titles: _(this.mdl.job_titles).map(c=>c.id).value(), // +

				// software_knowledge: _(this.mdl.software_knowledge).filter(c=>c.software_id&&c.knowledge_level_id&&c.graduated).map(c=> {
				software_knowledge: _(this.mdl.software_knowledge).map(c=> {
					return c;
				}).value(),
				// working_places: _(this.mdl.working_places).filter(c=>(c.lat&&c.lng&&c.radius&&c.name)).map(c => {
				working_places: _(this.mdl.working_places).map(c => {
					return {
						lat: c.lat,
						lng: c.lng,
						name: c.name,
						radius: c.radius
					}
				}).value(),
				// employment_history: _(this.mdl.employment_history).filter(c=>(c.title&&c.start_date&&c.end_date&&c.job_sector_id&&c.job_title_id&&c.job_location)).value(),
				employment_history: _(this.mdl.employment_history).value(),
				// education: _(this.mdl.education).filter(c=>c.institution_name&&c.education_field_id&&c.start_date&&c.end_date&&c.education_level_id).value(),
				education: _(this.mdl.education).value(),
				delete_doc_ids: this.delete_doc_ids
			}).value();

			let formData = new FormData();

			for(let field in data) {
				if(data.hasOwnProperty(field)) {
					if(data[field]==null) continue;
					let value = typeof data[field] === 'object'? JSON.stringify(data[field]) : data[field];
					formData.append(field, value);
				}
			}

			if(this.$refs.videoFile.dropzone.files.length) {
				formData.append("video", this.$refs.videoFile.dropzone.files[0]);
			}

			return formData;

			// return data.value();
		},
		selectDoc() {
			let fileInput = document.createElement("input");
			fileInput.type = "file";
			fileInput.addEventListener("change", e => {
				if(e.currentTarget.files[0]) {
					let file = e.currentTarget.files[0];
					this.uploadDoc(file);
				}
			});
			fileInput.click();
		},
		uploadDoc(file) {
			let type = file.name.substring(file.name.lastIndexOf(".")+1).toLowerCase();
			let doc = {
				type,
				name: file.name
			};
			this.upload_docs.push(doc);

			this.$store.dispatch("uploadDoc", file)
				.then(res => {
					this.upload_docs.splice(this.upload_docs.indexOf(doc),1);
					this.mdl.documents.push(res.data.result);
				});
		},
		uploadDocument() {
			if(this.$refs.docUpload.dropzone.files.length > 0 && this.upload_doc_name.trim() !== "") {
				let file_name = this.$refs.docUpload.dropzone.files[0].name;
				let type = file_name.substring(file_name.lastIndexOf(".")+1).toLowerCase();
				this.upload_docs.push({
					file: this.$refs.docUpload.dropzone.files[0],
					name: this.upload_doc_name.trim(),
					type: 'pdf'
				});
				$("#addDocModal").modal("hide");
				this.$refs.docUpload.dropzone.removeAllFiles();
				this.upload_doc_name = "";
			}
		},
		openDoc(doc) {
			window.open("/storage/docs/"+doc.url, "_blank").focus();
		},
		deleteDoc(doc) {
			this.$root.$confirm.open({
				title: "Confirm",
				text: `Are you sure you want to delete <strong><em>${doc.name}</em></strong> ?`
			}, val => {
				if(!val) return;

				Vue.set(doc, 'loading', true);
				this.$store.dispatch("deleteDoc", doc.id)
					.then(res => {
						if(res.data.success) {
							this.mdl.documents.splice(this.mdl.documents.indexOf(doc),1);
						} else {
							doc.loading = false;
							this.$root.$alert.open("Error", res.data.error);
						}
					});
			});
		},
		setResume(resume) {
			this.mdl = _.cloneDeep(resume);
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
		addEmploymentHistoryField() {
			this.mdl.employment_history.push({
				title: '',
				job_sector_id: '',
				start_date: '',
				end_date: ''
			});
		},
		addEducationField() {
			this.mdl.education.push({
				institution_name: '',
				education_field_id: '',
				start_date: '',
				end_date: ''
			});
		},
		showMap() {
			if(this.map != null) {
				this.initMapStuff();
				$(this.$el).find("#mapModal").modal("show");
			}
		},
		initMapStuff() {

			for(let i = 0; i < this.circleList.length; i++) {
				this.circleList[i].setMap(null);
			}

			this.circleList.length = 0;

			this.mapBounds = new google.maps.LatLngBounds();
			for(let i = 0; i<this.mdl.working_places.length; i++) {
				let place = this.mdl.working_places[i];
				if(!(place.radius && place.lat && place.lng)) return;



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

			}
		},
		removeField(fieldName, index) {
			if(this.mdl[fieldName].length>1 && this.mdl[fieldName].length > index)
				this.mdl[fieldName].splice(index,1);
		},
		setWorkingPlace(index, place) {
			this.mdl.working_places[index]=place;
		},
		initMap() {
			this.map = new google.maps.Map($(this.$el).find("#map").get(0), {
				center: {lat: -34.397, lng: 150.644},
				zoom: 8
			});

			$(this.$el).find("#mapModal").on("shown.bs.modal", e => {
				this.map.fitBounds(this.mapBounds);
			});
		}
	},
	mounted() {
		this.initMap();

	}
}
</script>

<style scoped>


	@media only screen  and (min-width : 1024px) {

		section:not(.blog-text) {
			padding: 10px 0 10px 0;
		}

	}

</style>