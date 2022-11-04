@component('mail::message')


# @lang('email.hello',['name'=>$name])

@lang('email.verified',['mail'=>$email])

<hr>


<a href="{{$website}}"><img src="{{$website}}/img/logo.png" style="height: 40px;" alt=""></a><br>

<a href="{{ $website}}">{{ config('app.name') }}</a>

@endcomponent


