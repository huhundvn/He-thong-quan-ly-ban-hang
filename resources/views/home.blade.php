@extends('layouts.app')

@section('title')
    Trang chủ
@endsection

@section('location')

@endsection

@section('content')
<div ng-controller="HomeController">
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading w3-blue-grey">
                Thu / chi cửa hàng
            </div>
            <div class="panel-body">
                <h3 class="w3-text-blue"> Tổng thu: 100.000 </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-voucher') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Đơn đặt hàng hôm nay </div>
            <div class="panel-body">
                <h3 class="w3-text-blue"> @{{ today_order }} đơn hàng mới </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-order') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Khách hàng </div>
            <div class="panel-body">
                <h3 class="w3-text-blue"> @{{ sum_customer }} khách hàng </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-customer') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Nhân viên </div>
            <div class="panel-body">
                <h3 class="w3-text-blue"> @{{ sum_user }} nhân viên </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-user') }}"> Xem thêm... </a> </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <canvas class="chart chart-line" chart-series="series" chart-data="data" chart-labels="labels" height="80px"></canvas>
    <p align="center"> Biểu đồ doanh thu </p>
    </div>
</div>
</div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/HomeController.js') }}"></script>
@endsection