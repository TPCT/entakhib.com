@extends('layouts.main')

@section('title', __('site.FAQS'))
@section('id', 'Faqs')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/Faqs.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image title="{{__('site.FAQS')}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>
    <section class="container mb-3">
        <div
                class="accordion accordion-flush custom-accordion"
                id="faqsFlushExample"
        >
            @foreach($faqs as $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-{{$faq->id}}">
                        <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse-{{$faq->id}}"
                                aria-expanded="false"
                                aria-controls="flush-collapse{{$faq->id}}"
                        >
                            {{$faq->title}}
                            <span class="accordion-btn">
                    </span>
                        </button>
                    </h2>
                    <div
                            id="flush-collapse-{{$faq->id}}"
                            class="accordion-collapse collapse"
                            aria-labelledby="flush-{{$faq->id}}"
                            data-bs-parent="#faqsFlushExample"
                    >
                        <div class="accordion-body">
                            {!! $faq->description !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-5 px-2">
        {{$faqs->links()}}
    </section>

@endsection