@extends('layouts.main')

@section('title', $cluster->title . " - " . __("site.Votes Results"))
@section('id', 'Election-results')

@push('style')
    <link rel="stylesheet" href="{{asset('/css/Election-result.css')}}">
@endpush
@section('content')
    <x-layout.header-image title="{{$cluster->title . ' - ' . __('Votes Results')}}"></x-layout.header-image>
    <x-layout.share></x-layout.share>

    <section>
        <div class="container">
            <div class="mb-3">
                {!! $cluster->description !!}
            </div>
        </div>
        <div class="container votes-percentage-charts-container">
            <div class="single-chart-item">
                <canvas id="myBarChart" class="votes-percentage-bar-chart"></canvas>
                <h5>@lang('site.Cluster Candidates Percentage')</h5>
            </div>
            <div class="single-chart-item">
                <canvas
                        id="myDoughnutChart"
                        class="votes-percentage-pie-chart"
                ></canvas>
                <h5>@lang('site.Cluster District Percentage')</h5>
            </div>
        </div>
    </section>
    <section class="mb-3">
        <div class="container Cluster-topic">
            <h2>@lang('site.Cluster Candidates')</h2>
        </div>
        <div class="container local-list-container">
            <div class="local-list-card">
                <picture>
                    <x-curator-glider
                        :media="$cluster->image_id"
                    />
                </picture>
                <div>
                    <h3>{{$cluster->title}}</h3>
                    <h4>@lang('site.Total Votes'): {{$cluster->votes + $cluster->candidates()->sum('extra_votes')}}</h4>
                    <h4>@lang('site.Cluster District Votes Percentage'): {{$district_cluster_votes[$cluster->title]}} %</h4>
                </div>
            </div>
        </div>
        <div class="container candidate-container">
            @foreach($cluster->candidates as $candidate)
                <div class="local-list-card">
                    <picture>
                        <x-curator-glider
                            :media="$candidate->image_id"
                        />
                    </picture>
                    <div>
                        <h3>{{$candidate->title}}</h3>
                        <h4>@lang('site.Total Votes Count'): {{$candidate->votes + $candidate->extra_votes}}</h4>
                        <h4>@lang('site.Cluster District Votes Percentage'): {{$candidates_cluster_votes[$candidate->title]}} %</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('script')
    <script>
        // Doughnut Chart
        const ctxDoughnut = document
            .getElementById("myDoughnutChart")
            .getContext("2d");
        const gradientBgGreen = ctxDoughnut.createLinearGradient(0, 0, 0, 350);

        gradientBgGreen.addColorStop(0, "#6EB436");
        gradientBgGreen.addColorStop(1, "#557E35");

        const doughnutData = {
            labels: JSON.parse(`@json(array_keys($district_cluster_votes))`),
            datasets: [
                {
                    data: {!! json_encode(array_values($district_cluster_votes)) !!},
                    backgroundColor: [gradientBgGreen, "#6EB43626"],
                    borderColor: ["#FFFFFF"],
                    borderWidth: 1,
                },
            ],
        };

        const doughnutOptions = {
            maintainAspectRatio: true,
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.label + ": " + tooltipItem.raw + "%";
                        },
                    },
                },
            },
            cutout: "70%",
        };

        const doughnutLabelsLine = {
            id: "doughnutLabelsLine",
            afterDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: { top, bottom, left, right, width, height },
                } = chart;

                chart.data.datasets.forEach((dataset, i) => {
                    chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                        const { x, y } = datapoint.tooltipPosition();

                        const halfwidth = width / 2 - 10;
                        const halfheight = height / 2;

                        // Text
                        const textWidth = ctx.measureText(chart.data.labels[index]).width;
                        ctx.font = "48px PNU-Medium";
                        const textXPosition = x >= halfwidth ? "right" : "right";
                        ctx.textAlign = textXPosition;
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#5E9F2A";

                        if (index === {{array_search($cluster->title, array_keys($district_cluster_votes))}}){
                            ctx.fillText(
                                chart.data.datasets[0].data[index] + "%",
                                halfwidth + 85,
                                halfheight + 10
                            );
                        }
                    });
                });
            },
        };

        const myDoughnutChart = new Chart(ctxDoughnut, {
            type: "doughnut",
            data: doughnutData,
            options: doughnutOptions,
            plugins: [doughnutLabelsLine],
        });

        // Bar Chart
        const ctxBar = document.getElementById("myBarChart").getContext("2d");
        const gradientBgRed = ctxBar.createLinearGradient(0, 0, 0, 350);
        gradientBgRed.addColorStop(0, "#983030");
        gradientBgRed.addColorStop(1, "#BD3939");
        const barData = {
            labels: JSON.parse(`@json(array_keys($candidates_cluster_votes))`),
            datasets: [
                {
                    data: {!! json_encode(array_values($candidates_cluster_votes)) !!},
                    backgroundColor: gradientBgRed,
                    borderWidth: 1,
                    borderRadius: 10,
                },
            ],
        };

        const barOptions = {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.raw + "%";
                        },
                    },
                },
            },
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function (value) {
                            return value + "%";
                        },
                    },
                },
            },
        };

        const myBarChart = new Chart(ctxBar, {
            type: "bar",
            data: barData,
            options: barOptions,
        });
    </script>
@endpush