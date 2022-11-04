@component('mail::message')


# @lang('email.hello',['name'=>$name])

@lang('email.intro',['mail'=>$email])

@component('mail::button', ['url' => $url,'color' => 'blue'])
    @lang('email.verify')
@endcomponent

<hr>

{{ $url }}

@lang('email.info_why')


<a href="{{$website}}"><img src="{{$website}}/img/logo.png" style="height: 40px;" alt=""></a><br>

<a href="{{ $website}}">{{ config('app.name') }}</a>

@endcomponent


