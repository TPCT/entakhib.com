<footer class="main-footer-container">
    <div class="container footer-section">
        <div class="footer-item footer-logo-container">
            <a href="">
                <picture>
                    <x-curator-glider
                            :media="app(\App\Settings\Site::class)->translate('footer_logo')"
                    />
                </picture>
            </a>
            {!! app(\App\Settings\Site::class)->footer_description[$language] !!}
        </div>
        @foreach($menu->links as $link)
            <div class="footer-item">
                <div class="footer-item-header">
                    <h5>{{$link->title}}</h5>
                    <button
                            class="toggleButton mobile-responsive"
                            data-target="about"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
                @if ($link->children)
                    <ul id="about">
                        @foreach($link->children as $child)
                            <li>
                                <a href="{{$child->link}}"> {{$child->title}} </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        @endforeach

        <div class="footer-item">
            <div class="footer-item-header">
                <h5>@lang('site.Contact Us')</h5>
                <button
                        class="toggleButton mobile-responsive"
                        data-target="about"
                >
                    <i class="fa-solid fa-plus"></i>
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>
            <ul id="about">
                <li><span>@lang('site.Phone'):</span><a dir="ltr" href="tel:{{app(\App\Settings\Site::class)->phone}}"> {{app(\App\Settings\Site::class)->phone}} </a></li>
                <li><span>@lang('site.Email'):</span><a href="mailto:{{app(\App\Settings\Site::class)->email}}"> {{app(\App\Settings\Site::class)->email}} </a></li>
                <div class="footer-social-media-container">
                    @if($facebook = app(\App\Settings\Site::class)->facebook_link)
                        <a href="{{$facebook}}" class="single-social-media">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @endif

                    @if($instagram = app(\App\Settings\Site::class)->instagram_link)
                            <a href="{{$instagram}}" class="single-social-media">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                    @endif

                    @if($twitter = app(\App\Settings\Site::class)->twitter_link)
                            <a href="{{$twitter}}" class="single-social-media">
                                <svg
                                        width="22"
                                        height="22"
                                        viewBox="0 0 22 22"
                                        xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0_192_4409)">
                                        <path
                                                d="M13.0478 9.3155L21.0617 0H19.1626L12.2042 8.08852L6.64648 0H0.236328L8.64066 12.2313L0.236328 22H2.13547L9.48378 13.4583L15.3531 22H21.7633L13.0473 9.3155H13.0478ZM10.4466 12.339L9.59511 11.1211L2.81976 1.42964H5.73673L11.2045 9.25094L12.0561 10.4689L19.1635 20.6354H16.2466L10.4466 12.3395V12.339Z"
                                                fill="white"
                                        />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_192_4409">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                    @endif

                    @if($youtube = app(\App\Settings\Site::class)->youtube_link)
                            <a href="{{$youtube}}" class="single-social-media">
                                <!-- <i class="fa-brands fa-youtube"></i> -->
                                <svg
                                        version="1.1"
                                        id="Capa_1"
                                ="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                x="0px"
                                y="0px"
                                viewBox="0 0 49 49"
                                style="enable-background: new 0 0 49 49"
                                xml:space="preserve"
                                >
                                <g>
                                    <g>
                                        <path
                                                d="M39.256,6.5H9.744C4.371,6.5,0,10.885,0,16.274v16.451c0,5.39,4.371,9.774,9.744,9.774h29.512
                   c5.373,0,9.744-4.385,9.744-9.774V16.274C49,10.885,44.629,6.5,39.256,6.5z M47,32.726c0,4.287-3.474,7.774-7.744,7.774H9.744
                   C5.474,40.5,2,37.012,2,32.726V16.274C2,11.988,5.474,8.5,9.744,8.5h29.512c4.27,0,7.744,3.488,7.744,7.774V32.726z"
                                        />
                                        <path
                                                d="M33.36,24.138l-13.855-8.115c-0.308-0.18-0.691-0.183-1.002-0.005S18,16.527,18,16.886v16.229
                   c0,0.358,0.192,0.69,0.502,0.868c0.154,0.088,0.326,0.132,0.498,0.132c0.175,0,0.349-0.046,0.505-0.137l13.855-8.113
                   c0.306-0.179,0.495-0.508,0.495-0.863S33.667,24.317,33.36,24.138z M20,31.37V18.63l10.876,6.371L20,31.37z"
                                        />
                                    </g>
                                </g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                </svg>
                    </a>
                    @endif
                </div>
            </ul>
        </div>
{{--        <div class="footer-item">--}}
{{--            @if (app(\App\Settings\Site::class)->app_store_link || app(\App\Settings\Site::class)->play_store_link || app(\App\Settings\Site::class)->app_gallery_link)--}}
{{--                <div class="footer-item-header">--}}
{{--                    <h5>@lang('site.Download App')</h5>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div class="footer-download-our-app">--}}
{{--                @if($app_store = app(\App\Settings\Site::class)->app_store_link)--}}
{{--                    <a href="{{$app_store}}">--}}
{{--                        <picture>--}}
{{--                            <img src="{{asset('/Assets/Download app icons/app-store.png')}}" alt="" />--}}
{{--                        </picture>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                @if($play_store = app(\App\Settings\Site::class)->play_store_link)--}}
{{--                    <a href="{{$play_store}}">--}}
{{--                        <picture>--}}
{{--                            <img src="{{asset('/Assets/Download app icons/google-play.png')}}" alt="" />--}}
{{--                        </picture>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--                @if($app_gallery = app(\App\Settings\Site::class)->app_gallery_link)--}}
{{--                    <a href="{{$app_gallery}}">--}}
{{--                        <picture>--}}
{{--                            <img src="{{asset('/Assets/Download app icons/app-gallery.png')}}" alt="" />--}}
{{--                        </picture>--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="container px-0"></div>
    </div>

    <div class="footer-copyright-container">
        <div class="footer-copyright-container-centered">
            <div class="">
                <p>@lang('Site.Developed By') <a href="http://dot.jo" target="_blank" rel="noopener noreferrer">@lang('site.DOTJO') </a> @lang('site.All Rights Reserved') © {{date('Y')}}</p>
            </div>
        </div>
    </div>
</footer>