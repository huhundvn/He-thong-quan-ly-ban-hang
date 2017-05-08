@extends('layouts.app')

@section('title')
    Doanh thu cửa hàng
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Doanh thu cửa hàng </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="container-fluid">
            <canvas class="chart chart-bar" chart-series="series" chart-data="data02" chart-labels="labels02"></canvas>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection