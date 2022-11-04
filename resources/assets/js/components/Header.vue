<template>
<div>
	<!-- Start Navigation -->
	<nav class="navbar navbar-default navbar-fixed navbar-transparent white bootsnav">

		<notifications />
		<div class="container">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				<i class="fa fa-bars"></i>
			</button>
			<!-- Start Header Navigation -->
			<div class="navbar-header">
				<a class="navbar-brand " href="/">
					<img src="/img/logo.png" class="logo logo-display" alt="">
					<img src="/img/logo-white.png" class="logo logo-scrolled" alt="">
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-menu">
				<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn()">
						<router-link href="#" :to="$auth.isCompany() ? '/company/dashboard' : '/applicant/dashboard'">{{'dashboard' | translate}}</router-link>
					</li>
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn() && $auth.isCompany()">
						<router-link href="#" :to="'/company-details' ">{{'company_details' | translate}}</router-link>
					</li>
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn() && $auth.isCompany()">
						<router-link href="#" :to="'/create-job'">{{'create_job' | translate}}</router-link>
					</li>
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn() && !$auth.isCompany()">
						<router-link href="#"  :to="'/resume' ">{{'my_resume' | translate}}</router-link>
					</li>
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn()"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{{'browse' | translate}}</a>
						<ul class="dropdown-menu megamenu-content" role="menu">
							<li>
								<div class="row">

									<template v-if="$auth.isCompany()">
										<div class="col-menu col-md-4">
											<h6 class="title">{{'company_profile' | translate}}</h6>
											<div class="content">
												<ul class="menu-col">
													<li><router-link href="#" :to="'/'">{{'home' | translate}}</router-link></li>
													<li><router-link href="#" :to="'/company/dashboard'">{{'dashboard' | translate}}</router-link></li>
													<li><router-link href="#" :to="'/company-details'">{{'company_details' | translate}}</router-link></li>
												</ul>
											</div>
										</div><!-- end col-3 -->
										<div class="col-menu col-md-4">
											<h6 class="title">{{'jobs' | translate}}</h6>
											<div class="content">
												<ul class="menu-col">
													<li>
														<router-link href="#" :to="'/create-job'">{{'create_job' | translate}}</router-link>
													</li>
												</ul>
											</div>
										</div>
									</template>
									<template v-else>
										<div class="col-menu col-md-4">
											<h6 class="title">{{'my_profile' | translate}}</h6>
											<div class="content">
												<ul class="menu-col">
													<li><router-link href="#" :to="'/'">{{'home' | translate}}</router-link></li>
													<li><router-link :to="'/applicant/dashboard'">{{'dashboard' | translate}}</router-link></li>
													<li><router-link :to="'/resume'">{{'my_resume' | translate}}</router-link></li>
												</ul>
											</div>
										</div>
									</template>
									<div class="col-menu col-md-4">
										<h6 class="title">{{'other_pages' | translate}}</h6>
										<div class="content">
											<ul class="menu-col">
												<li><a href="/blog">{{'blog' | translate}}</a></li>
												<li  v-if="$auth.isCompany()"><a href="/pricing">{{'pricing' | translate}}</a></li>
											</ul>
										</div>
									</div>

								</div><!-- end row -->
							</li>
						</ul>
					</li>
					<template v-else>
						<li>
							<router-link href="#" :to="'/blog'">{{'blog' | translate}}</router-link>
						</li>
						<li  v-if="$auth.isCompany()">
							<router-link href="#" :to="'/pricing'">{{'pricing' | translate}}</router-link>
						</li>
					</template>
					<li class="left-br" v-if="!$auth.isLoggedIn()"><a href="#" @click="signIn"  data-toggle="modal" data-target="#signup" class="signin"><i class="fa fa-sign-in" aria-hidden="true"></i> {{'sign_in' | translate}}</a></li>
					<li class="left-br" v-else><a href="#" @click.prevent="signOut" class="signin"><i class="fa fa-sign-out" aria-hidden="true" ></i>{{'sign_out' | translate}}</a></li>
					<li class="dropdown megamenu-fw" v-if="$auth.isLoggedIn()">
						<router-link v-if="!$auth.isCompany()" href="#" :to="'/applicant/dashboard'">{{ this.$store.state.profile.surname }}, {{ this.$store.state.profile.name }}</router-link>
						<router-link v-else href="#" :to="'/company/dashboard'">  {{ this.$store.state.company.company_name}} {{ this.$store.state.profile.lastname }}, {{ this.$store.state.profile.name }}</router-link>
					</li>



					<li class="dropdown megamenu-fw language-dropdown" ><a href="#" class="dropdown-toggle" data-toggle="dropdown">

						<span v-if="isLang('en')"><img class="lang-file" src="/img/flg-us.svg" alt="US"></span>
						<span v-else-if="isLang('ka')"><img class="lang-file" src="/img/flg-ka.svg" alt="KA"></span>
						<span v-else>{{'select_language' | translate}}</span>

					</a>
						<ul class="dropdown-menu megamenu-content">
							<li>
								<div class="row">
									<div class="col-menu col-md-4" style="padding: 0 20px">
										<ul style="list-style: none;text-align: left;margin: 0;padding: 0;" >
											<li><a href="#" @click.prevent="changeLanguage('en')"><img class="lang-file" src="/img/flg-us.svg" alt="US"></a></li>
											<li><a href="#" @click.prevent="changeLanguage('ka')"><img class="lang-file" src="/img/flg-ka.svg" alt="KA"></a></li>
										</ul>

									</div>

								</div><!-- end row -->
							</li>
						</ul>
					</li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!-- End Navigation -->
	<div class="clearfix"></div>

	<sign-up ref="signUp" />
	<pw-forgot ref="pw_forgot_modal" />

</div>
</template>
<script>
import SignUp  from "./SignupModal";
import PwForgot from './ForgotPasswordModal';

export default {
	data() {
		return {
			mdl: {
				reg: {

				},
				login: {

				}
			}
		}
	},
	mounted() {

		console.log(this.$store.state);

		this.initialize();

		let self = this;

		// Reset on resize
		$(window).on("resize", function(){
			self.hoverDropdown();

			$(this.$el).find(".top-search").slideUp();
			setTimeout(() =>{
				self.navbarSticky();
			}, 500);

			// Toggle Bars
			$(this.$el).find(".navbar-toggle").each(function(){
				$(".fa", this).removeClass("fa-times");
				$(".fa", this).addClass("fa-bars");
				$(this).removeClass("fixed");
			});
			$(this.$el).find(".navbar-collapse").removeClass("in");
			$(this.$el).find(".navbar-collapse").removeClass("on");
			$(this.$el).find(".navbar-collapse").removeClass("bounceIn");
		});

		if(this.$route.query.action === 'signup') {
			$("a[role=tab][href='#register']").tab('show');
			$("#signup").modal("show");
		} else if(this.$route.query.action === 'signin' ) {
			$("#signup").modal("show");
		}

		document.documentElement.lang = this.$cookie.get('lang');

	},
	methods: {

		isLang(lang){
			return this.$cookie.get('lang') === lang;
		},
		changeLanguage(lang) {
			this.$cookie.set('lang',lang);

			this.$store.dispatch('setLocale',{locale:lang})
					.then(res => {
						if(res.data.success) {
							this.$router.go();
						}else{
							console.log('lang not changed');
						}
					});

		},
		signIn(){
			this.$refs.signUp.isLoginActive = true;
		},
		signOut() {
			this.$store.dispatch("signOut").then(() => {
				this.$auth.logout();
				location.href = "/";
			});
		},
		initialize: function() {
			this.event();
			this.hoverDropdown();
			this.navbarSticky();
			this.navbarScrollspy();
		},
		event : function(){

			// ------------------------------------------------------------------------------ //
			// Variable
			// ------------------------------------------------------------------------------ //
			var getNav = $("nav.navbar.bootsnav");

			// ------------------------------------------------------------------------------ //
			// Navbar Sticky
			// ------------------------------------------------------------------------------ //
			var navSticky = getNav.hasClass("navbar-sticky");
			if( navSticky ){
				// Wraped navigation
				getNav.wrap("<div class='wrap-sticky'></div>");
			}

			// ------------------------------------------------------------------------------ //
			// Navbar Center
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("brand-center")){
				var postsArr = [],
					index = $("nav.brand-center"),
					$postsList = index.find('ul.navbar-nav');

				//Create array of all posts in lists
				index.find('ul.navbar-nav > li').each(function(){
					postsArr.push($(this).html());
				});

				//Split the array at this point. The original array is altered.
				var firstList = postsArr.splice(0, Math.round(postsArr.length / 2)),
					secondList = postsArr,
					ListHTML = '';

				var createHTML = function(list){
					ListHTML = '';
					for (var i = 0; i < list.length; i++) {
						ListHTML += '<li>' + list[i] + '</li>'
					}
				};

				//Generate HTML for first list
				createHTML(firstList);
				$postsList.html(ListHTML);
				index.find("ul.nav").first().addClass("navbar-left");

				//Generate HTML for second list
				createHTML(secondList);
				//Create new list after original one
				$postsList.after('<ul class="nav navbar-nav"></ul>').next().html(ListHTML);
				index.find("ul.nav").last().addClass("navbar-right");

				//Wrap navigation menu
				index.find("ul.nav.navbar-left").wrap("<div class='col-half left'></div>");
				index.find("ul.nav.navbar-right").wrap("<div class='col-half right'></div>");

				//Selection Class
				index.find('ul.navbar-nav > li').each(function(){
					var dropDown = $("ul.dropdown-menu", this),
						megaMenu = $("ul.megamenu-content", this);
					dropDown.closest("li").addClass("dropdown");
					megaMenu.closest("li").addClass("megamenu-fw");
				});
			}


			// ------------------------------------------------------------------------------ //
			// Navbar Sidebar
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("navbar-sidebar")){
				// Add Class to body
				$("body").addClass("wrap-nav-sidebar");
				getNav.wrapInner("<div class='scroller'></div>");
			}else{
				$(".bootsnav").addClass("on");
			}

			// ------------------------------------------------------------------------------ //
			// Menu Center
			// ------------------------------------------------------------------------------ //
			if( getNav.find("ul.nav").hasClass("navbar-center")){
				getNav.addClass("menu-center");
			}

			// ------------------------------------------------------------------------------ //
			// Navbar Full
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("navbar-full")){
				// Add Class to body
				$(this.$el).find("nav.navbar.bootsnav").find("ul.nav").wrap("<div class='wrap-full-menu'></div>");
				$(this.$el).find(".wrap-full-menu").wrap("<div class='nav-full'></div>");
				$(this.$el).find("ul.nav.navbar-nav").prepend("<li class='close-full-menu'><a href='#'><i class='fa fa-times'></i></a></li>");
			}else if( getNav.hasClass("navbar-mobile")){
				getNav.removeClass("no-full");
			}else{
				getNav.addClass("no-full");
			}

			// ------------------------------------------------------------------------------ //
			// Navbar Mobile
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("navbar-mobile")){
				// Add Class to body
				$(this.$el).find('.navbar-collapse').on('shown.bs.collapse', function() {
					$("body").addClass("side-right");
				});
				$(this.$el).find('.navbar-collapse').on('hide.bs.collapse', function() {
					$("body").removeClass("side-right");
				});

				$(window).on("resize", function(){
					$("body").removeClass("side-right");
				});
			}

			// ------------------------------------------------------------------------------ //
			// Navbar Fixed
			// ------------------------------------------------------------------------------ //

			var onScroll;
			if( getNav.hasClass("no-background")){
				onScroll = function(){
					var scrollTop = $(window).scrollTop();
					if(scrollTop >34){
						$(".navbar-fixed").removeClass("no-background");
					}else {
						$(".navbar-fixed").addClass("no-background");
					}
				};
			}

			// ------------------------------------------------------------------------------ //
			// Navbar Fixed
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("navbar-transparent")){
				onScroll = function(){
					let scrollTop = $(window).scrollTop();
					if(scrollTop >34){
						$(".navbar-fixed").removeClass("navbar-transparent");
					}else {
						$(".navbar-fixed").addClass("navbar-transparent");
					}
				};
			}

			$(window).scroll(onScroll);
			onScroll();

			// ------------------------------------------------------------------------------ //
			// Button Cart
			// ------------------------------------------------------------------------------ //
			$(".btn-cart").on("click", function(e){
				e.stopPropagation();
			});

			// ------------------------------------------------------------------------------ //
			// Toggle Search
			// ------------------------------------------------------------------------------ //
			$(this.$el).find("nav.navbar.bootsnav .attr-nav").each(function(){
				$("li.search > a", this).on("click", function(e){
					e.preventDefault();
					$(".top-search").slideToggle();
				});
			});
			$(this.$el).find(".input-group-addon.close-search").on("click", function(){
				$(".top-search").slideUp();
			});

			// ------------------------------------------------------------------------------ //
			// Toggle Side Menu
			// ------------------------------------------------------------------------------ //
			$(this.$el).find("nav.navbar.bootsnav .attr-nav").each(function(){
				$("li.side-menu > a", this).on("click", function(e){
					e.preventDefault();
					$("nav.navbar.bootsnav > .side").toggleClass("on");
					$("body").toggleClass("on-side");
				});
			});
			$(this.$el).find(".side .close-side").on("click", function(e){
				e.preventDefault();
				$("nav.navbar.bootsnav > .side").removeClass("on");
				$("body").removeClass("on-side");
			});



			// ------------------------------------------------------------------------------ //
			// Wrapper
			// ------------------------------------------------------------------------------ //
			// $("body").wrapInner( "<div class='wrapper'></div>");
		},


		// ------------------------------------------------------------------------------ //
		// Change dropdown to hover on dekstop
		// ------------------------------------------------------------------------------ //
		hoverDropdown : function() {
			var getNav = $("nav.navbar.bootsnav"),
				getWindow = $(window).width(),
				getHeight = $(window).height(),
				getIn = getNav.find("ul.nav").data("in"),
				getOut = getNav.find("ul.nav").data("out");

			if( getWindow < 981 ){

				// Height of scroll navigation sidebar
				$(".scroller").css("height", "auto");

				// Disable mouseenter event
				$("nav.navbar.bootsnav ul.nav").find("li.dropdown").off("mouseenter");
				$("nav.navbar.bootsnav ul.nav").find("li.dropdown").off("mouseleave");
				$("nav.navbar.bootsnav ul.nav").find(".title").off("mouseenter");
				$("nav.navbar.bootsnav ul.nav").off("mouseleave");
				$(".navbar-collapse").removeClass("animated");

				// Enable click event
				$("nav.navbar.bootsnav ul.nav").each(function(){
					$(".dropdown-menu", this).addClass("animated");
					$(".dropdown-menu", this).removeClass(getOut);

					// Dropdown Fade Toggle
					$("a.dropdown-toggle", this).off('click');
					$("a.dropdown-toggle", this).on('click', function (e) {
						e.stopPropagation();
						$(this).closest("li.dropdown").find(".dropdown-menu").first().stop().fadeToggle().toggleClass(getIn);
						$(this).closest("li.dropdown").first().toggleClass("on");
						return false;
					});

					// Hidden dropdown action
					$('li.dropdown', this).each(function () {
						$(this).find(".dropdown-menu").stop().fadeOut();
						$(this).on('hidden.bs.dropdown', function () {
							$(this).find(".dropdown-menu").stop().fadeOut();
						});
						return false;
					});

					// Megamenu style
					$(".megamenu-fw", this).each(function(){
						$(".col-menu", this).each(function(){
							$(".content", this).addClass("animated");
							$(".content", this).stop().fadeOut();
							$(".title", this).off("click");
							$(".title", this).on("click", function(){
								$(this).closest(".col-menu").find(".content").stop().fadeToggle().addClass(getIn);
								$(this).closest(".col-menu").toggleClass("on");
								return false;
							});

							$(".content", this).on("click", function(e){
								e.stopPropagation();
							});
						});
					});
				});

				// Hidden dropdown
				var cleanOpen = function(){
					$('li.dropdown', this).removeClass("on");
					$(".dropdown-menu", this).stop().fadeOut();
					$(".dropdown-menu", this).removeClass(getIn);
					$(".col-menu", this).removeClass("on");
					$(".col-menu .content", this).stop().fadeOut();
					$(".col-menu .content", this).removeClass(getIn);
				}

				// Hidden om mouse leave
				$("nav.navbar.bootsnav").on("mouseleave", function(){
					cleanOpen();
				});

				// Enable click atribute navigation
				$("nav.navbar.bootsnav .attr-nav").each(function(){
					$(".dropdown-menu", this).removeClass("animated");
					$("li.dropdown", this).off("mouseenter");
					$("li.dropdown", this).off("mouseleave");
					$("a.dropdown-toggle", this).off('click');
					$("a.dropdown-toggle", this).on('click', function (e) {
						e.stopPropagation();
						$(this).closest("li.dropdown").find(".dropdown-menu").first().stop().fadeToggle();
						$(".navbar-toggle").each(function(){
							$(".fa", this).removeClass("fa-times");
							$(".fa", this).addClass("fa-bars");
							$(".navbar-collapse").removeClass("in");
							$(".navbar-collapse").removeClass("on");
						});
					});

					$(this).on("mouseleave", function(){
						$(".dropdown-menu", this).stop().fadeOut();
						$("li.dropdown", this).removeClass("on");
						return false;
					});
				});

				// Toggle Bars
				$(".navbar-toggle").each(function(){
					$(this).off("click");
					$(this).on("click", function(){
						$(".fa", this).toggleClass("fa-bars");
						$(".fa", this).toggleClass("fa-times");
						cleanOpen();
					});
				});

			}else if( getWindow > 981 ){
				// Height of scroll navigation sidebar
				$(".scroller").css("height", getHeight + "px");

				// Navbar Sidebar
				if( getNav.hasClass("navbar-sidebar")){
					// Hover effect Sidebar Menu
					$("nav.navbar.bootsnav ul.nav").each(function(){
						$("a.dropdown-toggle", this).off('click');
						$("a.dropdown-toggle", this).on('click', function (e) {
							e.stopPropagation();
						});

						$(".dropdown-menu", this).addClass("animated");
						$("li.dropdown", this).on("mouseenter", function(){
							$(".dropdown-menu", this).eq(0).removeClass(getOut);
							$(".dropdown-menu", this).eq(0).stop().fadeIn().addClass(getIn);
							$(this).addClass("on");
							return false;
						});

						$(".col-menu").each(function(){
							$(".content", this).addClass("animated");
							$(".title", this).on("mouseenter", function(){
								$(this).closest(".col-menu").find(".content").stop().fadeIn().addClass(getIn);
								$(this).closest(".col-menu").addClass("on");
								return false;
							});
						});

						$(this).on("mouseleave", function(){
							$(".dropdown-menu", this).stop().removeClass(getIn);
							$(".dropdown-menu", this).stop().addClass(getOut).fadeOut();
							$(".col-menu", this).find(".content").stop().fadeOut().removeClass(getIn);
							$(".col-menu", this).removeClass("on");
							$("li.dropdown", this).removeClass("on");
							return false;
						});
					});
				}else{
					// Hover effect Default Menu
					$("nav.navbar.bootsnav ul.nav").each(function(){
						$("a.dropdown-toggle", this).off('click');
						$("a.dropdown-toggle", this).on('click', function (e) {
							e.stopPropagation();
						});

						$(".megamenu-fw", this).each(function(){
							$(".title", this).off("click");
							$("a.dropdown-toggle", this).off("click");
							$(".content").removeClass("animated");
						});

						$(".dropdown-menu", this).addClass("animated");
						$("li.dropdown", this).on("mouseenter", function(){
							$(".dropdown-menu", this).eq(0).removeClass(getOut);
							$(".dropdown-menu", this).eq(0).stop().fadeIn().addClass(getIn);
							$(this).addClass("on");
							return false;
						});

						$("li.dropdown", this).on("mouseleave", function(){
							$(".dropdown-menu", this).eq(0).removeClass(getIn);
							$(".dropdown-menu", this).eq(0).stop().fadeOut().addClass(getOut);
							$(this).removeClass("on");
						});

						$(this).on("mouseleave", function(){
							$(".dropdown-menu", this).removeClass(getIn);
							$(".dropdown-menu", this).eq(0).stop().fadeOut().addClass(getOut);
							$("li.dropdown", this).removeClass("on");
							return false;
						});
					});
				}

				// ------------------------------------------------------------------------------ //
				// Hover effect Atribute Navigation
				// ------------------------------------------------------------------------------ //
				$("nav.navbar.bootsnav .attr-nav").each(function(){
					$("a.dropdown-toggle", this).off('click');
					$("a.dropdown-toggle", this).on('click', function (e) {
						e.stopPropagation();
					});

					$(".dropdown-menu", this).addClass("animated");
					$("li.dropdown", this).on("mouseenter", function(){
						$(".dropdown-menu", this).eq(0).removeClass(getOut);
						$(".dropdown-menu", this).eq(0).stop().fadeIn().addClass(getIn);
						$(this).addClass("on");
						return false;
					});

					$("li.dropdown", this).on("mouseleave", function(){
						$(".dropdown-menu", this).eq(0).removeClass(getIn);
						$(".dropdown-menu", this).eq(0).stop().fadeOut().addClass(getOut);
						$(this).removeClass("on");
					});

					$(this).on("mouseleave", function(){
						$(".dropdown-menu", this).removeClass(getIn);
						$(".dropdown-menu", this).eq(0).stop().fadeOut().addClass(getOut);
						$("li.dropdown", this).removeClass("on");
						return false;
					});
				});
			}

			// ------------------------------------------------------------------------------ //
			// Menu Fullscreen
			// ------------------------------------------------------------------------------ //
			if( getNav.hasClass("navbar-full")){
				var windowHeight = $(window).height(),
					windowWidth =  $(window).width();

				$(".nav-full").css("height", windowHeight + "px");
				$(".wrap-full-menu").css("height", windowHeight + "px");
				$(".wrap-full-menu").css("width", windowWidth + "px");

				$(".navbar-collapse").addClass("animated");
				$(".navbar-toggle").each(function(){
					var getId = $(this).data("target");
					$(this).off("click");
					$(this).on("click", function(e){
						e.preventDefault();
						$(getId).removeClass(getOut);
						$(getId).addClass("in");
						$(getId).addClass(getIn);
						return false;
					});

					$("li.close-full-menu").on("click", function(e){
						e.preventDefault();
						$(getId).addClass(getOut);
						setTimeout(function(){
							$(getId).removeClass("in");
							$(getId).removeClass(getIn);
						}, 500);
						return false;
					});
				});
			}
		},

		// ------------------------------------------------------------------------------ //
		// Navbar Sticky
		// ------------------------------------------------------------------------------ //
		navbarSticky : function(){
			var getNav = $("nav.navbar.bootsnav"),
				navSticky = getNav.hasClass("navbar-sticky");

			if( navSticky ){

				// Set Height Navigation
				var getHeight = getNav.height();
				$(".wrap-sticky").height(getHeight);

				// Windown on scroll
				var getOffset = $(".wrap-sticky").offset().top;
				$(window).on("scroll", function(){
					var scrollTop = $(window).scrollTop();
					if(scrollTop > getOffset){
						getNav.addClass("sticked");
					}else {
						getNav.removeClass("sticked");
					}
				});
			}
		},

		// ------------------------------------------------------------------------------ //
		// Navbar Scrollspy
		// ------------------------------------------------------------------------------ //
		navbarScrollspy : function(){
			var navScrollSpy = $(".navbar-scrollspy"),
				$body   = $('body'),
				getNav = $('nav.navbar.bootsnav'),
				offset  = getNav.outerHeight();

			if( navScrollSpy.length ){
				$body.scrollspy({target: '.navbar', offset: offset });

				// Animation Scrollspy
				$('.scroll').on('click', function(event) {
					event.preventDefault();

					// Active link
					$('.scroll').removeClass("active");
					$(this).addClass("active");

					// Remove navbar collapse
					$(".navbar-collapse").removeClass("in");

					// Toggle Bars
					$(".navbar-toggle").each(function(){
						$(".fa", this).removeClass("fa-times");
						$(".fa", this).addClass("fa-bars");
					});

					// Scroll
					var scrollTop = $(window).scrollTop(),
						$anchor = $(this).find('a'),
						$section = $($anchor.attr('href')).offset().top,
						$window = $(window).width(),
						$minusDesktop = getNav.data("minus-value-desktop"),
						$minusMobile = getNav.data("minus-value-mobile"),
						$speed = getNav.data("speed");

					if( $window > 992 ){
						var $position = $section - $minusDesktop;
					}else{
						var $position = $section - $minusMobile;
					}

					$('html, body').stop().animate({
						scrollTop: $position
					}, $speed);
				});

				// Activate Navigation
				var fixSpy = function() {
					var data = $body.data('bs.scrollspy');
					if (data) {
						offset = getNav.outerHeight();
						data.options.offset = offset;
						$body.data('bs.scrollspy', data);
						$body.scrollspy('refresh');
					}
				}

				// Activate Navigation on resize
				var resizeTimer;
				$(window).on('resize', function() {
					clearTimeout(resizeTimer);
					var resizeTimer = setTimeout(fixSpy, 200);
				});
			}
		}
	},
	components: {
		SignUp,
		PwForgot
	}
}
</script>
