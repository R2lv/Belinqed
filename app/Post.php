<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $appends = ['date','title','body','excerpt'];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function author(){
        return $this->belongsTo(User::class,'author_id','id')->select(['name','surname','id']);
    }

    public function getDateAttribute(){
        return \DateTime::createFromFormat('Y-m-d H:i:s',$this->created_at)->format('d-m-Y');
    }

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }

    public function getBodyAttribute(){
        return $this->{'body_'.app()->getLocale()};
    }

    public function getExcerptAttribute(){
        return $this->{'excerpt_'.app()->getLocale()};
    }


}
