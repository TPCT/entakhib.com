@extends('layouts.main')

@section('title', __("site.About Us"))
@section('id', 'About')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/About.css')}}">
@endpush
@section('content')
    <x-layout.header-image title="{{__('site.About Us')}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>

    @if(isset($about_us_section))
        <section>
            <div class="about-topic container">
                <h2>{{$about_us_section->title}}</h2>
            </div>
            <div class="container about-1st-container">
                {!! $about_us_section->description !!}
            </div>
        </section>
        <section>
            <div class="container about-2nd-container">
                @foreach($about_us_section->features as $feature)
                    <div class="about-card">
                        <picture>
                            <x-curator-glider
                                    :media="$feature->image_id"
                            />
                        </picture>
                        <div class="about-card-content">
                            <h2>{{$feature->title}}</h2>
                            {!! $feature->description !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

@endsection
