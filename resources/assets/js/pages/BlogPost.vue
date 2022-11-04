<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url('/img/background-login-4.jpg'); background-position-y: -215px;">
		<div class="container">
			<h1>{{lang('blog_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Blog Detail -->
	<section class="section">
		<div class="container">
			<div class="row no-mrg">
				<div class="col-md-8">
					<article class="blog-news">
						<div class="full-blog">

<!--							<figure class="img-holder">-->
<!--								<a href="#"><img :src="site+'/storage/'+mdl.post.image" class="img-responsive" alt="News"></a>-->
<!--								<div class="blog-post-date">-->
<!--									{{ mdl.post.date }}-->
<!--								</div>-->
<!--							</figure>-->

							<div class="full blog-content">
<!--								<div class="post-meta">By: <span class="author">{{ mdl.post.author.name[0] }}. {{ mdl.post.author.surname }} </span>  </div>-->
								<a href="blog-detail.html"><h2>{{ mdl.post.title }}</h2></a>
								<div class="blog-text" v-html="mdl.post.body">
									{{ mdl.post.body }}
									<div class="post-meta">{{lang('blog_category')}}: <span class="category"><a href="#">{{ mdl.post.category.name }}</a></span></div>
								</div>
<!--								<div class="row no-mrg">-->
<!--									<div class="blog-footer-social">-->
<!--										<span>Share <i class="fa fa-share-alt"></i></span>-->
<!--										<ul class="list-inline social">-->
<!--											<li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
<!--											<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
<!--											<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
<!--											<li><a href="#"><i class="fa fa-pinterest"></i></a></li>-->
<!--										</ul>-->
<!--									</div>-->
<!--								</div>-->
							</div>

						</div>
					</article>
					<!--<div class="row no-mrg">-->
						<!--<div class="comments">-->
							<!--<div class="section-title2">-->
								<!--<h3>Comments (2)</h3>-->
							<!--</div>-->

							<!--<div class="single-comment">-->
								<!--<div class="img-holder">-->
									<!--<img src="/img/blog/1.jpg" class="img-responsive" alt="">-->
								<!--</div>-->
								<!--<div class="text-holder">-->
									<!--<div class="top">-->
										<!--<div class="name pull-left">-->
											<!--<h4>Robert Mil – Feb 07, 2017</h4>-->
										<!--</div>-->
										<!--<div class="rating pull-right">-->
											<!--<ul>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star"></i></li>-->
												<!--<li><i class="fa fa-star"></i></li>-->
											<!--</ul>-->
										<!--</div>-->
									<!--</div>-->
									<!--<div class="text">-->
										<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>-->
									<!--</div>-->
								<!--</div>-->
							<!--</div>-->
							<!--<div class="single-comment">-->
								<!--<div class="img-holder">-->
									<!--<img src="/img/blog/1.jpg" class="img-responsive" alt="">-->
								<!--</div>-->
								<!--<div class="text-holder">-->
									<!--<div class="top">-->
										<!--<div class="name pull-left">-->
											<!--<h4>Daniel Dax – Feb 10, 2017</h4>-->
										<!--</div>-->
										<!--<div class="rating pull-right">-->
											<!--<ul>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star active"></i></li>-->
												<!--<li><i class="fa fa-star"></i></li>-->
											<!--</ul>-->
										<!--</div>-->
									<!--</div>-->
									<!--<div class="text">-->
										<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>-->
									<!--</div>-->
								<!--</div>-->
							<!--</div>-->
						<!--</div>-->
					<!--</div>-->
					<!--<div class="row no-mrg">-->
						<!--<div class="comments-form">-->
							<!--<div class="section-title2">-->
								<!--<h3>Comments (2)</h3>-->
							<!--</div>-->
							<!--<form>-->
								<!--<div class="col-md-6 col-sm-6">-->
									<!--<input type="text" class="form-control" placeholder="Your Name">-->
								<!--</div>-->
								<!--<div class="col-md-6 col-sm-6">-->
									<!--<input type="email" class="form-control" placeholder="Your Email">-->
								<!--</div>-->
								<!--<div class="col-md-6 col-sm-6">-->
									<!--<input type="text" class="form-control" placeholder="Your Mobile">-->
								<!--</div>-->
								<!--<div class="col-md-6 col-sm-6">-->
									<!--<input type="text" class="form-control" placeholder="Subject">-->
								<!--</div>-->
								<!--<div class="col-md-12 col-sm-12">-->
									<!--<textarea class="form-control" placeholder="Comment"></textarea>-->
								<!--</div>-->
								<!--<button class="thm-btn btn-comment" type="submit">submit now</button>-->
							<!--</form>-->
						<!--</div>-->
					<!--</div>-->
				</div>

				<!-- Start Sidebar -->
				<div class="col-md-4">
					<div class="blog-sidebar">

						<!--<form action="#">-->
							<!--<div class="search-form">-->
								<!--<div class="input-group">-->
									<!--<input type="text" class="form-control" placeholder="Search…">-->
									<!--<span class="input-group-btn"><button type="button" class="btn btn-default">Go</button></span>-->
								<!--</div>-->
							<!--</div>-->
						<!--</form>-->

						<div class="sidebar-widget">
							<h4>{{lang('blog_categories')}}</h4>
							<ul class="sidebar-list">
								<li class="flex">
									<a class="category-titles" href="/blog">{{lang('blog_categories_all')}}</a>
									<a class="category-counts" href="/blog"><span> [{{categoriesPostsCount(mdl.categories)}}]</span></a>
								</li>
								<li class="flex" v-for="category in mdl.categories">
									<a class="category-titles" :href="'/blog?category='+category.id"> {{ category.name }} </a>

									<a class="category-counts" :href="'/blog?category='+category.id"><span> [{{ category.postsCount }}]</span></a>
								</li>
							</ul>
						</div>


						<!--						<div class="sidebar-widget">-->
<!--							<h4>Last Posts</h4>-->
<!--							<div class="blog-item" v-for="post in mdl.lastPosts ">-->
<!--								<div class="post-thumb"><a :href="'/blog/'+post.slug"><img :src="site+'/storage/'+post.image" class="img-responsive" alt=""></a></div>-->
<!--								<a><h4>{{ post.title }}</h4></a>-->
<!--								<div class="post-info">{{ post.date }}</div>-->
<!--							</div>-->
<!--						</div>-->


						<!--<div class="sidebar-widget">-->
							<!--<h4>Recent Category</h4>-->
							<!--<div class="blog-item">-->
								<!--<div class="post-thumb"><a href="blog-detail.html"><img src="/img/blog/1.jpg" class="img-responsive" alt=""></a></div>-->
								<!--<a href="blog-details.html"><h4>Enim Ad Minim Veniam, Quis Nostrud Exercitation</h4></a>-->
								<!--<div class="post-info">Aug 10 2016</div>-->
							<!--</div>-->
							<!--<div class="blog-item">-->
								<!--<div class="post-thumb"><a href="blog-detail.html"><img src="/img/blog/2.jpg" class="img-responsive" alt=""></a></div>-->
								<!--<a href="blog-details.html"><h4>Enim Ad Minim Veniam, Quis Nostrud Exercitation</h4></a>-->
								<!--<div class="post-info">Aug 10 2016</div>-->
							<!--</div><div class="blog-item">-->
							<!--<div class="post-thumb"><a href="blog-detail.html"><img src="/img/blog/3.jpg" class="img-responsive" alt=""></a></div>-->
							<!--<a href="blog-details.html"><h4>Enim Ad Minim Veniam, Quis Nostrud Exercitation</h4></a>-->
							<!--<div class="post-info">Aug 10 2016</div>-->
						<!--</div>-->


					<!--</div>-->
					</div>
				<!-- End Start Sidebar -->
				</div>
			</div>
		</div>
	</section>
	<!-- Blog Detail End -->
</div>
</template>
<script>
	export default {
		data() {
			return {
				// site:'https://dev.belinqed.com',
				site:'',
				mdl: {

					post:{
						category:{}
					},
					lastPosts:{},
					categories:{}
				},
				resume_data: {},
				loading: true,
			}
		},
		created() {


			this.$store.dispatch("fetchBlogPost", {id: this.$route.params.id})
				.then(res => {
					if(res.data.success) {
						this.mdl.post = res.data.result;

					} else {
						console.error(res.data.error);
					}
				});
			this.$store.dispatch('fetchBlogCategories')
				.then(res => {
					if(res.data.success) {
						this.mdl.categories = res.data.result;
						this.loading = false;
					}
				});

			this.$store.dispatch('fetchLastPosts')
				.then(res => {
					if(res.data.success) {
						this.mdl.lastPosts = res.data.result;
						this.loading = false;
					}
				});
		},
		mounted() {
			console.log("initial mounted");
			console.log(this.$route.params.id);
		},
		methods: {

			categoriesPostsCount(categories){
				var len=0;
				for (var i=0; i<categories.length; i++ ){
					len = len + categories[i].postsCount
				}

				return len;
			},
			call(){
				console.log("log");
			}
		}
	}
</script>

<style scoped>


	.blog-content {
		padding: 20px 25px !important;
	}
	h2 {
		margin: 0 !important;
	}

	.sidebar-widget {
		padding: 0 !important;
	}
	.sidebar-widget h4 {
		margin-top: 0 !important;
	}

	.category-titles {
		display: inline-block;
		width: 330px;
	}

	.category-counts {
		margin: auto;
	}

	@media screen and (max-width: 423px) {
		.category-titles {
			width: 250px !important;
		}
	}




</style>


