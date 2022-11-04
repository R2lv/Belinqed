<template>
<div>

	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url('/img/background-login-3.jpg'); background-position-y: -215px;">
		<div class="container">
			<h1>{{lang('blog_title')}}</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- All blog List Start -->
	<section class="section">
		<div class="container">
			<div class="row .no-mrg">
				<!-- Start Blogs -->
				<div class="col-md-8">

					<article class="blog-news" v-if="mdl.posts" v-for="post in mdl.posts">
						<div class="short-blog">
<!--							<figure class="img-holder">-->
<!--								<a :href="'/blog/'+post.slug"><img :src="site+'/storage/'+post.image" class="img-responsive" alt="News"></a>-->
<!--								<div class="blog-post-date">-->
<!--									{{ post.date }}-->
<!--								</div>-->
<!--							</figure>-->
							<div class="blog-content">
<!--								<div class="post-meta">By: <span class="author">{{ post.author.name[0] }}. {{ post.author.surname }}</span></div>-->
								<a :href="'/blog/'+post.slug"><h2 style="font-size: 25px !important;">{{ post.title }}</h2></a>
								<div class="blog-text">
									<p>{{ post.excerpt }}</p>
									<div class="post-meta">{{lang('blog_category')}}: <span class="category"><a :href="'/blog?category='+post.category.id">{{ post.category.name }}</a></span></div>
								</div>
							</div>
						</div>
					</article>
				</div>


				<!-- Sidebar Start -->
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
<!--								<a href="blog-details.html"><h4>{{ post.title }}</h4></a>-->
<!--								<div class="post-info">{{ post.date }}</div>-->
<!--							</div>-->
<!--						</div>-->
					</div>
				</div>
				<!-- End Sidebar Start -->
			</div>
			<!--<div class="row">-->
				<!--<ul class="pagination">-->
					<!--<li><a href="#">&laquo;</a></li>-->
					<!--<li class="active"><a href="#">1</a></li>-->
					<!--<li><a href="#">2</a></li>-->
					<!--<li><a href="#">3</a></li>-->
					<!--<li><a href="#">4</a></li>-->
					<!--<li><a href="#"><i class="fa fa-ellipsis-h"></i></a></li>-->
					<!--<li><a href="#">&raquo;</a></li>-->
				<!--</ul>-->
			<!--</div>-->
		</div>
	</section>
	<!-- All Blog List End -->
</div>
</template>

<script>
	export default {
		data() {
			return {
				// site:'https://dev.belinqed.com',
				site:'',
				mdl: {

					posts:[],
					lastPosts:{},
					categories:{}
				},
				resume_data: {},
				loading: true,
			}
		},
		created() {


			var urlParams = new URLSearchParams(window.location.search);
			var category_id = urlParams.get('category');
			if (!(category_id > 0)){
				category_id = ''
			}

			this.$store.dispatch("fetchBlog",{id: category_id})
					.then(res => {
						if(res.data.success) {
							this.mdl.posts = res.data.result;
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

	.short-blog {
		overflow: hidden;
	}

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


