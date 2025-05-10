@extends('layouts.main')

@section('title', $cluster->title . " - " . $cluster->district->title . ' / ' . $cluster->city->title)
@section('id', 'Votes-percentages')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/ElectionPage.css')}}">
@endpush
@section('content')
    <x-layout.header-image title="{{$cluster->title . ' - ' . $cluster->district->title . ' / ' . $cluster->city->title}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>
    <section class="mb-3">
        <div class="container Votes-percentages-opening">
            {!! $cluster->description !!}
            <h2>@lang('site.Cluster Candidates')</h2>
        </div>
        <section>
            <form method="get" action="{{route('profile.vote', ['type' => 'cluster'])}}" class="d-none" id="cluster-election-form">
                @csrf
            </form>
            <div class="container local-list-container">
                <div class="local-list-card">
                    <picture>
                        <x-curator-glider
                            :media="$cluster->image_id"
                        />
                    </picture>
                    <div>
                        <h3>{{$cluster->title}}</h3>
                        <p>{{$cluster->second_title}}</p>
                        @if($can_vote && $can_vote_to_cluster)
                            <input form="cluster-election-form" type="checkbox" id="cluster-checkbox" disabled>
                            <input form="cluster-election-form" type="hidden" name="cluster_id" value="{{$cluster->id}}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="container @if($cluster->candidates->count()) candidate-container d-flex @endif">
                @forelse($cluster->candidates as $candidate)
                    <div class="local-list-card ">
                        <picture>
                            <x-curator-glider
                                :media="$candidate->image_id"
                            />
                        </picture>
                        <div>
                            <h3>{{$candidate->title}}</h3>
                            {!! $candidate->external_brief !!}
                            <a href="{{route('candidates.show', ['candidate' => $candidate])}}" class="secondary-btn">@lang('site.Profile')
                                <svg width="21" height="21" viewBox="0 0 21 21"  xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.2498 9.62501H3.86206L8.49344 4.99363C8.57701 4.91292 8.64367 4.81637 8.68953 4.70961C8.73539 4.60286 8.75952 4.48804 8.76053 4.37186C8.76154 4.25568 8.7394 4.14046 8.69541 4.03293C8.65141 3.92539 8.58644 3.8277 8.50428 3.74554C8.42213 3.66338 8.32443 3.59841 8.2169 3.55442C8.10936 3.51042 7.99414 3.48828 7.87796 3.48929C7.76178 3.4903 7.64696 3.51444 7.54021 3.5603C7.43346 3.60615 7.3369 3.67281 7.25619 3.75639L1.13119 9.88138C0.967151 10.0455 0.875 10.268 0.875 10.5C0.875 10.732 0.967151 10.9545 1.13119 11.1186L7.25619 17.2436C7.42122 17.403 7.64224 17.4912 7.87166 17.4892C8.10109 17.4872 8.32055 17.3952 8.48278 17.233C8.64501 17.0707 8.73703 16.8513 8.73903 16.6219C8.74102 16.3924 8.65283 16.1714 8.49344 16.0064L3.86206 11.375H19.2498C19.4819 11.375 19.7044 11.2828 19.8685 11.1187C20.0326 10.9546 20.1248 10.7321 20.1248 10.5C20.1248 10.2679 20.0326 10.0454 19.8685 9.88129C19.7044 9.7172 19.4819 9.62501 19.2498 9.62501Z" />
                                </svg>
                            </a>

                            @if ($can_vote && $can_vote_to_cluster)
                                <input form="cluster-election-form" type="checkbox" name="candidate_ids[]" class="candidate-checkbox" value="{{$candidate->id}}">
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="d-flex w-100 justify-content-center mt-3">
                        <h3>
                            @lang('site.No Candidates Within This Cluster')
                        </h3>
                    </div>
                @endforelse
            </div>
            @if ($can_vote_to_cluster && $cluster->candidates->count() && $can_vote)
                <div class="container d-flex d-none justify-content-center mt-5 mb-5" id="submit-button">
                    <input type="submit" class="main-btn election-button" form="cluster-election-form" value="@lang('site.Elect')">
                </div>
            @elseif (!$can_vote_to_cluster)
                <div class="container d-flex justify-content-center mt-3 voted-before-message align-items-center">
                    <img class="check-2" src="{{asset('/images/Vector.svg')}}">
                    <span class="text-success voted-before">@lang("site.You Can't Vote To This Cluster")</span>
                </div>
            @elseif (!$can_vote)
                <div class="container d-flex justify-content-center mt-3 voted-before-message align-items-center">
                    <img class="check-2" src="{{asset('/images/CheckCircle.svg')}}">
                    <span class="text-success voted-before">@lang("site.You Voted Before")</span>
                </div>
            @endif;
        </section>
    </section>
@endsection

@push('script')
    <script>
        $(function (){
            $('.candidate-checkbox').on('click', function(){
                if ($('.candidate-checkbox:checked').length > 0) {
                    $("#cluster-checkbox").prop('checked', true).attr('checked', 'checked')
                    $("#submit-button").removeClass('d-none').show();
                    return;
                }
                $("#cluster-checkbox").prop('checked', false).removeAttr('checked')
                $("#submit-button").addClass('d-none').hide();
            });

            const popup = new Popup({
                id: "board",
                titleColor: "#000",
                textColor: "#000",
                closeColor: "#000",
                title: `<div class='d-flex flex-column align-items-center'><img class='check' src='{{asset('/images/Vector.svg')}}'/>@lang('site.VOTE_POP_UP_TITLE')</div>`,
                backgroundColor: "#FFF",
                fontSizeMultiplier: 0.75,
                content: `@lang('site.VOTE_POP_UP_CONTENT')\n{btn-ok}[@lang('site.POP_UP_BTN_TEXT')]`,
                borderWidth: ".15em",
                borderColor: "#FFFFFF",
                css: `
                    .popup.board button {
                        background-color: #000;
                        color: white;
                        margin-top: 1em;
                    }`,
                loadCallback: () => {
                    /* button functionality */
                   $(".popup.board button").on('click', function(){
                       $("#cluster-election-form").submit();
                   })
                },
            });

            $(".election-button").on('click', function(e){
                e.preventDefault();
                popup.show();
            })
        })
    </script>
@endpush