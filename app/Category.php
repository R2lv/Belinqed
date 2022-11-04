<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $appends = ['postsCount','name'];

    public function posts(){
        return $this->hasMany(Post::class,'category_id');
    }

    public function getPostsCountAttribute(){
        return $this->posts()->count();
    }

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }


}
