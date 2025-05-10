@extends('layouts.main')

@section('title', __('site.Show Profile'))
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
                    <h2 class="text-center">@lang('site.Profile')</h2>
                </div>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">

                    <div class="row w-100 px-0 g-4 pt-3 pb-2">
                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="full-name">@lang('site.Full Name')</label>
                            <div class="input-group has-validation">
                                <input
                                        class="form-control m-0 @error('full_name') is-invalid @enderror"
                                        type="text"
                                        name="full_name"
                                        id="full-name"
                                        value="{{$user->full_name}}"
                                        placeholder="@lang('site.Full Name')"
                                        disabled
                                >
                                @error('full_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="phone">@lang('site.Phone')</label>
                            <div class="input-group has-validation">
                                <input
                                        name="phone_number"
                                        id="phone"
                                        type="text"
                                        placeholder="@lang('site.Phone')"
                                        class="form-control m-0 @error('phone_number') is-invalid @enderror"
                                        value="{{$user->phone_number}}"
                                        disabled
                                >
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                            <label for="date-of-birth">@lang('site.Date Of Birth')</label>
                            <div class="input-group has-validation">
                                <input
                                        name="date_of_birth"
                                        id="date-of-birth"
                                        type="text"
                                        placeholder="@lang('site.DATE_OF_BIRTH')"
                                        class="form-control m-0 @error('date_of_birth') is-invalid @enderror"
                                        value="{{$user->date_of_birth}}"
                                        disabled
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
                        <label for="place-of-residence">@lang('site.Place Of Residence')</label>
                        <div class="input-group has-validation">
                            <input
                                    name="place_of_residence"
                                    id="place-of-residence"
                                    type="text"
                                    placeholder="@lang('site.Please Of Residence')"
                                    class="form-control m-0 @error('place_of_residence') is-invalid @enderror"
                                    value="{{$user->city->title}}"
                                    disabled
                            >
                            @error('place_of_residence')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12 d-flex flex-column custom-gap form-group">
                        <label for="district">@lang('site.District')</label>
                        <div class="input-group has-validation">
                            <input
                                    name="district"
                                    id="district"
                                    type="text"
                                    placeholder="@lang('site.District')"
                                    class="form-control m-0 @error('district') is-invalid @enderror"
                                    value="{{$user->district->title}}"
                                    disabled
                            >
                            @error('district')
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
                                    value="{{$user->email}}"
                                    disabled
                            >
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-5 ">
                    <a href="{{route('profile.edit')}}" class="main-btn position-static mx-2 edit-button">@lang('site.Edit')</a>

                    <a href="{{route('profile.logout')}}" class="secondary-btn position-static text-danger">
                        <span class="text-danger">@lang('site.Logout')</span>
                    </a>

                </div>
            </form>

        </div>
    </section>
@endsection