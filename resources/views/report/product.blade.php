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
        <div class="row">
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="btn-group">
                    <button id="viewList" type="button" class="btn btn-sm btn-default w3-blue-grey">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <button id="viewGrid" type="button" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-signal"></span>
                    </button>
                </div>
            </div>
        </div>

        <hr> </hr>

        {{-- DANH SÁCH NHÂN VIÊN --}}
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
            <canvas class="chart-bar" chart-series="series" chart-data="data" chart-labels="labels" ng-show="data.length>0"></canvas>
           	<h1 ng-show="data.length==0"> Không có dữ liệu </h1>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection