<template>
	<div id="company-profile" class="tab-pane fade">
		<spinner v-if="loading" />
		<div class="row no-mrg">
			<h3>{{lang('company_dashboard_edit_company_title')}}</h3>
			<form @submit.prevent="save" enctype="multipart/form-data" class="edit-pro">
				<div class="col-md-4 col-sm-6">
						<label>{{lang('company_dashboard_edit_company_company_name')}}</label>
					<input type="text" class="form-control" v-model="mdl.company_name" :placeholder="lang('company_dashboard_edit_company_company_name')">
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_email')}}</label>
					<input type="email" class="form-control" v-model="mdl.email" :placeholder="lang('company_dashboard_edit_company_email')">
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_phone_number')}}</label>
					<input type="text" class="form-control" v-model="mdl.phone_number" :placeholder="lang('company_dashboard_edit_company_phone_number')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label for="country">{{lang('company_dashboard_edit_company_country')}}</label>
					<select id="country" v-model="country" class="form-control">
						<option :value="{}">Select Country</option>
						<option v-for="c in countries" :value="c">{{c.title}}</option>
					</select>
				</div>

				<div class="col-md-4 col-sm-6">
					<label for="city">{{lang('company_dashboard_edit_company_city')}}</label>
					<select :class="{'error': errors.city_id}" id="city" v-model="mdl.city_id" class="form-control">
						<option value="">{{lang('company_dashboard_edit_company_select_city')}}</option>
						<option v-for="city in country.city" :value="city.id">{{city.title}}</option>
					</select>
					<div class="error-msg"> - {{$errorString(errors.city_id)}}</div>
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_address_line_1')}}</label>
					<input type="text" class="form-control" v-model="mdl.address_1" :placeholder="lang('company_dashboard_edit_company_address_line_1')">
				</div>
				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_address_line_2')}}</label>
					<input type="text" class="form-control" v-model="mdl.address_2" :placeholder="lang('company_dashboard_edit_company_address_line_2')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_facebook_url')}}</label>
					<input type="text" class="form-control" v-model="mdl.facebook_url" :placeholder="lang('company_dashboard_edit_company_facebook_url')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_linkedin_url')}}</label>
					<input type="text" class="form-control" v-model="mdl.linkedin_url" :placeholder="lang('company_dashboard_edit_company_linkedin_url')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_twitter_url')}}</label>
					<input type="text" class="form-control" v-model="mdl.twitter_url" :placeholder="lang('company_dashboard_edit_company_twitter_url')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_google_plus')}}</label>
					<input type="text" class="form-control" v-model="mdl.google_plus_url" :placeholder="lang('company_dashboard_edit_company_google_plus')">
				</div>

				<div class="col-md-4 col-sm-6">
					<label>{{lang('company_dashboard_edit_company_company_website')}}</label>
					<input type="text" class="form-control" v-model="mdl.company_website" :placeholder="lang('company_dashboard_edit_company_company_website')">
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_keywords')}}</label>
					<input type="text" class="form-control" v-model="mdl.keywords" placeholder="Company Keywords">
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_about_company')}}</label>
					<textarea class="form-control" v-model="mdl.about_company" :placeholder="lang('company_dashboard_edit_company_about_company')"></textarea>
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_profile_image')}}</label>
					<dropzone ref="profileImage" :options="{acceptedFiles: 'image/*', maxFiles: 1}">{{lang('company_dashboard_edit_company_drag_drop')}}</dropzone>
					<div class="clearfix"></div>
					<br>
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_intro_max')}}</label>
					<dropzone ref="introImages" :options="{acceptedFiles: 'image/*', maxFiles: 2}">{{lang('company_dashboard_edit_company_drag_click')}}</dropzone>
					<div class="clearfix"></div>
					<br>
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_offices_images')}}</label>
					<div class="office-images">
						<div class="office-image" v-for="(image,$index) in mdl.office_images" :key="$index" :class="{deleting: image.markedToDelete}" :style="{'background-image': `url(${image.image})`}">

							<div class="restore" @click="restoreImage($index,image)" v-if="image.markedToDelete && office_images_length < 8">&#10003;</div>
							<div class="remove" @click="deleteImage($index,image)" v-else>&#10005;</div>
						</div>
						<label class="office-image add" :class="{'disabled': office_images_length>7}"><input type="file" multiple max="8" accept="image/*" @change="addOfficeImage">+</label>
						<div class="clearfix"></div>
					</div>
					<br>
				</div>

				<div class="col-md-12">
					<label>{{lang('company_dashboard_edit_company_team')}}</label>
					<div class="team-members">
						<div class="team-member" :class="{'deleting': member.markedToDelete}" v-for="(member, $index) in mdl.members" :key="$index">
							<div class="image" style="background-size: cover" :style="{'background-image': `url(${member.image})`}"></div>
							<div class="info">
								<div class="name">{{member.name}}</div>
								<em class="position">{{member.position}}</em>
							</div>
							<div class="options">
								<a href="#" class="view-video text-info">{{lang('company_dashboard_edit_company_view_video')}}</a>&nbsp;&nbsp;
								<a href="#" class="delete text-danger" @click.prevent="deleteMember($index,member)">{{lang('company_dashboard_edit_company_remove')}}</a>
								<a href="#" class="restore text-success" @click.prevent="restoreMember($index,member)">{{ lang('company_dashboard_edit_company_restore') }}</a>
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<a href="#" @click.prevent="$refs.addMember.show" class="btn btn-success pull-right">{{lang('company_dashboard_edit_company_add_team_member')}}</a>
					<div class="clearfix"></div>
				</div>

				<add-team-member @add="addTeamMember" ref="addMember" />

				<div class="col-sm-12">
					<button class="update-btn">{{lang('company_dashboard_edit_user_profile_update_now')}}</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import {mapState} from 'vuex';
import api from '../api';
import AddTeamMember from './AddTeamMemberModal';
export default {
	name: "edit-profile",
	data() {
		return {
			mdl: {
				members: [],
				office_images: []
			},
			errors: {},
			loading: true,
			country:{}
		}
	},
	mounted() {
		if(!this.$store.state.loadings.company)
			this.setCompany(this.$store.state.company);
	},
	watch: {
		company(company) {
			this.setCompany(company);
		}
	},
	computed: {
		...mapState(['company','countries','loadings']),
		office_images_length() {
			return _(this.mdl.office_images).countBy(image => !image.markedToDelete).size();
		}
	},
	methods: {
		addOfficeImage(e) {
			_(e.currentTarget.files).forEach(file => {
				this.readFile(file, (image) => {
					if(this.office_images_length < 8) {
						this.mdl.office_images.push({
							markedToDelete: false,
							image,
							image_file: file
						});
					}
				})
			});
		},
		setCountryById(id) {
			if(this.countries.length && id) {
				this.country = _(this.countries).find({id:id});
			}
		},
		addTeamMember(data) {
			if(data.name && data.position && data.about && data.image_file) {
				this.readFile(data.image_file, (url) => {
					data.markedToDelete = false;
					data.image = url;
					this.mdl.members.push(data);
				});
			}
		},
		deleteMember(index, member) {
			if(member.id) {
				member.markedToDelete = true;
			} else {
				this.mdl.members.splice(index,1);
			}
		},
		restoreMember(index, member) {
			if(this.office_images_length > 7) return;
			if(member.markedToDelete) {
				member.markedToDelete = false;
			}
		},
		deleteImage(index, image) {
			if(image.id) {
				image.markedToDelete = true;
			} else {
				this.mdl.office_images.splice(index,1);
			}
		},
		restoreImage(index, image) {
			if(image.markedToDelete) {
				image.markedToDelete = false;
			}
		},
		setCompany(company) {
			let mdl = _.cloneDeep(company);
			mdl.members = mdl.members.map(member => {
				member.image = "/storage/"+member.image;
				this.$set(member,'markedToDelete', false);
				return member;
			});

			mdl.office_images = mdl.office_images.map(image => {
				image.image = "/storage/"+image.image;
				this.$set(image,'markedToDelete', false);
				return image;
			});
			this.mdl = mdl;

			if (this.mdl.city)
				this.setCountryById(this.mdl.city.country.id);

			this.loading = false;
		},
		save() {
			let formData = new FormData();
			_(this.mdl).pick(['company_name','email','phone_number','keywords','company_id_number','city_id','address_1','address_2','facebook_url','linkedin_url','twitter_url','google_plus_url','company_website','about_company','password']).forEach((value,key) => {
				formData.append(key,value);
			});

			_(this.mdl.members).pickBy(m => m.markedToDelete).forEach(m => {
				formData.append("delete_members[]",m.id);
			});

			_(this.mdl.members).filter(m => !m.id).forEach((member) => {
				formData.append("member_names[]", member.name);
				formData.append("member_about[]", member.about);
				formData.append("member_images[]", member.image_file);
				formData.append("member_positions[]", member.position);
				formData.append("member_videos[]", member.video_file);
			});

			if(this.$refs.profileImage.dropzone.files.length) {
				formData.append("profile_image", this.$refs.profileImage.dropzone.files[0]);
			}

			_(this.$refs.introImages.dropzone.files).forEach(file => {
				formData.append("intro_images[]", file);
			});

			_(this.mdl.office_images).filter(image => !image.id).forEach(image => {
				formData.append("office_images[]", image.image_file);
			});

			_(this.mdl.office_images).filter(image => image.markedToDelete).forEach(image => {
				formData.append("delete_office_images[]", image.id);
			});

			formData.append("_method", "PUT");
			this.loading = true;
			this.$store.dispatch("saveCompany", formData)
				.then(res => {
					if(res.data.success) {

						this.$root.$alert.open('',res.data.result,function(){
							window.location.href = '/company-details';
						});
					} else {
						this.errors = res.data.error;
					}
					this.loading = false;
				}).catch(err => {
					this.loading = false;
				});

			this.errors = {};
		},
		readFile(file, cb) {
			let reader = new FileReader();
			reader.addEventListener("load", function () {
				cb(reader.result);
			});
			reader.readAsDataURL(file);
		}
	},
	components: {
		AddTeamMember
	}

}
</script>