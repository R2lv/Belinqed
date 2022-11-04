<template>
<div>
	<section class="inner-header-title" style="background-image:url(/img/banner-1.jpeg); background-position-y: -259px;">
		<div class="container">
			<h1></h1>
		</div>
	</section>
	<div class="clearfix"></div>

	<section class="detail-desc advance-detail-pr gray-bg tx-padding-0">
		<div class="container white-shadow">
			<div class="row">
				<div class="detail-pic">
					<img style="object-fit: contain" :src="`/storage/${company.profile_image}`" class="img" alt="" />
					<a href="#" @click.prevent="setHash('/company/dashboard#company-profile.1450')" class="detail-edit" title="edit" ><i class="fa fa-pencil"></i></a>
				</div>
				<!--<div class="detail-status"><span>Active Now</span></div>-->
			</div>

			<div class="row bottom-mrg">
				<div class="col-md-12 col-sm-12">
					<div class="advance-detail detail-desc-caption">
						<h4>{{company.company_name}}</h4>
						<ul>
							<li class="width-auto text-align-center forced-full-width  ">
                                <strong class=" dview j-view">{{analytics.job_posts}}</strong>
								<span> {{lang('company_dashboard_stats_job_post')}} </span>
							</li>
							<li class="width-auto text-align-center forced-full-width  ">
								<strong class="j-applied">{{analytics.job_viewed}}</strong>
								<span>{{lang('company_dashboard_stats_job_viewed')}}</span>
							</li>
							<li class="width-auto text-align-center forced-full-width  ">
								<strong class="j-shared"> {{analytics.job_matched}} </strong>
								<span>{{lang('company_dashboard_stats_job_matched')}}</span>
							</li>
						</ul>
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

					</div>
				</div>
			</div>

		</div>
	</section>

	<section class="full-detail-description full-detail gray-bg tx-padding-0">
		<div class="container">
			<div class="col-md-12 col-sm-12">
				<div class="full-card">
					<div class="deatil-tab-employ tool-tab">
						<ul class="nav simple nav-tabs" id="simple-design-tab">
							<li class="active"><a href="#user-profile" role="tab" data-toggle="tab">{{lang('company_dashboard_tabs_user_profile')}}</a></li>
							<li><a href="#company-profile" role="tab" data-toggle="tab">{{lang('company_dashboard_tabs_company_details')}}</a></li>
							<li><a href="#job-candidates" role="tab" data-toggle="tab">{{lang('company_dashboard_tabs_job_candidates')}}</a></li>
							<li><a href="#alerts" role="tab" data-toggle="tab">{{lang('company_dashboard_tabs_important_alerts')}} <span class="info-bar" v-if="$refs.alerts_tab && $refs.alerts_tab.alerts_length">{{$refs.alerts_tab.alerts_length}}</span></a></li>
							<li><a href="#my-package" role="tab" data-toggle="tab">{{lang('company_dashboard_tabs_my_package')}}</a></li>
						</ul>

						<template>
							<div class="tab-content spinner-holder">

								<edit-company-profile-tab />

								<edit-company-tab />

								<job-candidates-tab />
								<company-alerts-tab ref="alerts_tab" />
								<my-package-tab />
							</div>
						</template>
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
	computed: {
		...mapState(['company','profile','analytics'])
	},
	mounted() {

		$(this.$el).find("a[href='#alerts']").on("shown.bs.tab", e => {
			this.$refs.alerts_tab.shown();
		});

		this.checkHash();
	},
	methods: {
		setHash(hash){
			window.location.href = hash;
			this.checkHash();
		},
		checkHash(){
			if(location.hash) {
				let hash=location.hash,scroll=0;
				if(location.hash.indexOf(".")) {
					hash = location.hash.substring(0,location.hash.indexOf("."));
					scroll = location.hash.substring(location.hash.indexOf(".")+1);
				}
				$(`a[href='${hash}']`).tab("show");

				setTimeout(e => {
					$("html,body").scrollTop(scroll);
					console.log("Scroll", scroll);
				});
			}
		}
	}
}
</script>