@extends('layouts.main')

@section('title', $page->title)
@section('id', 'NewsInner')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/VotingMechanism.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image title="{{$page->title}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>
    <section class="voting-mechanism-opening">
        <div class="container">
            {!! $page->content !!}
        </div>
        <div class="VotingMechanism-container container mb-3">
            @if ($page->images?->count())
                <div class="VotingMechanism-grid-left">
                    @foreach($page->images as $image)
                        <picture>
                            <x-curator-glider
                                    :media="$image"
                            />
                        </picture>
                    @endforeach
                </div>
            @endif
            @if ($page->video_url)
                <div class="VotingMechanism-grid-right">
                    <iframe
                            width="560"
                            height="315"
                            src="{{$page->video_url}}"
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
