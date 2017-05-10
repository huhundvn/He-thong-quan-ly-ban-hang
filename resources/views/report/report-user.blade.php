@extends('layouts.app')

@section('title')
    Nhân viên bán được nhiều nhất
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Top 10 nhân viên bán hàng </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="container-fluid">
            <canvas class="chart-bar" chart-series="series03" chart-data="data03" chart-labels="labels03"></canvas>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection