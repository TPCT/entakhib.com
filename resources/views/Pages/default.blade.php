@extends('layouts.main')

@section('title', $page->title)
@section('id', 'NewsInner')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/ElectionLaw.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image title="{{$page->title}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>
    <section>
        <div class="container">
            @foreach($page->bullets as $bullet)
                <div class="law">
                    <div class="law-topic">
                        <h2>{{$bullet->title}}</h2>
                    </div>
                    {!! $bullet->description !!}
                </div>
            @endforeach
        </div>
    </section>
@endsection
