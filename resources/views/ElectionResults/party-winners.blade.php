@extends('layouts.main')

@section('title', __("site.Voting Primary Results"))
@section('id', 'WinningIndividuals')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/PrimaryElectionResults.css')}}">
@endpush
@section('content')
    <x-layout.header-image title="{{__('site.Winner Candidates From')}} ({{$party->title}})"></x-layout.header-image>
    <x-layout.share></x-layout.share>

    <section class="mb-3">
        <div class="container Candidate-votes-container">
            @foreach($candidates as $candidate)
                <div class="Candidate-votes-card">
                    <picture>
                        <x-curator-glider
                            :media="$candidate->image_id"
                        />
                    </picture>
                    <div class="Candidate-votes-card-content">
                        <div class="mt-2 mb-2">
                            <h3>{{$candidate->title}}</h3>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection