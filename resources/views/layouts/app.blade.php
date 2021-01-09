<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Boilerplate</title>
    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    
    <meta name="apple-mobile-web-app-title" content="Boilerplate">
    <meta name="application-name" content="boilerplate">
    <meta name="msapplication-config" content="/favicon/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    {!! $ssrContent['head'] !!}


    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script>
        window.hasRecaptcha = false;
        window.recaptchaCallback = function() {
            window.hasRecaptcha = true;
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit" async defer></script>

    @yield('head')
</head>
<body>
<div id="app">
    {!! $ssrContent['body'] !!}
</div>
<script>
    window.CMSURI = "{{asset('')}}";
    window.dispatchError = function(){};
    window.recaptchaKey = "{{env('RECAPTCHA_PUBLIC_KEY')}}";
</script>
<script src="{{ asset(mix('js/manifest.js')) }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/entry-client.js') }}"></script>

</body>
</html>