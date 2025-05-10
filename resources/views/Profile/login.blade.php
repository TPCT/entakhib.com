@extends('layouts.main')

@section('title', __('site.Login'))
@section('id', 'Application')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/Application.css')}}"/>
@endpush

@section('content')
    <section>

        <div class="container login-form">

            <form method="post">
                @csrf

                <div class="container form-topic">
                    <h2 class="text-center">@lang('site.Login')</h2>
                </div>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">

                    <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                        <label for="phone">@lang('site.Phone')</label>
                        <div class="input-group has-validation">
                            <input
                                    name="phone_number"
                                    id="phone"
                                    type="text"
                                    placeholder="@lang('site.PHONE_NUMBER_PLACEHOLDER')"
                                    class="form-control m-0 @error('phone_number') is-invalid @enderror"
                                    value="{{old('phone_number')}}"
                            >
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                </div>


                @if (app(\App\Settings\Site::class)->enable_captcha)
                    <div class="col-12 w-100 px-2 px-sm-4 px-lg-3 mt-3">
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

                <button type="submit" class="main-btn mt-4">@lang('site.Login')</button>

                <div class="mt-3">
                    <a href="{{route('profile.register')}}">@lang("site.Don't have an account ?")</a>
                </div>
            </form>

        </div>
    </section>
@endsection