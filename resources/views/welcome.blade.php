<!DOCTYPE html>
<html class="no-js" lang="ka">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Best Responsive job portal template build on Latest Bootstrap.">
    <meta name="keywords" content="job, nob board, job portal, job listing">
    <meta name="robots" content="index,follow">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>BelinQed</title>

{{--    <link rel="stylesheet" href="{{secure_asset('css/app.css')}}">--}}
    <link rel="stylesheet" href='/css/app.css'>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyDPGU9ztMbIl00z1nQtQfWGDXf3rrRDxy8&libraries=places"></script>
</head>
<body>
<div id="app"></div>
<script src="/js/app.js"></script>
</body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution="setup_tool"
     page_id="2041518886086908"
     theme_color="#36a8e0">
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68972886-10"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-68972886-10');
</script>

</html>