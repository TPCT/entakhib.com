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
    <link
            href="{{asset('/css/bootstrap/bootstrap.min.css')}}"
            type="text/css"
            rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset('/css/styles.css')}}"/>
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}"/>
</head>

<body class="arabic-version coming-soon">
    <div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center">
        <img class="coming-soon-logo" src="{{asset('/storage/' . \Awcodes\Curator\Models\Media::find(app(\App\Settings\Site::class)->logo[app()->getLocale()])?->path)}}">
        <h2 class="coming-soon-header mt-5">
            @lang('site.Coming Soon')
        </h2>
        <p class="coming-soon-paragraph mt-3">
            @lang('site.Coming Soon Paragraph')
        </p>
    </div>
</body>
</html>
