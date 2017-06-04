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
                <tr class="item" ng-if="top-products.length > 0" dir-paginate="product in top-products | itemsPerPage: 8" ng-click="readProduct(product)">
                <td> SP@{{("000"+product.product_id).slice(-4)}} </td>
                <td data-toggle="modal" data-target="#readProduct"> <p class="entry-text"> @{{ product.name}} </p> </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.code }}</td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.unit.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.total_quantity | number: 0 }}</td>
                <td data-toggle="modal" data-target="#readProduct">
                    <p ng-show="product.status == 1"> Còn hàng </p>
                    <p ng-show="product.status == 0"> Hết hàng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProduct" ng-show="0==product.status">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="top-products.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        <div id="grid" class="container-fluid" hidden>
            <h4 align="center"> Biểu đồ thống kê 10 sản phẩm bán chạy </h4>
            <canvas class="chart-horizontal-bar" chart-series="series" chart-data="data" chart-labels="labels" ng-show="data.length>0"></canvas>
           	<h1 ng-show="data.length==0"> Không có dữ liệu </h1>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection