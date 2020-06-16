@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <h4 class="header-title mt-0">Medicines Purchased</h4>
                <div id="purchased" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
            <div class="card-box">
                <h4 class="header-title mt-0">Income</h4>
                <div id="income" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div>
    </div>
@stop


@push('js')
<!-- knob plugin -->
<script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
<!--Morris Chart-->
<script src="assets/libs/morris-js/morris.min.js"></script>
<script src="assets/libs/raphael/raphael.min.js"></script>
    <script>
        let createLineChart = function (e, a, r, o, t, i, l, n, s) {
            Morris.Line({
                element: e,
                data: a,
                xkey: r,
                ykeys: o,
                labels: t,
                fillOpacity: i,
                pointFillColors: l,
                pointStrokeColors: n,
                behaveLikeLine: !0,
                gridLineColor: "#323a46",
                hideHover: "auto",
                resize: !0,
                gridTextColor: "#98a6ad",
                lineColors: s,
            });
        };

        createLineChart(
            "purchased",
            @JSON($statisticMedicinePurchased),
            "y",
            ["stock", "patient", "medicine"],
            ["Stock", "Patient", "Medicine"],
            ["0.9"],
            ["#ffffff"],
            ["#999999"],
            ["#10c469", "#188ae2", '#076178'], 
        );

        createLineChart(
            "income",
            @JSON($statisticMedicinePurchased),
            "y",
            ["income"],
            ["Income"],
            ["0.9"],
            ["#ffffff"],
            ["#999999"],
            ["#10c469"], 
        );
    </script>
@endpush

@push('css')
<!--Morris Chart-->
<link rel="stylesheet" href="assets/libs/morris-js/morris.css" />
@endpush