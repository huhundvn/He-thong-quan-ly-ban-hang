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
    		<div class="col-lg-2  ">
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

        <h4 align="center"> Biểu đồ thống kê 10 nhân viên bán nhiều hàng nhất </h4>

    	{{-- DANH SÁCH NHÂN VIÊN --}}
        <div class="table-responsive"><table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã NV </th>
                <th> Tên </th>
                <th> Email </th>
                <th> Số điện thoại </th>
                <th> Nơi làm việc </th>
                <th> Tổng tiền đã bán ra (VNĐ) </th>
            </thead>
            <tbody>
                <tr ng-show="topUsers.length > 0" class="item" ng-repeat="user in topUsers" ng-click="readUser(user)">
                <td data-toggle="modal" data-target="#readUser"> NV-@{{ user.created_by}} </td>
                <td data-toggle="modal" data-target="#readUser" ng-repeat="item in users" ng-if="item.id==user.created_by"> @{{ item.name}} </td>
                <td data-toggle="modal" data-target="#readUser" ng-repeat="item in users" ng-if="item.id==user.created_by"> @{{ item.email}}</td>
                <td data-toggle="modal" data-target="#readUser" ng-repeat="item in users" ng-if="item.id==user.created_by"> @{{ item.phone}} </td>
                <td data-toggle="modal" data-target="#readUser" ng-repeat="item in users" ng-if="item.id==user.created_by"> @{{ item.store.name}} </td>
                <td data-toggle="modal" data-target="#readUser"> @{{ user.sum | number: 0}} 
                </td>
            </tr>
            <tr class="item" ng-if="users.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>    

        <div id="grid" class="container-fluid" hidden>
            <canvas class="chart-horizontal-bar" chart-series="series03" chart-data="data03" chart-labels="labels03"></canvas>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection