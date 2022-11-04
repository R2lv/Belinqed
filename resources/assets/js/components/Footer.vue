<template>
<div>
	<!-- Footer Section Start -->
	<footer class="footer">
		<div class="row lg-menu">
			<div class="container">
				<div class="col-md-4 col-sm-4">
					<img src="/img/footer-logo.png" class="img-responsive" alt="" />
				</div>
				<div class="col-md-8 co-sm-8 pull-right">

				</div>
			</div>
		</div>
		<div class="row no-padding">
			<div class="container">
				<div class="col-md-3 col-sm-12">
					<div class="footer-widget">
						<h3 class="widgettitle widget-title">{{ 'footer_about_section_title' | translate }}</h3>
						<div class="textwidget">

							<div v-html="footer.about"></div>
							<ul class="footer-social">
								<li><a :href="footer.fb" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a :href="footer.twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a :href="footer.instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
								<li><a :href="footer.linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-4">
					<div class="footer-widget">
						<h3 class="widgettitle widget-title">{{ lang("footer_title_2")  }}</h3>
						<div class="textwidget">
							<div class="textwidget">
								<ul class="footer-navigation">
									<li><a href="/" title="">{{ 'home' | translate }}</a></li>
									<li v-if="$auth.isLoggedIn()"><router-link href="#" :to="$auth.isCompany() ? '/company/dashboard' : '/applicant/dashboard'">{{ 'dashboard' | translate }}</router-link></li>
									<li v-if="$auth.isLoggedIn() && !$auth.isCompany()"><router-link href="#"  :to="'/resume' ">{{ 'my_resume' | translate }}</router-link></li>
									<li v-if="$auth.isLoggedIn() && $auth.isCompany()"><router-link href="#" :to="'/company-details' ">{{ 'company_details' | translate  }}</router-link></li>
									<li v-if="$auth.isLoggedIn() && $auth.isCompany()"><router-link href="#" :to="'/create-job'">{{ 'create_job' | translate }}</router-link></li>
									<li><a href="/blog">{{ 'blog' | translate }}</a></li>
									<li  v-if="$auth.isCompany()"><a href="/pricing">{{ 'pricing' | translate }}</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-2 col-sm-2">
				</div>

				<div class="col-md-4 col-sm-6">
					<div class="footer-widget">
						<h3 class="widgettitle widget-title">{{ lang('footer_contact_title') }}</h3>
						<div class="textwidget">
							<form class="footer-form">
								<input type="text" class="form-control" :placeholder=" lang('footer_contact_name')">
								<input type="text" class="form-control" :placeholder="lang('footer_contact_email')">
								<textarea class="form-control" :placeholder="lang('footer_contact_msg')"></textarea>
								<button type="submit" class="btn btn-primary">{{ lang('submit') }}</button>
							</form>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="row copyright">
			<div class="container">
				<p class="">{{ lang('copyright')}} </p>
				<small class="pull-right" style="letter-spacing: 0.5px; color: #fff;font-family: 'Quicksand', sans-serif;text-align: center;padding: 1em 0;display: inline-block;"> {{ lang('powered_by') }} <a href="/">Coding-Arts.com </a></small>
			</div>
		</div>

	</footer>
	<div class="clearfix"></div>
	<!-- Footer Section End -->
</div>
</template>

<script>
export default {
	data(){
		return {
			footer:{}
		}
	},
	created(){
		this.$store.dispatch('fetchFooterInfo')
				.then(res=> {
					if(res.data.success){
						this.footer = res.data.result;
					}
				})
	}
}
</script>

<style scoped>

	textarea {
		resize: vertical;
	}

</style>