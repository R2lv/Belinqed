<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;
use App\Match;
use App\Resume;
use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index(){

    }

    public function getLocale(){
        return $this->success(app()->getLocale());
    }

    public function setLocale(Request $request){
        $cookie = cookie('lang', $request->get('locale'), 2000000, null, null, false, false);
        app()->setLocale($request->getLocale());
        return $this->success(true);
    }


    public function homeStats(){

        $candidate_profiles = User::all()->count();
        $company_profiles = Company::all()->count();
        $total_jobs = Job::all()->count();
        $matches = Match::all()->count();
        $waiting = Resume::query()->where('looking_for_job',1)->count();
        $video = setting('site.home_page_video');
        $title = setting('site.home_page_welcome_text_'.app()->getLocale());
        $sub_title = setting('site.home_page_welcome_sub_text_'.app()->getLocale());
        $banner = setting('site.banner_background');



        $result = [
            'candidate_profiles'=>$candidate_profiles,
            'company_profiles'=>$company_profiles,
            'total_jobs'=>$total_jobs,
            'matches'=>$matches,
            'waiting'=>$waiting,
            'video'=>$video,
            'welcome_title'=>$title,
            'welcome_sub_title'=>$sub_title,
            'banner'=>$banner
        ];

        return $this->success($result);


    }

    public function footerInfo(){
        $about =  setting('footer.footer_about_company_'.app()->getLocale());
        $fb = setting('footer.footer_fb_url');
        $twitter = setting('footer.footer_twitter_url');
        $linkedin = setting('footer.footer_linkedin_url');
        $instagram = setting('footer.footer_instagram_url');

        $result = [
            'about'=>$about,
            'fb'=>$fb,
            'twitter'=>$twitter,
            'linkedin'=>$linkedin,
            'instagram'=>$instagram
        ];

        return $this->success($result);


    }
}
