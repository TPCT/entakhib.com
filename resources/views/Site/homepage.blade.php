@extends('layouts.main')

@section('title', '')

@section('id', 'Home')
@push('style')
    <link rel="stylesheet" href="{{asset('/css/home.css')}}">
@endpush

@section('content')
    <section class="home-slider1-section">
        <x-layout.banner :slider="$banner" :promotion="true"></x-layout.banner>

        <div class="form-container p-3 position-relative z-3 rounded-3 home-1st-form-box">
            <form
                    action=""
                    class="p-0 border-0 d-flex align-items-center justify-content-center gap-4"
            >
                <h5>@lang('site.Vote For Your Candidate'): </h5>
                <div class="form-check h-100">
                    <input
                            class="form-check-input"
                            type="radio"
                            id="parties"
                            checked
                    />
                    <label class="form-check-label" for="parties">
                        @lang('site.Parties')
                    </label>
                </div>
                <div class="form-check">
                    <input
                            class="form-check-input"
                            type="radio"
                            id="clusters"
                    />
                    <label class="form-check-label" for="clusters">
                        @lang('site.Clusters')
                    </label>
                </div>

                <button type="submit" class="secondary-btn" id="voting-button">

                    @lang('site.Vote')

                    <svg
                            width="21"
                            height="21"
                            viewBox="0 0 21 21"
                            xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                                d="M19.2498 9.62501H3.86206L8.49344 4.99363C8.57701 4.91292 8.64367 4.81637 8.68953 4.70961C8.73539 4.60286 8.75952 4.48804 8.76053 4.37186C8.76154 4.25568 8.7394 4.14046 8.69541 4.03293C8.65141 3.92539 8.58644 3.8277 8.50428 3.74554C8.42213 3.66338 8.32443 3.59841 8.2169 3.55442C8.10936 3.51042 7.99414 3.48828 7.87796 3.48929C7.76178 3.4903 7.64696 3.51444 7.54021 3.5603C7.43346 3.60615 7.3369 3.67281 7.25619 3.75639L1.13119 9.88138C0.967151 10.0455 0.875 10.268 0.875 10.5C0.875 10.732 0.967151 10.9545 1.13119 11.1186L7.25619 17.2436C7.42122 17.403 7.64224 17.4912 7.87166 17.4892C8.10109 17.4872 8.32055 17.3952 8.48278 17.233C8.64501 17.0707 8.73703 16.8513 8.73903 16.6219C8.74102 16.3924 8.65283 16.1714 8.49344 16.0064L3.86206 11.375H19.2498C19.4819 11.375 19.7044 11.2828 19.8685 11.1187C20.0326 10.9546 20.1248 10.7321 20.1248 10.5C20.1248 10.2679 20.0326 10.0454 19.8685 9.88129C19.7044 9.7172 19.4819 9.62501 19.2498 9.62501Z"
                        />
                    </svg>
                </button>

            </form>
        </div>
    </section>

    <section class="container main-section-chart">
        <h2>@lang('site.Homepage Voting Percentages')</h2>

        <div class="home-chart-main-container">
            <div class="home-single-chart">
                <canvas id="barChartGreen"></canvas>
                <h3>@lang('site.Homepage Parties Votes Percentage')</h3>
            </div>
            <div class="home-single-chart">
                <canvas id="barChartRed"></canvas>
                <h3>@lang('site.Homepage Clusters Votes Percentage')</h3>
            </div>
        </div>
    </section>

    @if ($news->count())
        <div class="last-news mt-5">
            <div class="container">
                <div class="head d-flex align-items-center justify-content-between">
                    <h2>@lang('site.Latest News')</h2>
                    <a href="{{route('news.index')}}" class="d-flex align-items-center gap-3">
                        @lang('site.View All')
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="d-flex flex-column gap-4">
                            @if($news_image?->image_id)
                                <li class="homepage-news-banner-image">
                                    <x-curator-glider
                                            :media="$news_image?->image_id"
                                    />
                                </li>
                            @endif
                            @foreach($news as $news_piece)
                                <li>
                                    <a class="text-dark" href="{{route('news.show', ['news' => $news_piece])}}">
                                        {{$news_piece->title}}
                                    </a>
                                </li>
                                <hr/>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <x-layout.banner :slider="$news_banner"></x-layout.banner>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($candidates->count())
        <div class="candidates mt-5 py-5">
            <div class="container">
                <div class="head text-center mb-5">
                    <h2>@lang('site.Candidates')</h2>
                </div>
                <div class="swiper mySwiperOne">
                    <div class="swiper-wrapper">
                        @foreach($candidates as $candidate)
                            <div class="swiper-slide border rounded-3">
                                <div
                                        class="box d-flex flex-column align-items-start align-items-md-center flex-md-row gap-3 w-100"
                                >
                                    <picture class="last-slider-img">
                                        <x-curator-glider
                                            :media="$candidate->image_id"
                                        />
                                    </picture>
                                    <div class="content d-flex flex-column gap-3">
                                        <ul class="text-end d-flex flex-column gap-2">
                                            <li >{{$candidate->title}}</li>
                                            @if ($candidate->cluster)
                                                <li >{{$candidate->cluster->district->title}}</li>
                                                <li>{{$candidate->cluster->title}}</li>
                                            @else
                                                <li>{{$candidate->party?->title}}</li>
                                            @endif
                                        </ul>
                                        <a
                                                href="{{route('candidates.show', ['candidate' => $candidate])}}"
                                                class="btn d-flex align-items-center justify-content-center gap-2 py-2"
                                        >
                                            @lang('site.Program')

                                            <i class="fa-solid fa-arrow-left-long pt-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        $(function (){
            $("#parties, #clusters").on('click', function(){
                $("#parties, #clusters").prop('checked', false);
                $(this).prop('checked', true);
            })
            $("#voting-button").on('click', function (e){
                e.preventDefault();
                if ($("#parties").prop('checked'))
                    window.location.href = "{{route('parties.index')}}";
                else
                    window.location.href = "{{route('clusters.index')}}";
            })
        })
        var ctxBarRed = document.getElementById("barChartRed").getContext("2d");
        const gradientBgRed = ctxBarRed.createLinearGradient(0, 0, 0, 350);
        gradientBgRed.addColorStop(0, "#983030");
        gradientBgRed.addColorStop(1, "#BD3939");
        var barChartRed = new Chart(ctxBarRed, {
            type: "bar",
            data: {
                labels: JSON.parse(`@json(array_keys($city_votes))`),
                datasets: [
                    {
                        label: decodeHtmlEntity("{!! __("site.percentage of votes") !!}"),
                        data: {!! json_encode(array_values($city_votes)) !!},
                        backgroundColor: gradientBgRed,
                        borderRadius: 10,
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                maintainAspectRatio: true,
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                        rtl: true,
                        position: "bottom",
                        labels: {
                            usePointStyle: true,
                            pointStyle: "circle",
                            padding: 35,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },

                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return value + "%";
                            },
                            max: 100,
                            min: 0,
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
            },
        });

        var ctxBarGreen = document
            .getElementById("barChartGreen")
            .getContext("2d");
        const gradientBg = ctxBarGreen.createLinearGradient(0, 0, 0, 350);

        gradientBg.addColorStop(0, "#11351D");
        gradientBg.addColorStop(1, "#091E10");

        var barChartRed = new Chart(ctxBarGreen, {
            type: "bar",
            data: {
                labels: JSON.parse(`@json(array_keys($parties_votes))`),

                datasets: [
                    {
                        label: decodeHtmlEntity("{!! __("site.percentage of votes") !!}"),
                        data: {!! json_encode(array_values($parties_votes)) !!},
                        backgroundColor: gradientBg,
                        borderRadius: 10,
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                maintainAspectRatio: true,
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                        rtl: true,
                        position: "bottom",
                        labels: {
                            usePointStyle: true,
                            pointStyle: "circle",
                            padding: 35,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return value + "%";
                            },
                            max: 100,
                            min: 0,
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
            },
        });

        var swiper = new Swiper(".mySwiperOne", {
            slidesPerView: 3,
            spaceBetween: 25,
            loop: true,
            centerSlide: "true",
            fade: "true",
            autoplay: {
                delay: 5000, // set the delay in milliseconds
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                // dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                520: {
                    slidesPerView: 1,
                },
                950: {
                    slidesPerView: 2,
                },
            },
        });
    </script>
@endpush