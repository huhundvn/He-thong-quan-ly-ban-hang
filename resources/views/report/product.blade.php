@extends('layouts.app')

@section('title')
    Sản phẩm được quan tâm nhiều
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Sản phẩm bán chạy </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="row">
        </div>
        <canvas class="chart chart-line" chart-data="data" chart-labels="labels"
                chart-series="series" chart-click="onClick"></canvas>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection