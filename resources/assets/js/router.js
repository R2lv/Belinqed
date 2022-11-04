import VueRouter from "vue-router";

let HomePage = require("./pages/Home").default,
	ApplicantDashboard = require("./pages/ApplicantDashboard").default,
	CompanyDashboard = require("./pages/CompanyDashboard").default,
	ResumePage = require("./pages/Resume").default,
	ResumePublicPage = require("./pages/PublicResume").default,
	Error404Page = require("./pages/Error404").default,
	EditResumePage = require("./pages/EditResume").default,
	SearchJobsPage = require("./pages/SearchJobs").default,
	BlogPage = require("./pages/Blog").default,
	BlogPostPage = require("./pages/BlogPost").default,
	PricingPage = require("./pages/Pricing").default,
	CompanyDetailsPage = require("./pages/CompanyDetails").default,
	EditCompanyPage = require("./pages/EditCompany").default,
	CreateJobPage = require("./pages/CreateJob").default,
	JobDetailsPage = require("./pages/JobDetails").default,
	JobPublicDetailsPage = require("./pages/PublicJobDetails").default,
	EmailVerify = require("./pages/EmailVerify").default,
	PasswordReset = require("./pages/PasswordReset").default,
	EditJob = require("./pages/EditJob").default;

const routes = [];
const applicantRoutes = [];
const companyRoutes = [];

routes.push({
	path: '/reset/:is_company/:token',
	component: PasswordReset,
	meta: {
		auth_only: false
	}
});

routes.push({
	path: '',
	component: HomePage,
	meta: {
		auth_only: false
	}
});

applicantRoutes.push({
	path: 'dashboard',
	component: ApplicantDashboard,
	meta: {
		auth_only: true
	}
});
companyRoutes.push({
	path: 'dashboard',
	component: CompanyDashboard,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/verify/:id/:token/:type',
	component: EmailVerify,
	meta: {
		auth_only: false
	}
});

routes.push({
	path: '/resume',
	component: ResumePage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/resume/:resume_id/:job_id',
	component: ResumePublicPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/resume-edit',
	component: EditResumePage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/search-jobs',
	component: SearchJobsPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/blog',
	component: BlogPage,
	meta: {
		auth_only: false
	}
});

routes.push({
	path: '/blog/:id',
	component: BlogPostPage,
	meta: {
		auth_only: false
	}
});

routes.push({
	path: '/pricing',
	component: PricingPage,
	meta: {
		auth_only: false
	}
});

routes.push({
	path: '/company-details',
	component: CompanyDetailsPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/company-edit',
	component: EditCompanyPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/create-job',
	component: CreateJobPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/job/:id/edit',
	component: EditJob,
	meta: {
		auth_only: true
	}
});
routes.push({
	path: '/job/:id',
	component: JobDetailsPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '/job/:id/public',
	component: JobPublicDetailsPage,
	meta: {
		auth_only: true
	}
});

routes.push({
	path: '*',
	component: Error404Page,
	meta: {
		auth_only: false
	}
});

routes.push({
	component: {
		template: `<router-view />`
	},
	path: '/applicant',
	children: applicantRoutes,
	meta: {
		auth_only: true,
		applicant_only: true
	}
});
routes.push({
	component: {
		template: `<router-view />`
	},
	path: '/company',
	children: companyRoutes,
	meta: {
		auth_only: true,
		company_only: true
	}
});
let router = new VueRouter({
	mode: 'history',
	routes: routes,
	scrollBehavior (to, from, savedPosition) {
		return { x: 0, y: 0 }
	}
});

export default router;