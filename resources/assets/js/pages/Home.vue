<template>
<div>
	<!-- Main Banner Section Start  todo remove dev urls -->
	<div class="header-cover"></div>
	<div class="banner" :style="'background-image:url(https://belinqed.com/storage/'+homeStats.banner+')'">

		<div class="container banner-title-container flex">
			<div class="banner-caption " style="margin: auto">
				<div class="col-md-12 col-sm-12 ">
					<h1 class="banner-title">{{ homeStats.welcome_title }}</h1>
					<p style="margin-top: -25px; font-size: 22px;">{{ homeStats.welcome_sub_title }}</p>
				</div>
				<div class="col-md-12 col-sm-12 banner-buttons-container">
					<div class="flex" style="flex-direction: row">
						<a class="dashboard-button flex" v-if="($auth.isLoggedIn() && (!$auth.isCompany())) || (!$auth.isLoggedIn())" @click.prevent="fillResume"><span class="icon"><i class="fa fa-pencil"></i></span><span class="btn-title">{{ lang('fill_resume') }}</span></a>
						<a class="dashboard-button flex" v-if="($auth.isLoggedIn() && $auth.isCompany()) || (!$auth.isLoggedIn())" @click.prevent="postJob"><span class="icon"><i class="fa fa-plus"></i></span><span class="btn-title">{{ lang('post_job') }}</span></a>
					</div>
				</div>
			</div>
		</div>

		<div class="site-stats-cover"></div>
		<div class="site-stats" v-if="partners.length">
			<div class="container banner-home-stats" >
				<div class="row flex flex-jc-between">
					<div class="flex-row">
						<div class="teaser display-flex text-center">
							<img src="/img/cv.png" width="24px">
							<h1 class="stats-title" >{{ homeStats.candidate_profiles }}</h1>
							<p>{{'candidate_profiles' | translate}} </p>
						</div>
					</div>
					<div class="flex-row">
						<div class="teaser text-center">
							<img src="/img/company.png" width="24px">
							<h1 class="stats-title" >{{ homeStats.company_profiles }}</h1>
							<p>{{'company_profiles' | translate}} </p>
						</div>
					</div>
					<div class="flex-row">
						<div class="teaser display-flex text-center">
							<img src="/img/job.png" width="24px">
							<h1 class="stats-title" >{{ homeStats.total_jobs }}</h1>
							<p>{{'total_jobs' | translate}} </p>
						</div>
					</div>
					<div class="flex-row">
						<div class="teaser display-flex text-center">
							<img src="/img/matches.png" width="24px">
							<h1 class="stats-title" >{{ homeStats.matches }}</h1>
							<p>{{'successful_matches' | translate}} </p>
						</div>
					</div>
					<div class="flex-row">
						<div class="teaser display-flex text-center">
							<img src="/img/waiting.png" width="24px">
							<h1 class="stats-title" >{{ homeStats.waiting }}</h1>
							<p>{{'waiting_for_matching' | translate}} </p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="clearfix"></div>
	<!-- Main Banner Section End -->

	<!-- Top Features Section Start-->
	<section class="first-feature" v-if="features.length">
		<div class="container">
			<div class="all-features">

				<div class="col-md-3 col-sm-6 small-padding" v-for="feature in features">
					<div class="job-feature">
						<div class="feature-icon">
							<i class="fa " :class="feature.icon"></i>
						</div>
						<div class="feature-caption">
							<h5>{{ feature.title }}</h5>
							<p>{{ feature.description }}</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Top Features Section End-->

	<!-- video section Start -->
	<section class="video-sec dark" id="video" style="background-image:url('/img/banner-2.jpg');">
		<div class="container">
			<div class="row">
				<div class="main-heading">
					<p>{{'video_title_1' | translate}}</p>
					<h2>{{'video_title_2_1' | translate}} <span>{{'video_title_2_2' | translate}}</span></h2>
				</div>
			</div>
			<!--/row-->
			<div class="video-part">
				<a href="#" data-toggle="modal" data-target="#my-video" @click="watchVideo = true;" class="video-btn"><i class="fa fa-play"></i></a>
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- video section Start -->

	<!-- Work Process Counter Section Start -->
	<section id="work-process" class="wp-process" v-if="workflow.length">
		<div class="container">
			<div class="row">
				<div class="main-heading">
					<p>{{'work_section_title' | translate }}</p>
					<h2>{{ 'work_section_title_2_1' | translate }} <span>{{ 'work_section_title_2_2' | translate }}</span></h2>
				</div>
			</div>
			<!--/row-->

			<div class="col-md-4 col-sm-6 workflow-item" v-for="wf in workflow">
				<div class="work-process">
					<div class="work-process-icon">
						<span class="fa" :class="wf.icon"></span>
					</div>
					<div class="work-process-caption">
						<h4 class="workflow-title">{{ wf.title }}</h4>
						<p>{{ wf.description }}</p>
					</div>
				</div>
			</div>

		</div>
	</section>


	<section id="brand">
		<div class="company-brand" v-if="partners.length">

			<div id="company-brands" class="owl-carousel">
				<div class="brand-img" v-for="partner in partners">
					<a :href="partner.url" target="_blank"><img :src="'https://belinqed.com/storage/'+partner.image" class="img-responsive"  alt="" /></a>
				</div>
			</div>

		</div>
	</section>


	<div class="clearfix"></div>



	<div class="bootbox modal fade video in" tabindex="-1" role="dialog" v-if="watchVideo" style="display: block;">
		<div class="modal-dialog" style="margin-top: 150px">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="bootbox-close-button close" @click="watchVideo = !watchVideo"  style="margin-top: -10px;">×</button>
					<div class="bootbox-body">
						<video style="outline: none" :src="homeStats.video" width="600px" controls="" autoplay=""></video>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>
</template>

<script>
export default {
	data() {
		return {
			packages: [],
			partners: [],
			features: [],
			workflow: [],
			homeStats:[],
			watchVideo: false
		}
	},
	created() {
		this.$store.dispatch("fetchPackages")
				.then(res=> {
					if(res.data.success)
						this.packages = res.data.result;
				});


		this.$store.dispatch("fetchHomePartners")
				.then(res=> {
					if(res.data.success)
						this.partners = res.data.result;
						setTimeout(()=>{
							this.brandsOwlCarousel();
						},200);
				});


		this.$store.dispatch("fetchHomeFeatures")
				.then(res=> {
					if(res.data.success)
						this.features = res.data.result;

				});


		this.$store.dispatch("fetchHomeWorkflow")
				.then(res=> {
					if(res.data.success)
						this.workflow = res.data.result;
				});

		this.$store.dispatch("fetchHomeStats")
				.then(res=> {
					if(res.data.success)
						this.homeStats = res.data.result;
				});





	},
	mounted() {


		$(this.$el).find("#client-testimonial-slider").owlCarousel({
			items:3,
			itemsDesktop:[1199,3],
			itemsDesktopSmall:[979,2],
			itemsTablet:[768,1],
			pagination: false,
			navigation:false,
			navigationText:["",""],
			autoPlay:true,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:3,
					nav:false
				},
				1000:{
					items:5,
					nav:true,
					loop:false
				},
				1180: {
					items: 9
				}
			}
		});
	},
	methods:{

		fillResume(){
			if(this.$auth.isLoggedIn() || this.$auth.isCompany()){
				this.$router.push({path:'/resume-edit'});
			}

			if(!this.$auth.isLoggedIn()) {
				this.$parent.$refs.theader.$refs.signUp.isLoginActive = false;
				this.$parent.$refs.theader.$refs.signUp.$refs.registrationForm.mdl.isCompany = false;
				$("#signup").modal("show");
			}

		},

		postJob(){

			if(this.$auth.isLoggedIn() || this.$auth.isCompany()){
				this.$router.push({ path: '/create-job' })
			}

			if(!this.$auth.isLoggedIn()) {
				this.$parent.$refs.theader.$refs.signUp.isLoginActive = false;
				this.$parent.$refs.theader.$refs.signUp.$refs.registrationForm.mdl.isCompany = true;
				$("#signup").modal("show");
			}

		},
		brandsOwlCarousel(){
			$(this.$el).find("#company-brands").owlCarousel({
				items:9,
				itemsDesktop:[1199,5],
				itemsDesktopSmall:[979,4],
				itemsTablet:[768,3],
				itemsMobile: [600, 2],
				pagination: false,
				navigation:false,
				navigationText:["",""],
				autoPlay:true
			});
		}
	}
}
</script>

<style scoped>

	.workflow-item {
		min-height: 400px;
	}
	.workflow-title {
		min-height: 70px;
	}

	.job-feature {
		min-height:480px;
	}

	.banner {
		height: auto;
		min-height: 872px !important;
		padding-top: 0;
	}

	.banner-home-stats {
		position: relative;
		bottom: 0;
		left: 0;
		right: 0;
	}
	.banner-cont {
		margin-top: 79px !important;
	}
	#brand {
		position: relative;
		width: 100%;
		padding: 0;

	}

	section#work-process {
		background: #F4F7F7;
	}
	#brand .img-responsive {
		height: 60px
	}


	#brand .company-brand {
		border-top: 1px solid #040814;
		background: #fff !important;
		padding: 55px 0;
		opacity: 1;
		position: relative;
	}

	.banner .banner-title {
		font-size: 60px;
	}
	.banner h1 {
		font-size: 35px;
		margin-bottom: 0;
	}

	.banner p {
		font-size: 16px;
		margin-bottom: 0px;
		padding: 17px 0;
	}

	.site-stats {
		position: absolute;
		bottom: 0;
		left: 0;
		background: #070E22;
		display: table;
		/* padding: 2em 0; */
		width: 100%;
		opacity: .7;
		padding: 10px 0 20px 0;
	}
	.display-flex {
		display: flex;
		flex-direction: column;
	}

	.teaser {
		text-align: center;
	}

	.site-stats .flex-row {
		margin: auto;
		min-width: 100px;
	}
	.site-stats .flex {
		flex-wrap: wrap;
		margin: auto;
	}
	.site-stats img {
		padding: 17px 0 7px 0;
		margin: auto;
	}
	.site-stats .stats-title {
		color: #fff;
		margin-top: 0;
	}

	.header-cover {
		height: 79px;
		width: 100%;
	}

	.banner-caption {
		text-align: left;
	}
	.dashboard-button {
		font-size: 16px;
		/*padding: 20px 16px;*/
		border-radius: 5px;
		color: #fff;
		background-color: #36A8E0;
		cursor: pointer;
		width: 300px;

	}


	.dashboard-button:first-child {
		margin-right: 16px;
	}

	.dashboard-button i {
		float: left;
		padding: 20px;
		background-color: #3290BE;
		color: #fff;
		border-top-left-radius: 5px;
		border-bottom-left-radius: 5px;
		border-right: 1px  solid #3290BE;

	}

	.dashboard-button:hover {
		background: #3290BE;
	}
	.dashboard-button:hover i {
		border-right-color: #47a4d2;
	}

	.dashboard-button .btn-title {
		margin: auto;
		text-align: center;
	}

	.banner .banner-buttons-container {
		margin: 75px 0;
	}

	.banner .banner-title-container {
		height: 652px;
	}


	#brand {
		width: 100%;
		overflow: hidden;
	}




	@media screen and (max-width: 1024px) {
		.header-cover {
			height: auto;
		}


	}




	@media screen and (max-width: 423px) {

		.banner .container .banner-title {
			font-size: 50px;
		}

		.banner {
			min-height: 1000px !important;
		}

		.banner .banner-buttons-container {
			margin: 20px 0;
		}

		.banner .banner-title-container {
			height: 512px;
		}
	}
</style>