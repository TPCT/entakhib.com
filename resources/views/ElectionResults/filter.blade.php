@extends('layouts.main')

@section('title', __("site.Voting Primary Results"))
@section('id', 'PrimaryElectionResults')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/PrimaryElectionResults.css')}}">
@endpush
@section('content')
    <x-layout.header-image title="{{__('site.Voting Primary Results')}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>

    <section class="mb-3">
        <div class="container">
            <section class="about-our-services-section container">
                <form id="tab-pane-form" class="d-none">
                    <input type="hidden" name="panel" id="panel">
                </form>

                <ul class="nav custom-panel nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation" data-panel="clusters">
                        <button class="nav-link @if(request('panel', 'clusters') == 'clusters') active @endif" id="pills-individuals-tab" data-bs-toggle="pill" data-bs-target="#pills-individuals" type="button" role="tab" aria-controls="pills-individuals" aria-selected="false">
                            @lang('site.Local Clusters')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" data-panel="parties">
                        <button class="nav-link @if(request('panel', 'clusters') == 'parties') active @endif" id="corporate-tab" data-bs-toggle="pill" data-bs-target="#corporate" type="button" role="tab" aria-controls="corporate" aria-selected="true">
                            @lang('site.General Parties')
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <section id="results-section">
                        @if(request('panel', 'clusters') == 'clusters')
                            @include('ElectionResults.clusters')
                        @else
                            @include('ElectionResults.parties')
                        @endif
                    </section>
                </div>
            </section>
        </div>
    </section>

@endsection

@push('script')
    <script>
        $(function(){
            $('.nav-item').on('click', function(e){
                e.preventDefault();
                $("#tab-pane-form").find('#panel').val($(this).data('panel'))
                $("#tab-pane-form").submit();
                // $('#pills-tabContent').load(window.location + "?" + $("#tab-pane-form").serialize() + " #results-section")
            })
        })
    </script>
@endpush