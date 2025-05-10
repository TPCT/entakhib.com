<div class="tab-pane fade show active" id="pills-individuals" role="tabpanel" aria-labelledby="pills-individuals-tab">
    <section class="tabpane-one">
        <section>
            <div class="container filter-container">
                <form>
                    <label for="">@lang('site.Filter By'): </label>
                    <select name="city_id" id="city_id">
                        <option value="" selected>
                            @lang('site.Choose City')
                        </option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}" @if($form_data['city_id'] == $city->id) selected @endif>
                                {{$city->title}}
                            </option>
                        @endforeach
                    </select>

                    @if ($districts)
                        <select name="district_id" id="district_id">
                            <option value="" selected>@lang('site.Choose District')</option>
                            @foreach($districts as $district)
                                <option value="{{$district->id}}" @if($form_data['district_id'] == $district->id) selected @endif>{{$district->title}}</option>
                            @endforeach
                        </select>
                    @endif

                    @if ($clusters)
                        <select name="cluster_id" id="cluster_id">
                            <option value="" selected>@lang('site.Choose Cluster')</option>
                            @foreach($clusters as $cluster)
                                <option value="{{$cluster->id}}" @if($form_data['cluster_id'] == $cluster->id) selected @endif>{{$cluster->title}}</option>
                            @endforeach
                        </select>
                    @endif

                    <input type="text" name="search" value="{{$form_data['search']}}" placeholder="@lang('site.Search For Candidate')">

                    <button class="secondary-btn">
                        @lang('site.Filter')
                        <svg
                                width="21"
                                height="21"
                                viewBox="0 0 21 21"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                    d="M19.2498 9.62501H3.86206L8.49344 4.99363C8.57701 4.91292 8.64367 4.81637 8.68953 4.70961C8.73539 4.60286 8.75952 4.48804 8.76053 4.37186C8.76154 4.25568 8.7394 4.14046 8.69541 4.03293C8.65141 3.92539 8.58644 3.8277 8.50428 3.74554C8.42213 3.66338 8.32443 3.59841 8.2169 3.55442C8.10936 3.51042 7.99414 3.48828 7.87796 3.48929C7.76178 3.4903 7.64696 3.51444 7.54021 3.5603C7.43346 3.60615 7.3369 3.67281 7.25619 3.75639L1.13119 9.88138C0.967151 10.0455 0.875 10.268 0.875 10.5C0.875 10.732 0.967151 10.9545 1.13119 11.1186L7.25619 17.2436C7.42122 17.403 7.64224 17.4912 7.87166 17.4892C8.10109 17.4872 8.32055 17.3952 8.48278 17.233C8.64501 17.0707 8.73703 16.8513 8.73903 16.6219C8.74102 16.3924 8.65283 16.1714 8.49344 16.0064L3.86206 11.375H19.2498C19.4819 11.375 19.7044 11.2828 19.8685 11.1187C20.0326 10.9546 20.1248 10.7321 20.1248 10.5C20.1248 10.2679 20.0326 10.0454 19.8685 9.88129C19.7044 9.7172 19.4819 9.62501 19.2498 9.62501Z"
                            />
                        </svg>
                    </button>
                </form>
                <div></div>
            </div>
        </section>
        <section >
            <div class="container Candidate-votes-container">
                @foreach($candidates as $candidate)
                    <div class="Candidate-votes-card">
                        <picture>
                            <x-curator-glider
                                :media="$candidate->image_id"
                            />
                        </picture>
                        <div class="Candidate-votes-card-content">
                            <div>
                                <h3>{{$candidate->title}}</h3>
                                <h3>{{$candidate->cluster?->title}}</h3>
                                <h3>{{$candidate->slogan}}</h3>
                            </div>
                            <div class="Candidate-votes-card-redbox">
                                <p>@lang('site.Total Votes'): {{$candidate->votes + $candidate->extra_votes}} @lang('site.Vote Count')</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section>
            <div class="container">
                {{$candidates->links()}}
            </div>
        </section>
    </section>
</div>

@push('script')
    <script>
        $(function(){

            $("#city_id").on('change', function(){
                $.ajax({
                    url: "{{route('api.districts', ['city' => "DUMMY"])}}".replace('DUMMY', $(this).val()),
                    dataType: 'json',
                    success: function (response){
                        $("#district_id").remove();
                        $("#cluster_id").remove();

                        if ($(response).length){
                            const districts = $(`
                            <select name="district_id" id="district_id">
                            </select>
                        `)
                            districts.insertAfter("#city_id");
                            districts.append((`<option value="" selected>@lang('site.Choose District')</option>`))
                            $.each(response, function (key, title){
                                const option = (`
                                <option value="${key}">${title}</option>
                            `)
                                districts.append(option)
                            });

                            districts.on('change', function(){
                                $.ajax({
                                    url: "{{route('api.clusters', ['district' => "DUMMY"])}}".replace('DUMMY', $(this).val()),
                                    dataType: 'json',
                                    success: function (response){
                                        $("#cluster_id").remove();
                                        if ($(response).length){
                                            const clusters = $(`
                                                <select name="cluster_id" id="cluster_id">
                                                </select>
                                            `)

                                            clusters.insertAfter("#district_id");
                                            clusters.append((`<option value="" selected>@lang('site.Choose Cluster')</option>`))
                                            $.each(response, function (key, title){
                                                const option = (`
                                                    <option value="${key}">${title}</option>
                                                `)
                                                clusters.append(option)
                                            });
                                        }
                                    }
                                });
                            })
                        }
                    }
                });
            })

            $("#district_id").on('change', function(){
                $.ajax({
                    url: "{{route('api.clusters', ['district' => "DUMMY"])}}".replace('DUMMY', $(this).val()),
                    dataType: 'json',
                    success: function (response){
                        $("#cluster_id").remove();
                        if ($(response).length){
                            const clusters = $(`
                                                <select name="cluster_id" id="cluster_id">
                                                </select>
                                            `)

                            clusters.insertAfter("#district_id");
                            clusters.append((`<option value="" selected>@lang('site.Choose Cluster')</option>`))
                            $.each(response, function (key, title){
                                const option = (`
                                                    <option value="${key}">${title}</option>
                                                `)
                                clusters.append(option)
                            });
                        }
                    }
                });
            })

        })
    </script>
@endpush