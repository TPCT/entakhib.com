@extends('layouts.main')

@section('title', __('site.Register'))
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
                    <h2 class="text-center">@lang('site.Register')</h2>
                </div>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">

                    <div class="row w-100 px-0 g-4 pt-3 pb-2">
                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="full-name">@lang('site.Full Name')*</label>
                            <div class="input-group has-validation">
                                <input
                                        class="form-control m-0 @error('full_name') is-invalid @enderror"
                                        type="text"
                                        name="full_name"
                                        id="full-name"
                                        value="{{old('full_name')}}"
                                        placeholder="@lang('site.Full Name')"
                                >
                                @error('full_name')
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


                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="date-of-birth">@lang('site.Date Of Birth')*</label>
                            <div class="input-group has-validation">
                                <input
                                        name="date_of_birth"
                                        id="date-of-birth"
                                        type="text"
                                        placeholder="@lang('site.DATE_OF_BIRTH')"
                                        class="form-control m-0 @error('date_of_birth') is-invalid @enderror"
                                        value="{{old('date_of_birth')}}"
                                >
                                @error('date_of_birth')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row w-100 px-0 g-4 pt-3 pb-2">
                    <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                        <label for="place-of-residence">@lang('site.City')*</label>
                        <div class="input-group has-validation has-arrow">
                            <select name="city_id" id="city_id" class="w-100">
                                <option value="" selected disabled>
                                    @lang('site.Choose City')
                                </option>
                                @foreach(\App\Models\City\City::get() as $city)
                                    <option value="{{$city->id}}" @selected(old('city_id') == $city->id)>{{$city->title}}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                        <label for="district">@lang('site.District')*</label>
                        <div class="input-group has-validation has-arrow">
                            <select name="district_id" id="district_id" class="w-100">
                                <option value="" selected disabled>
                                    @lang('site.Choose District')
                                </option>
                                @foreach(\App\Models\City\City::find(old('city_id'))?->districts ?? [] as $district)
                                    <option value="{{$district->id}}" @selected(old('district_id') == $district->id)>{{$district->title}}</option>
                                @endforeach
                            </select>

                            @error('district_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                        <label for="email">@lang('site.Email')</label>
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

                <div class="d-flex flex-column has-validation input-group mt-3">
                    <div class="d-flex custom-gap gap-3">
                        <div class="w-auto">
                            <input
                                    name="agreement"
                                    id="agreement"
                                    type="checkbox"
                                    class="form-check m-0 @error('agreement') is-invalid @enderror"
                                    @checked(old('agreement', false))
                            >
                        </div>
                        <label for="agreement" class="mb-0 text-dark">@lang('site.I Agree') <a class="agreement-link" href="/privacy-policy">@lang('site.Privacy Policy') </a> | <a class="agreement-link" href="/terms-and-conditions">@lang('site.Terms And Conditions')</a> </label>
                    </div>
                    @error('agreement')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
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

                <button type="submit" class="main-btn mt-4">@lang('site.Register')</button>

                <div class="mt-3">
                    <a href="{{route('profile.login')}}">@lang("site.Already has An Account ?")</a>
                </div>
            </form>

        </div>
    </section>
@endsection

@push('script')
    <script>
        $(function(){
            $("#date-of-birth").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange:"-100:+100",
                dateFormat: "yy-mm-dd",
                maxDate: new Date({{\Carbon\Carbon::today()->subYears(18)->year}}, {{\Carbon\Carbon::today()->subYears(18)->month, \Carbon\Carbon::today()->subYears(18)->day}})
            })
            $("#city_id").on('change', function(){
                $.ajax({
                    url: "{{route('api.districts', ['city' => "DUMMY"])}}".replace('DUMMY', $(this).val()),
                    dataType: 'json',
                    success: function (response){
                        $("#district_id").find('option').remove();
                        if ($(response).length){
                            $("#district_id").append((`<option value="" selected>@lang('site.Choose District')</option>`))
                            $.each(response, function (key, title){
                                const option = (`
                                <option value="${key}">${title}</option>
                            `)
                                $("#district_id").append(option)
                            });
                        }
                    }
                });
            })
        })
    </script>
@endpush