@extends('layouts.app')

@section('title')
    Larose | Danh sách khách hàng
@endsection

@section('location')
    <li> Quản lý nhóm khách hàng </li>
@endsection

@section('content')
    <div ng-controller="CustomerGroupController">

        {{-- !TÌM KIẾM NHÓM KHÁCH HÀNG!--}}
        <div class="row">
            <div class="col-lg-6 ">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCustomerGroup">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadCustomerGroupTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-4 ">
                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên nhóm...">
            </div>
            <div class="col-lg-2 ">
                <button class="btn btn-sm btn-info"> Tổng số: @{{customerGroups.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH NHÓM KHÁCH HÀNG --}}
        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã nhóm </th>
            <th> Tên nhóm khách hàng </th>
            <th> Mô tá </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="customerGroups.length > 0" dir-paginate="customerGroup in customerGroups | filter:term | itemsPerPage: 7" ng-click="readCustomerGroup(customerGroup)">
                <td data-toggle="modal" data-target="#readCustomerGroup"> GR-@{{ customerGroup.id}} </td>
                <td data-toggle="modal" data-target="#readCustomerGroup"> @{{ customerGroup.name}} </td>
                <td data-toggle="modal" data-target="#readCustomerGroup"> @{{ customerGroup.description}}</td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteCustomerGroup">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="customerGroups.length==0">
                <td colspan="4"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; bottom:0; position: fixed;">
            <dir-pagination-controls></dir-pagination-controls>
        </div>

        {{-- TẠO NHÓM KHÁCH HÀNG MỚI --}}
        <div class="modal fade" id="createCustomerGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm nhóm khách hàng mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên nhóm </label>
                                <div class="">
                                    <input ng-model="new.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Ghi chú </label>
                                <div class="">
                                    <textarea ng-model="new.description" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createCustomerGroup()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !NHẬP TỪ FILE! --}}
        <div class="modal fade" id="inputFromFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="{{route('importCustomerGroupFromFile')}}" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Nhập từ File </h4>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" accept=".xlsx">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- XEM, SỬA NHÓM KHÁCH HÀNG --}}
        <div class="modal fade" id="readCustomerGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên nhóm </label>
                                <div class="">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mô tả </label>
                                <div class="">
                                    <textarea id="description" ng-model="selected.description" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateCustomerGroup" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateCustomerGroup()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- XÓA NHÓM KHÁCH HÀNG--}}
        <div class="modal fade" id="deleteCustomerGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa nhóm khách hàng </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa nhóm này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteCustomerGroup()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/CustomerGroupController.js') }}"></script>
@endsection