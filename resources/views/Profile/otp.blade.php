@extends('layouts.main')

@section('title', __('site.Otp'))
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
                    <h2 class="text-center">@lang('site.Please Enter Otp')</h2>
                </div>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">

                    <div class="row w-100 px-0 g-4 pt-3 pb-2">
                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="full-name">@lang('site.Otp')*</label>
                            <div class="input-group has-validation">
                                <input
                                        class="form-control m-0 @error('otp') is-invalid @enderror"
                                        type="text"
                                        name="otp"
                                        id="otp"
                                        value="{{old('otp')}}"
                                        placeholder="@lang('site.Otp')"
                                >
                                @error('otp')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
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

                <button type="submit" class="main-btn mt-4">@lang('site.Submit Otp')</button>
            </form>

        </div>
    </section>
@endsection