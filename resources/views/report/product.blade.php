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
        <h4 align="center"> Biểu đồ thống kê 10 sản phẩm bán chạy </h4>
        
        {{-- DANH SÁCH SẢN PHẨM --}}
        <table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã SP </th>
                <th> Tên </th>
                <th> Mã vạch </th>
                <th> Đơn vị tính </th>
                <th> Số lượng bán ra </th>
            </thead>
            <tbody>
                <tr class="item" ng-if="topProducts.length > 0" dir-paginate="product in topProducts | itemsPerPage: 8" ng-click="readProduct(product)">
                <td data-toggle="modal" data-target="#readProduct"> SP@{{("000"+product.product_id).slice(-4)}} </td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.name}} </td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.code }}</td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.unit.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.sum | number: 0 }}</td>
            </tr>
            <tr class="item" ng-if="topProducts.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        <div id="grid" class="container-fluid" hidden>
            <canvas class="chart-horizontal-bar" chart-series="series" chart-data="data" chart-labels="labels" ng-show="data.length>0"></canvas>
           	<h1 ng-show="data.length==0"> Không có dữ liệu </h1>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection