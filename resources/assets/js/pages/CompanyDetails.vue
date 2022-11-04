<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url(http://via.placeholder.com/1920x850);">
		<div class="container">
			<h1></h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Company Detail Start -->
	<section class="detail-desc">
		<div class="container white-shadow">

			<div class="row">
				<div class="detail-pic">
					<img style="object-fit: contain" :src="`/storage/${company.profile_image}`" class="img" alt="" />
					<router-link :to="'/company/dashboard#company-profile.1450'" class="detail-edit" title="edit" ><i class="fa fa-pencil"></i></router-link>
				</div>
			</div>

			<div class="row bottom-mrg">

				<div class="col-md-8 col-sm-8">
					<div class="detail-desc-caption">
						<h4  id="about">{{company.company_name}}</h4>
						<p class="description-text" style="overflow: hidden; "  v-if="company.about_company !== undefined" :class="{'fixedHaightFourHundred': company.about_company.length > 1500 && !readMore }" v-html="formatText(company.about_company)" >{{company.about_company}}</p>
						<a href="#" @click.prevent="readMore = !readMore" class="pull-right"  v-if="company.about_company !== undefined && company.about_company.length > 1500"> <span v-if="readMore">{{lang('read_less')}}</span> <span v-else>{{lang('read_more')}}</span></a>


						<div class="company-images gallery photo-gallery">

							<a v-for="introImage in company.intro_images"  :href="'/storage/'+introImage.image_url" ><img  :src="`/storage/${introImage.image_url}`" /></a>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4">
					<div class="get-touch">
						<h4>{{lang('company_details_get_in_touch')}}</h4>
						<ul>
							<!--<li><i class="fa fa-calendar"></i><span>01/01/2018</span></li>-->
							<li><i class="fa fa-building"></i><span>{{ company.company_name }}</span></li>
							<li><i class="fa fa-home"></i><span>{{ company.address_1 }} {{ company.address_2 }}</span></li>
							<li v-if="company.city"><i class="fa fa-location-arrow"></i><span>{{company.city.title}}, {{company.city.country.title}}</span></li>
							<li><i class="fa fa-phone"></i><span>{{ company.phone_number }}</span></li>
							<li><i class="fa fa-envelope"></i><span>{{ company.email }}</span></li>
							<li><i class="fa fa-globe"></i><span><a target="_blank" :href="'http://'+company.company_website">{{company.company_website}}</a></span></li>
							<li><i class="fa fa-users"></i><span>{{ members.length + 1 }}</span></li>

						</ul>
					</div>

					<div class="keywords">
						<h4>{{lang('company_details_keywords')}}</h4>
						<a :href="`#${tag.name}`" class="kw" v-for="tag in company.tags">{{tag.name}}</a>
					</div>
				</div>

			</div>

			<div class="row no-padd">
				<div class="detail pannel-footer">

					<div class="col-md-5 col-sm-5">
						<ul class="detail-footer-social">
							<li><a :href="company.facebook_url" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a :href="company.google_plus_url" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							<li><a :href="company.twitter_url" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a :href="company.linkedin_url" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>

					<div class="col-md-7 col-sm-7">
						<div class="detail-pannel-footer-btn pull-right">
							<router-link :to="'/company/dashboard#company-profile.1450'" class="footer-btn blu-btn" title="">{{lang('edit')}}</router-link>
						</div>
					</div>

				</div>
			</div>

		</div>
	</section>
	<!-- Company Detail End -->

	<div class="navigation company-nav-fixed">
		<ul>
			<li>
				<a href="#about" @click.prevent="linkClick">{{lang('company_details_about')}}</a>
			</li>
			<li>
				<a href="#employees" @click.prevent="linkClick">{{lang('company_details_employees')}}</a>
			</li>
			<li>
				<a href="#offices" @click.prevent="linkClick">{{lang('company_details_office')}}</a>
			</li>
			<li>
				<a href="#jobs" @click.prevent="linkClick">{{lang('company_details_jobs')}}</a>
			</li>
		</ul>
	</div>
	<!-- testimonial section Start -->
	<section class="testimonial" id="employees">
		<div class="container">
			<div class="row">
				<div class="main-heading">
					<p>{{lang('company_details_who_works_with_us')}}</p>
					<h2 v-html="lang('company_details_our_team')"></h2>
				</div>
			</div>
			<!--/row-->
			<div class="row">
				<div id="client-testimonial-slider" class="owl-carousel">
					<div class="client-testimonial" v-for="member in members">

						<img class="pic containFit" :src="'/storage/'+member.image" alt="">

						<div class="show-video-container">
							<a href="#" class="show-video" @click.prevent="showVideo(member)" :class="{'disabled-play': !member.video}"><i class="fa fa-play-circle"></i> {{lang('company_details_play')}}</a>
						</div>
						<h3 class="client-testimonial-title">{{member.name}}</h3>
						<p class="client-description">
							{{ member.about }}
						</p>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- testimonial section End -->

	<section class="wp-process" id="offices">
		<div class="container">
			<div class="row">
				<div class="main-heading">
					<p>{{lang('company_details_ofices_title_1')}}</p>
					<h2 v-html="lang('company_details_our_offices')"></h2>
				</div>
			</div>
			<!--/row-->

			<div class="gallery photo-gallery">
				<a v-for="officeImage in gallery" :href="'/storage/'+officeImage.image">
					<img :src="'/storage/'+officeImage.image" />
				</a>
			</div>


		</div>
	</section>

	<!-- company full detail Start -->
	<section class="full-detail-description full-detail" id="jobs">
		<div class="newContainer">
			<div class="row row-bottom">
				<h2 class="detail-title">{{lang('company_details_job_posts')}}</h2>

				<div class="row">
					<spinner v-if="loading" />
					<div class="col col-md-3">
						<form @submit.prevent="searchJobs">
						<div class="form-group">
							<input type="text" v-model="filter.text" class="form-control" :placeholder="lang('company_details_job_title_location')">
						</div>

						<div class="form-group">
							<div class="btn-group two" style="width: 100%">
								<button class="btn btn-primary" type="submit">{{lang('company_details_search')}}</button>
								<button class="btn btn-default" type="button" @click="clearSearch">{{lang('company_details_clear')}}</button>
							</div>
						</div>
						</form>
					</div>
					<div class="col col-md-12" style="overflow: scroll">
						<table class="table table-default table-hover">
							<thead>
							<tr>
								<th>{{lang('company_details_job_created_at')}}</th>
								<th>{{lang('company_details_job_location')}}</th>
								<th>{{lang('company_details_job_title')}}</th>
								<th>{{lang('company_details_job_sector')}}</th>
								<th>{{lang('company_details_job_minimum_experience')}}</th>
								<th>{{lang('company_details_job_career_level')}}</th>
								<th>{{lang('company_details_job_job_description')}}</th>
								<th>{{lang('company_details_job_job_hours')}}</th>
								<th>{{lang('company_details_job_education_direction')}}</th>
								<th>{{lang('company_details_job_education_level')}}</th>
								<th>{{lang('company_details_job_salary_range')}}</th>
								<th>{{lang('company_details_job_matching')}}</th>
							</tr>
							</thead>
							<tbody>
								<tr v-for="job in companyJobs.data">
									<td>{{ job.created_at }}</td>
									<td>{{job.job_location}}</td>
									<td>{{job.job_title.title}}</td>
									<td>{{job.job_sector.title}}</td>
									<td>{{job.minimum_experience}} Years</td>
									<td><template v-if="job.job_career_level">{{job.job_career_level.name}}</template></td>
									<td>
										<span style="max-width: 300px">
											<template v-if="job.job_description">{{ job.job_description.substring(0, 100) }} <template v-if="job.job_description.length > 100">
												<a :href="'/job/'+job.id">...Read More</a></template>
											</template>
										</span>
									</td>
									<td><template v-if="job.job_hours">{{job.job_hours.name}}</template></td>
									<td><template v-if="job.education_field">{{job.education_field.name}}</template></td>
									<td><template v-if="job.education_level">{{job.education_level.name}}</template></td>
									<td><template  v-if="job.job_salary">{{job.job_salary.name}}</template></td>
									<td class="innerJobDetailsActionButtons"><template v-if="job.draft"><router-link :to="`/job/${job.id}/edit`">{{lang('edit')}}</router-link>  <a href="#" @click.prevent="startMatching(job)">{{lang('company_details_start_matchmaking')}}</a> </template><div v-else>{{lang('company_details_matchmaking_started')}}</div> <a :href="'/data/job/'+job.id+'/rematch'" target="_blank">{{lang('company_details_rematching')}}</a> <a href="#" @click.prevent="copyJob(job)">{{lang('company_details_duplicate_job')}}</a> <router-link :to="'/job/'+job.id">{{lang('company_details_view_details')}}</router-link></td>
								</tr>
							</tbody>
						</table>

						<div style="float: right;">
							<pagination v-if="Object.keys(companyJobs).length" :data="companyJobs" @pagination-change-page="companyJobsChange"></pagination>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title">{{lang('company_details_details')}}</h5>
				</div>
				<div class="modal-body">
					<div style="padding: 10px">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
import {mapState} from 'vuex';
export default {
	name: "Company-Details",
	data() {
		return {
			filter: {
				text: '',
				_text: ''
			},
			loading: false,
			readMore: false,
			page: 1,
			search: "",
			companyJobs: []
		}
	},
	created(){
		this.$store.dispatch("fetchCompanyJobs",{
			page: this.page,
			search: this.search
		}).then(res => {
			if (res.data.success){
				this.companyJobs = res.data.result;
			}
		})
	},
	mounted() {
		$(window).scroll(this.scrolling);

		this.initGallery();
		this.initMembers();
	},
	watch: {
		gallery() {
			this.initGallery();
		},
		members() {
			this.initMembers();
		}
	},
	methods: {


		companyJobsChange(page=this.page, search=this.search) {
			// .. continue

			this.page = page;
			this.search = search;

			this.$store.dispatch("fetchCompanyJobs",{
				page: this.page,
				search: this.search
			}).then(res => {
				if (res.data.success){
					this.companyJobs = res.data.result;
				}
			})

		},
		showVideo(member) {
			if(!member.video) return;
			this.$root.$video.open(member.name, '/storage/'+member.video);
		},
		searchJobs() {
			// this.filter._text = this.filter.text;

			this.search  = "&search=" + this.filter.text;

			this.companyJobsChange(this.page, this.search);

		},
		clearSearch() {
			this.filter.text = "";
			this.search = "";
			this.searchJobs();
		},
		startMatching(job) {
			this.$store.dispatch("startMatching", {
				id: job.id
			}).then(res => {
				if(res.data.success) {

					job.draft = 0;
					this.$root.$alert.open("Success", res.data.result);

				} else {
					this.$root.$alert.open("Error", res.data.error.text, () => {
						this.$router.push("/pricing");
					});
				}
			})
		},
		copyJob(job) {
			this.loading = true;
			this.$store.dispatch("duplicateJob", job.id)
					.then(res => {
						if(res.data.success) {
							this.$store.commit("addJob",res.data.result);
							this.companyJobsChange();
							this.loading = false;
						}
					})
					.finally(() => {
						this.loading = false;
					})
		},
		initGallery() {
			if(!this.gallery) return;
			this.$nextTick(() => {
				this.$el.querySelector(".gallery");

				$(".gallery").each(function(key, val){

					lightGallery(val);

				});
			})
		},
		initMembers() {
			if(!this.members || !this.members.length) return;
			this.$nextTick(() => {
				$(this.$el).find("#client-testimonial-slider").owlCarousel({
					center: true,
					items:3,
					itemsDesktop:[1199,3],
					itemsDesktopSmall:[979,2],
					itemsTablet:[768,1],
					pagination: false,
					navigation:false,
					autoPlay:true
				});
			})
		},
		linkClick(e) {
			let href = $(e.currentTarget).attr("href");
			let block = $(this.$el).find(href);
			if(block.length) {
				$("html,body").animate({
					scrollTop: block.offset().top
				});
			}
		},
		scrolling(e) {
			let top = $("html,body").scrollTop();
		},
		formatText(about) {
			return about ? about.replace(/\n/ig, "<br>") : "";
		},
	},
	computed: {
		...mapState(['company']),
		gallery() {
			return this.company.office_images;
		},
		members() {
			return this.company.members || []
		},
		jobs() {
			return _(this.company.jobs).filter(job => {
				return this.filter._text ? job.job_title.title.toLowerCase().includes(this.filter._text) : true;
			}).value();
		}
	}
}
</script>