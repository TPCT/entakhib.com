<html lang="{{app()->getLocale()}}">
<head>
    <title>
        @if (app(\App\Settings\General::class)->site_title)
            @hasSection('title')
                @yield('title') -
            @endif
            {{app(\App\Settings\General::class)->site_title[app()->getLocale()] ?? config('app.name')}}
        @endif
    </title>

    <link rel="icon" type="image/x-icon" href="{{asset('/storage/' . \Awcodes\Curator\Models\Media::find(app(\App\Settings\Site::class)->fav_icon)?->path)}}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <x-layout.seo></x-layout.seo>

    <link
        href="{{asset('/css/bootstrap/bootstrap.min.css')}}"
        type="text/css"
        rel="stylesheet"
    />

    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/js/slick-1.8.1/slick/slick.css')}}"
    />

    <link rel="stylesheet" href="{{asset('/css/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('/js/slick-1.8.1/slick/slick-theme.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/owl.carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/intlTelInput.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/fancybox.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/regular.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/solid.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/brands.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/Layout.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/menu.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/arabic-styles.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.css')}}" />

    <script src="{{asset('/js/wow.js')}}"></script>
    <script>
        new WOW().init();
    </script>

    @stack('style')

    <link rel="stylesheet" href="{{asset('/css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/accessibility-tools.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/errors.css')}}"/>
</head>

<body class="{{app()->getLocale() == "ar" ? "arabic-version" : ""}}">
    <x-layout.header></x-layout.header>

    <main id="@yield('id')" class="@yield('class')">
        <span id="readspeakerDiv">

            @yield('content')
        </span>
    </main>
    <x-layout.footer></x-layout.footer>

</body>

<script src="{{asset('/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('/js/chart.js')}}"></script>
<script src="{{asset('/js/fancybox.umd.js')}}"></script>
<script src="{{asset('/js/bootstrap/popper.min.js')}}"></script>

<script src="{{asset('/js/slick-1.8.1/slick/slick.min.js')}}"></script>
<script src="{{asset('/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/intlTelInput.min.js')}}"></script>

<script src="{{asset('/js/carousel.umd.js')}}"></script>
<script src="{{asset('/js/owl.carousel.js')}}"></script>
<script src="{{asset('/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>
<script src="{{asset('/js/menu.js')}}"></script>

<script src="{{asset('/js/accessibility-tools.js')}}"></script>
<script src="{{asset('/js/custom.js')}}"></script>
<script src="{{asset('/js/swiper.js')}}"></script>
<script src="{{asset('/js/popup.js')}}"></script>
<script src="{{asset('/js/jquery-ui.js')}}"></script>

{!! NoCaptcha::renderJs() !!}

<script>

    @if($voted = session('voted'))
        const myPopup = new Popup({
            id: "my-popup",
            title: `<div class='d-flex flex-column align-items-center'><img class='check' src='{{asset('/images/CheckCircle.svg')}}'/>@lang('site.Voted Successfully')`,
            content: ``,
            showImmediately: true
        });
    @endif

    @if ($message = session('message'))
        const myPopup1 = new Popup({
            id: "my-popup",
            title: `<div class='d-flex flex-column align-items-center'><img class='check' src='{{asset('/images/Vector.svg')}}'/>{{$message}}`,
            content: ``,
            showImmediately: true
        });
    @endif
</script>
@stack('script')
</html>
