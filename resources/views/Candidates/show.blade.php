@extends('layouts.main')

@section('title', $candidate->title)
@section('id', 'PersonalProfile')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/PersonalProfile.css')}}">
@endpush
@section('content')
    <section class="mt-3">
        <div class="container PersonalProfile-1st-container">
            <div class="candidate-info">
                <h3>{{$candidate->title}}</h3>
                @if ($candidate->cluster)
                    <h3>{{$candidate?->cluster->district?->title}}</h3>
                    <h3>{{$candidate?->cluster->title}}</h3>
                @else
                    <h3>{{$candidate?->party?->title}}</h3>
                @endif
                <h3>{{$candidate->slogan}}</h3>
                <x-layout.share></x-layout.share>
                @if($candidate->phone_1 || $candidate->phone_2 || $candidate->facebook_link || $candidate->twitter_link || $candidate->youtube_link || $candidate->instagram_link)
                    <h4>@lang('site.Contact Information'):</h4>
                    @if($candidate->phone_1 || $candidate->phone_2)
                        <div class="d-flex candidate-numbers-div">
                            <span>@lang('site.Contact Phone'):</span>
                            <div class="d-flex justify-content-between mx-2 candidate-numbers">
                                @if($candidate->phone_1)
                                    <div class="d-flex align-items-center">
                                        <a href="tel:{{$candidate->phone_1}}" class="PersonalProfile-phone px-1">{{$candidate->phone_1}}</a>
                                        <img src="{{asset('/images/Phone.png')}}"/>
                                    </div>
                                    @if ($candidate->phone_2)
                                        <span> | </span>
                                    @endif
                                @endif
                                @if($candidate->phone_2)
                                    <div class="d-flex align-items-center">
                                        <a href="tel:{{$candidate->phone_2}}" class="PersonalProfile-phone px-1">{{$candidate->phone_2}}</a>
                                        <img src="{{asset('/images/WhatsappLogo.png')}}"/>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="candidate-socialBox">
                        @if($candidate->facebook_link || $candidate->twitter_link || $candidate->youtube_link || $candidate->instagram_link)
                            <a href="{{$candidate->youtube_link}}">
                                <picture>
                                    <img
                                            src="{{asset('/Assets/Icons/youtube (1) 2.svg')}}"
                                            alt=""
                                            srcset=""
                                    />
                                </picture>
                            </a>
                            <a href="{{$candidate->twitter_link}}">
                                <picture>
                                    <img src="{{asset('/Assets/Icons/twitter.svg')}}" alt="" srcset="" />
                                </picture>
                            </a>
                            <a href="{{$candidate->instagram_link}}">
                                <picture>
                                    <img src="{{asset('/Assets/Icons/Group 234.svg')}}" alt="" srcset="" />
                                </picture>
                            </a>
                            <a href="{{$candidate->facebook_link}}">
                                <picture>
                                    <img
                                            src="{{asset('/Assets/Icons/facebook-app-symbol.svg')}}"
                                            alt=""
                                            srcset=""
                                    />
                                </picture>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <picture class="PersonalProfile-1st-container-mainpic">
                <x-curator-glider
                    :media="$candidate->image_id"
                >
                </x-curator-glider>
            </picture>
        </div>
    </section>
    <section>
        <div class="container PersonalProfile-2nd-container">
            @if($election_program_description = $candidate->election_program_description)
                <div class="PersonalProfile-2nd-container-card">
                    <div>
                        <h2>@lang('site.Election Program')</h2>
                        {!! $election_program_description !!}
                    </div>

                    @if ($candidate->pdf)
                        <a href="{{asset('/storage/' . $candidate->pdf)}}" class="main-btn"  target="_blank" rel="noopener" >@lang('site.Download PDF')</a>
                    @endif
                </div>
            @endif
            @if ($description = $candidate->description)
                    <div class="PersonalProfile-2nd-container-card">
                        <h2>@lang('site.Candidate Brief')</h2>
                        {!! $candidate->description !!}
                    </div>
            @endif

            @if ($candidate->election_location_description)
                    <div class="PersonalProfile-2nd-container-card">
                        <div>
                            <h2>@lang('site.Election Location Description')</h2>
                            {!! $candidate->election_location_description !!}
                        </div>
                        @if($candidate->election_location)
                            <a target="_blank" href="{{$candidate->election_location}}" class="main-btn d-flex align-items-center gap-2">
                                @lang('site.Direction')
                                <svg
                                        width="33"
                                        height="33"
                                        fill="white"
                                        viewBox="0 0 33 33"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0_229_6181)">
                                        <path
                                                d="M32.5101 15.3326L17.6601 0.482625C17.0166 -0.160875 15.9688 -0.160875 15.3336 0.482625L0.483601 15.3326C-0.159898 15.9761 -0.159898 17.0239 0.483601 17.6674L15.3336 32.5091V32.5174C15.9771 33.1609 17.0249 33.1609 17.6684 32.5174L32.5184 17.6674C33.1618 17.0156 33.1618 15.9761 32.5101 15.3326ZM19.7968 20.6208V16.4959H13.1968V21.4459H9.89679V14.8459C9.89679 13.9301 10.631 13.1959 11.5468 13.1959H19.7968V9.07087L25.5718 14.8459L19.7968 20.6208Z"
                                                fill="white"
                                        />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_229_6181">
                                            <rect width="33" height="33" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
        </div>
    </section>

    <section>
        <div class="VotingMechanism-container container mb-3">
            @if($candidate->images->count())
                <div class="VotingMechanism-grid-left">

                    @foreach($candidate->images as $image)
                        <x-curator-glider
                            :media="$image->id"
                        />
                    @endforeach
                </div>
            @endif

            @if($candidate->video_url)

                <div class="VotingMechanism-grid-right">
                    <iframe
                            width="560"
                            height="500"
                            src="{{$candidate->video_url}}"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                    ></iframe>
                </div>
            @endif
        </div>
    </section>
@endsection