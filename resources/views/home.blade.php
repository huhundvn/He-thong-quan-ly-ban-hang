@extends('layouts.app')

@section('title')
    Trang chủ
@endsection

@section('location')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                </span> Doanh thu <span class="badge">42</span>
            </div>
            <div class="panel-body">
                <a href=""> Xem thêm... </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading"> Tổng số đơn hàng <span class="badge">42</span> </div>
            <div class="panel-body">
                <a href=""> Xem thêm... </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading"> Tổng số khách hàng <span class="badge">42</span> </div>
            <div class="panel-body">
                <a href=""> Xem thêm... </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading"> Nhân viên <span class="badge">42</span> </div>
            <div class="panel-body">
                <a href=""> Xem thêm... </a>
            </div>
        </div>
    </div>
</div>

<p> Đơn hàng đã xác nhận </p>
<div class="progress">
    <div class="progress-bar progress-bar-striped active" role="progressbar"
         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
        40%
    </div>
</div>

<p> Đơn hàng đã giao </p>
<div class="progress">
    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar"
         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
        40%
    </div>
</div>
@endsection