<template>
<div class="head-notification bg-warning text-center" v-if="notifications.length">
	<div class="container">
		<div class="notifications-slider">
			<div v-for="(notification,index) in notifications" :key="notification">
				<div v-if="notification==='verify_mobile'">
					<i class="fa fa-warning"></i> {{index + 1}}/{{notifications.length}}&emsp;
					{{lang('notif_verify_mobile_1')}} {{profile.mobile_number}}, <a href="#">{{lang('enter_code')}}</a>, <a href="#">{{lang('resend_it')}}</a> {{lang('or_change_from')}}
					<router-link :to="'/dashboard'">{{lang('profile_edit')}}</router-link>
				</div>
				<div v-else-if="notification==='verify_email'">
					<i class="fa fa-warning"></i> {{index + 1}}/{{notifications.length}}&emsp;
					{{lang('notif_verify_email_1')}} {{profile.email}}, <a href="#">{{lang('resend_it')}}</a> {{lang('or_change_from')}}
					<router-link :to="'/dashboard'">{{lang('profile_edit')}}</router-link>
				</div>
				<div v-else-if="notification==='submit_resume'">
					<i class="fa fa-warning"></i> {{index + 1}}/{{notifications.length}}&emsp;
					{{lang('_text_submit_resume')}} <router-link :to="'/resume-edit'">{{lang('submit_resume')}}</router-link>
				</div>
				<div v-else-if="notification==='waiting_to_accept_resume'">
					<i class="fa fa-warning"></i> {{index + 1}}/{{notifications.length}}&emsp;
					{{lang('_text_waiting_for_approval')}}
				</div>
				<div v-else-if="notification==='resume_rejected'">
					<i class="fa fa-warning"></i> {{index + 1}}/{{notifications.length}}&emsp;
					{{lang('_text_resume_rejected')}} <router-link :to="'/resume-edit'">{{lang('resubmit_resume')}}</router-link>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import {mapState} from 'vuex';
export default {
	name: "notifications",
	mounted() {
		if(!this.loading) {
			this.init();
		}
	},
	watch: {
		notifications(notifications) {
			this.init();
		}
	},
	methods: {
		init() {
			$(this.$el).find(".notifications-slider.slick-initialized").slick("unslick");

			this.$nextTick(() => {
				$(this.$el).find(".notifications-slider").slick({
					prevArrow: "<span class='slick-arrow slick-prev-custom fa fa-arrow-left'></span>",
					nextArrow: "<span class='slick-arrow slick-next-custom fa fa-arrow-right'></span>",
					infinite: false
				});
			});
		}
	},
	computed: {
		...mapState(['notifications','profile']),
		...mapState({loading: state => state.loadings.notifications}),
	}
}
</script>