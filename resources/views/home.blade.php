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
                Doanh thu
            </div>
            <div class="panel-body">
                <h3> 10%  <span class="glyphicon glyphicon-arrow-up"></span> </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-user') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Đơn đặt hàng </div>
            <div class="panel-body">
                <h3> @{{orders.length}} đơn hàng </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-order') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Khách hàng </div>
            <div class="panel-body">
                <h3> @{{ customers.length }} khách hàng </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-customer') }}"> Xem thêm... </a> </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading w3-blue-grey"> Nhân viên </div>
            <div class="panel-body">
                <h3> @{{ users.length }} nhân viên </h3>
            </div>
            <div class="panel-footer"> <a href="{{ route('list-user') }}"> Xem thêm... </a> </div>
        </div>
    </div>
</div>

<canvas id="myChart" height="80"></canvas>
<script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9"],
            datasets: [{
                label: '# of Votes',
                data: [100, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
</div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/HomeController.js') }}"></script>
@endsection