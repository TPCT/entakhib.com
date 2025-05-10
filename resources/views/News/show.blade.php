@extends('layouts.main')

@section('title', $news->title)
@section('id', 'NewsInner')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/NewsInner.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image title="{!! $news->title!!}" image="{{$news->image}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>
    <div class="container newsInner-content">
        <span>{{$news->publishedAt()}}</span>
        <div class="mt-3">
            {!! $news->description !!}
        </div>
        {!! $news->content !!}
    </div>
    <div class="container mb-4 mt-5 NewsInner-morenews">
        <h2>@lang('site.More News')</h2>
    </div>

    <div class="container NewsInner-container">
        @foreach($recent_news as $news)
            <div class="News-card">
                <picture>
                    <x-curator-glider
                        :media="$news->image_id"
                    />
                </picture>
                <div class="News-content">
                    <div>
                        <span>{{$news->publishedAt()}}</span>
                        <h2>{{$news->title}}</h2>
                        {!! $news->description !!}
                    </div>
                    <a href="{{route('news.show', ['news' => $news])}}" class="secondary-btn">@lang('site.READ_MORE')
                        <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2498 9.62501H3.86206L8.49344 4.99363C8.57701 4.91292 8.64367 4.81637 8.68953 4.70961C8.73539 4.60286 8.75952 4.48804 8.76053 4.37186C8.76154 4.25568 8.7394 4.14046 8.69541 4.03293C8.65141 3.92539 8.58644 3.8277 8.50428 3.74554C8.42213 3.66338 8.32443 3.59841 8.2169 3.55442C8.10936 3.51042 7.99414 3.48828 7.87796 3.48929C7.76178 3.4903 7.64696 3.51444 7.54021 3.5603C7.43346 3.60615 7.3369 3.67281 7.25619 3.75639L1.13119 9.88138C0.967151 10.0455 0.875 10.268 0.875 10.5C0.875 10.732 0.967151 10.9545 1.13119 11.1186L7.25619 17.2436C7.42122 17.403 7.64224 17.4912 7.87166 17.4892C8.10109 17.4872 8.32055 17.3952 8.48278 17.233C8.64501 17.0707 8.73703 16.8513 8.73903 16.6219C8.74102 16.3924 8.65283 16.1714 8.49344 16.0064L3.86206 11.375H19.2498C19.4819 11.375 19.7044 11.2828 19.8685 11.1187C20.0326 10.9546 20.1248 10.7321 20.1248 10.5C20.1248 10.2679 20.0326 10.0454 19.8685 9.88129C19.7044 9.7172 19.4819 9.62501 19.2498 9.62501Z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
