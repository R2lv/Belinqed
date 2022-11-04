<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image: url('/img/banner-1.jpg')">
		<div class="container">
			<h1>{{ lang("applicant_dashboard_page_title")}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Candidate Profile Start -->
	<section class="detail-desc advance-detail-pr gray-bg tx-padding-0">
		<div class="container white-shadow">

			<div class="row">
				<div class="detail-pic">
					<img style="object-fit: contain" :src="'/storage/'+user.profile_picture_url" class="img" alt="" />
					<a href="#" @click.prevent="setHash('/applicant/dashboard#settings.1100')" class="detail-edit" title="edit" ><i class="fa fa-pencil"></i></a>
				</div>

			</div>

			<div class="row bottom-mrg">
				<div class="col-md-12 col-sm-12">
					<div class="advance-detail detail-desc-caption">
						<h4>{{user.name}} {{user.surname}}</h4>
						<ul>
							<li><strong class="j-view"><router-link class="fa fa-file j-view" to="/resume"></router-link></strong>{{ lang("applicant_dashboard_my_resume") }}</li>
							<li><strong class="j-applied"><a href="#"  @click.prevent="openVideo" class="fa fa-play-circle j-applied"></a></strong>{{ lang("applicant_dashboard_play_video") }}</li>
							<li><strong class="j-shared"><a href="#job-invitations" class="j-shared">{{$refs.matches_tab ? $refs.matches_tab.matches.length : 0}}</a></strong>{{ lang("applicant_dashboard_matches") }}</li>
						</ul>
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
							<li class="active"><a href="#about" data-toggle="tab" role="tab">{{ lang("applicant_dashboard_about_me") }}</a></li>
							<li><a href="#vacancy-matches" data-toggle="tab" role="tab">{{ lang("applicant_dashboard_matched") }}</a></li>
							<li><a href="#alerts" data-toggle="tab" role="tab">{{ lang("applicant_dashboard_alerts") }} <span class="info-bar" v-if="$refs.alerts_tab && $refs.alerts_tab.alerts_length">{{$refs.alerts_tab.alerts_length}}</span></a></li>
							<li><a href="#settings" data-toggle="tab" role="tab">{{ lang("applicant_dashboard_profile_edit")}}</a></li>
						</ul>

						<template>

						<!-- Start All Sec -->


						<div class="tab-content spinner-holder">
							<about-tab class="active in" />
							<job-invitations-tab ref="matches_tab" />
							<applicant-alerts-tab ref="alerts_tab" />
							<edit-profile-tab ref="editProfile" />
						</div>
						</template>
						<!-- Start All Sec -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Candidate Profile End -->
</div>
</template>

<script>
import {mapState} from 'vuex';
export default {
	data() {
		return {
		}
	},
	computed: {
		...mapState({
			user: 'profile'
		})
	},
	mounted() {

		$(this.$el).find("a[href='#alerts']").on("shown.bs.tab", e => {
			this.$refs.alerts_tab.shown();
		});


		this.checkHash();
	},
	methods: {
		openVideo(){
			this.$root.$video.open('Video','/storage/videos/'+this.$store.state.resume.video_url);
		},
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