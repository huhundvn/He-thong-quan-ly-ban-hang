@extends('layouts.app')

@section('title')
    Sản phẩm được quan tâm nhiều
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Top 10 sản phẩm bán chạy </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="container-fluid">
            <canvas class="chart-bar" chart-series="series" chart-data="data" chart-labels="labels" ng-show="data.length>0"></canvas>
           	<h1 ng-show="data.length==0"> Không có dữ liệu </h1>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection