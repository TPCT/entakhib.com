@extends('layouts.main')

@section('title', __('site.Contact Us'))
@section('id', 'Contact-us')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/ContactUs.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image title="{{__('site.Contact Us')}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>

    <div class="container contactUs-1st-container">
        <div class="contactUs-greybox">
            <picture>
                <img src="{{asset('/Assets/Icons/phone-call 1.svg')}}" alt="" srcset="">
            </picture>
            <p>@lang('site.PHONE'): <a dir="ltr" href="tel:{{app(\App\Settings\Site::class)->phone}}">{{app(\App\Settings\Site::class)->phone}}</a></p>
        </div>
        <div class="contactUs-greybox">
            <picture>
                <img src="{{asset('/Assets/Icons/mail 1.svg')}}" alt="" srcset="">
            </picture>
            <p>@lang('site.EMAIL'): <a href="mailto:{{app(\App\Settings\Site::class)->email}}">{{app(\App\Settings\Site::class)->email}}</a></p>
        </div>
        <div class="contactUs-greybox">
            @if($youtube = app(\App\Settings\Site::class)->youtube_link)
                <a href="{{$youtube}}">
                    <picture>
                        <img src="{{asset('/Assets/Icons/youtube (1) 2.svg')}}" alt="" srcset="">
                    </picture>
                </a>
            @endif
            @if($twitter = app(\App\Settings\Site::class)->twitter_link)
                    <a href="{{$twitter}}">
                        <picture>
                            <img src="{{asset('/Assets/Icons/twitter.svg')}}" alt="" srcset="">
                        </picture>
                    </a>
            @endif
            @if($linked_in = app(\App\Settings\Site::class)->linkedin_link)
                    <a href="{{$linked_in}}">
                        <picture>
                            <img src="{{asset('/Assets/Icons/_x31_0.Linkedin.svg')}}" alt="" srcset="">
                        </picture>
                    </a>
            @endif
            @if($instagram = app(\App\Settings\Site::class)->instagram_link)
                <a href="{{$instagram}}">
                    <picture>
                        <img src="{{asset('/Assets/Icons/Group 234.svg')}}" alt="" srcset="">
                    </picture>
                </a>
            @endif

            @if($facebook = app(\App\Settings\Site::class)->facebook_link)
                <a href="">
                    <picture>
                        <img src="{{asset('/Assets/Icons/facebook-app-symbol.svg')}}" alt="" srcset="">
                    </picture>
                </a>
            @endif
        </div>
    </div>

    <section class="container d-flex flex-column align-content-center mb-3">
            @if($success_message = session('success'))
                <div class="d-flex justify-content-center w-100">
                <div class="my-3 alert alert-success w-100">
                        <span class="">{{$success_message}}</span>
                    </div>
                </div>
           @endif

        <div class="container ContactUs-form w-100">
            <form method="post" id="contact-us-form">
                @csrf
                <div class="container">
                    <h2>@lang('site.CONTACT_US_TITLE')</h2>
                </div>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">

                    <div class="row w-100 px-0 g-4 pt-3 pb-2">
                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="full-name">@lang('site.Full Name')*</label>
                            <div class="input-group has-validation">
                                <input
                                        class="form-control m-0 @error('name') is-invalid @enderror"
                                        type="text"
                                        name="name"
                                        id="full-name"
                                        value="{{old('name')}}"
                                        placeholder="@lang('site.Full Name')"
                                >
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="phone">@lang('site.Phone')*</label>
                            <div class="input-group has-validation">
                                <input
                                        name="phone"
                                        id="phone"
                                        type="text"
                                        placeholder="@lang('site.Phone')"
                                        class="form-control m-0 @error('phone') is-invalid @enderror"
                                        value="{{old('phone')}}"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="email">@lang('site.Email')*</label>
                            <div class="input-group has-validation">
                                <input
                                       name="email"
                                       id="email"
                                       type="email"
                                       placeholder="@lang('site.Email')"
                                       class="form-control m-0 @error('email') is-invalid @enderror"
                                       value="{{old('email')}}"
                                >
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row w-100 px-0 g-4 pt-3 pb-2">
                    <div class="col-12 d-flex flex-column custom-gap form-group">
                        <label for="message">@lang('site.Message')</label>
                        <div class="input-group has-validation">
                            <textarea
                                    name="message"
                                    id="message"
                                    class="form-control m-0 @error('message') is-invalid @enderror"
                            >{{old('message')}}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if (app(\App\Settings\Site::class)->enable_captcha)
                    <div class="col-12 w-100 px-2 px-sm-4 px-lg-3">
                        <div class="form-group">
                            {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                @endif

                <button type="submit" class="main-btn mt-4">@lang('site.Submit')</button>
            </form>

        </div>
    </section>
@endsection