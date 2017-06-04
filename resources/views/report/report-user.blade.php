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
    	<div class="row">
    		<div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="btn-group">
                    <button id="viewList" type="button" class="btn btn-sm btn-default w3-blue-grey">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <button id="viewGrid" type="button" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-th"></span>
                    </button>
                </div>
            </div>
    	</div>

    	<hr> </hr>

    	{{-- DANH SÁCH SẢN PHẨM --}}
        <table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã NV </th>
                <th> Tên </th>
                <th> Nơi làm việc </th>
                <th> Số tiền bán ra </th>
            </thead>
            <tbody>
            </tbody>
        </table>    

        <div id="grid" class="container-fluid" hidden>
            <canvas class="chart-bar" chart-series="series03" chart-data="data03" chart-labels="labels03"></canvas>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection