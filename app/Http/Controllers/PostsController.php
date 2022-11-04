<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{


    public function index(Request $request){

        $posts = Post::query()->with(['category','author'])->where('status','PUBLISHED');

        if($request->get('category')) {

            $category = $request->get('category');

            $posts->whereHas('category',function($query) use ($category){
                $query->where('id',$category);
            });

        }


        return $this->success($posts->orderBy('created_at','desc')->get());

    }


    public function show($slug){
        $post = Post::query()->with(['category','author'])->where('status','PUBLISHED')->where('slug',$slug)->first();

        if ($post){
            return $this->success($post);
        }

        return $this->failure("Nothing was found");


    }


    public function lastPosts() {

        return $this->success(Post::query()->orderBy('id','desc')->limit(5)->get());

    }

    public function categories(){

        $categories = Category::query()->orderBy('order','asc')->get();

        return $this->success($categories);
    }
}
