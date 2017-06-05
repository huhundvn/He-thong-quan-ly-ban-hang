@extends('layouts.app')

@section('title')
    Danh sách chức vụ
@endsection

@section('location')
    <li> Danh sách chức vụ </li>
@endsection

@section('content')
    <div ng-controller="PositionController">

        {{-- TÌM KIẾM DANH MỤC CHỨC VỤ --}}
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createPosition">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadPositionTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{positions.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH CHỨC VỤ --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
                <th> Mã chức vụ </th>
                <th> Tên </th>
                <th> Mô tả </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="positions.length > 0" class="item" dir-paginate="position in positions | filter:term | itemsPerPage: 7" ng-click="readPosition(position)">
                <td data-toggle="modal" data-target="#readPosition"> CV-@{{ position.id }} </td>
                <td data-toggle="modal" data-target="#readPosition"> @{{ position.name }} </td>
                <td data-toggle="modal" data-target="#readPosition"> @{{ position.description }}</td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePosition">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="positions.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 45%">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- TẠO CHỨC VỤ MỚI --}}
        <div class="modal fade" id="createPosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm chức vụ mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mô tả </label>
                                <div class="col-sm-9">
                                    <textarea ng-model="new.description" class="form-control"> </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label> Bán hàng </label> <br/>
                                    <input ng-model="role01" type="checkbox" ng-true-value="'order'" ng-false-value="'order'" ng-click="add(role01)"> Quản lý đơn hàng <br/>
                                    <input ng-model="role02" type="checkbox" ng-true-value="'price-output'" ng-false-value="'price-output'" ng-click="add(role02)"> Quản lý bảng giá <br/>
                                    <!-- <input ng-model="role03" type="checkbox" ng-true-value="'return'" ng-false-value="'return'" ng-click="add(role03)"> Quản lý trả về <br/> -->
                                    <input ng-model="role04" type="checkbox" ng-true-value="'confirm-order'" ng-false-value="'confirm-order'" ng-click="add(role04)"> Duyệt đơn hàng <br/>
                                    <input ng-model="role05" type="checkbox" ng-true-value="'confirm-price-output'" ng-false-value="'confirm-price-output'" ng-click="add(role05)"> Duyệt bảng giá <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Sản phẩm </label> <br/>
                                    <input ng-model="role06" type="checkbox" ng-true-value="'product'" ng-false-value="'product'" ng-click="add(role06)"> Quản lý sản phẩm <br/>
                                    <input ng-model="role07" type="checkbox" ng-true-value="'supplier'" ng-false-value="'supplier'" ng-click="add(role07)"> Quản lý nhà cung cấp <br/>
                                    <input ng-model="role08" type="checkbox" ng-true-value="'manufacturer'" ng-false-value="'manufacturer'" ng-click="add(role08)"> Quản lý nhà sản xuất <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kho </label> <br/>
                                    <input ng-model="role09" type="checkbox" ng-true-value="'store'" ng-false-value="'store'" ng-click="add(role09)"> Quản lý danh sách kho <br/>
                                    <input ng-model="role11" type="checkbox" ng-true-value="'input-store'" ng-false-value="'input-store'" ng-click="add(role11)"> Quản lý nhập kho <br/>
                                    <input ng-model="role22" type="checkbox" ng-true-value="'store-output'" ng-false-value="'store-output'" ng-click="add(role22)"> Quản lý xuất kho <br/>
                                    <input ng-model="role13" type="checkbox" ng-true-value="'store-tranfer'" ng-false-value="'store-tranfer'" ng-click="add(role13)"> Quản lý chuyển kho <br/>
                                    <input ng-model="role10" type="checkbox" ng-true-value="'product-in-store'" ng-false-value="'product-in-store'" ng-click="add(role10)"> Quản lý sản phẩm trong kho <br/>
                                    <input ng-model="role12" type="checkbox" ng-true-value="'price-input'" ng-false-value="'price-input'" ng-click="add(role12)"> Quản lý bảng giá mua <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kế toán </label> <br/>
                                    <input ng-model="role14" type="checkbox" ng-true-value="'account'" ng-false-value="'account'" ng-click="add(role14)"> Quản lý tài khoản <br/>
                                    <input ng-model="role15" type="checkbox" ng-true-value="'voucher'" ng-false-value="'voucher'" ng-click="add(role15)"> Quản lý thu/chi <br/>
                                    <input ng-model="role16" type="checkbox" ng-true-value="'customer-invoice'" ng-false-value="'customer-invoice'" ng-click="add(role16)"> Thanh toán đơn hàng <br/>
                                    <input ng-model="role17" type="checkbox" ng-true-value="'supplier-invoice'" ng-false-value="'supplier-invoice'" ng-click="add(role17)"> Thanh toán nhà cung cấp <br/>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label> Báo cáo </label> <br/>
                                    <input ng-model="role18" type="checkbox" ng-true-value="'report'" ng-false-value="'report'" ng-click="add(role18)"> Quản lý báo cáo <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Khách hàng </label> <br/>
                                    <input ng-model="role19" type="checkbox" ng-true-value="'customer'" ng-false-value="'customer'" ng-click="add(role19)"> Quản lý khách hàng <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Nhân viên </label> <br/>
                                    <input ng-model="role20" type="checkbox" ng-true-value="'user'" ng-false-value="'user'" ng-click="add(role20)"> Quản lý nhân viên <br/>
                                    <input ng-model="role21" type="checkbox" ng-true-value="'position'" ng-false-value="'position'" ng-click="add(role21)"> Quản lý chức vụ <br/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createPosition()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
                    <form enctype="multipart/form-data" action="{{route('importPositionFromFile')}}" method="post"> {{csrf_field()}}
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

        {{-- XEM, SỬA THÔNG TIN CHỨC VỤ --}}
        <div class="modal fade" id="readPosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm chức vụ mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mô tả </label>
                                <div class="col-sm-9">
                                    <textarea id="description" ng-model="selected.description" class="form-control"> </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label> Bán hàng </label> <br/>
                                    <input ng-checked="selected.role.indexOf('order') != -1" ng-model="urole01" type="checkbox" ng-true-value="'order'" ng-false-value="'order'" ng-click="add(urole01)"> Quản lý đơn hàng <br/>
                                    <input ng-checked="selected.role.indexOf('price-output') != -1" ng-model="urole02" type="checkbox" ng-true-value="'price-output'" ng-false-value="'price-output'" ng-click="add(urole02)"> Quản lý bảng giá <br/>
                                    <!-- <input ng-checked="selected.role.indexOf('return') != -1" ng-model="urole03" type="checkbox" ng-true-value="'return'" ng-false-value="'return'" ng-click="add(urole03)"> Quản lý trả về <br/> -->
                                    <input ng-checked="selected.role.indexOf('confirm-order') != -1" ng-model="urole04" type="checkbox" ng-true-value="'confirm-order'" ng-false-value="'confirm-order'" ng-click="add(urole04)"> Duyệt đơn hàng <br/>
                                    <input ng-checked="selected.role.indexOf('confirm-price-output') != -1" ng-model="urole05" type="checkbox" ng-true-value="'confirm-price-output'" ng-false-value="'confirm-price-output'" ng-click="add(urole05)"> Duyệt bảng giá <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Sản phẩm </label> <br/>
                                    <input ng-checked="selected.role.indexOf('product') != -1" ng-model="urole06" type="checkbox" ng-true-value="'product'" ng-false-value="'product'" ng-click="add(urole06)"> Quản lý sản phẩm <br/>
                                    <input ng-checked="selected.role.indexOf('supplier') != -1" ng-model="urole07" type="checkbox" ng-true-value="'supplier'" ng-false-value="'supplier'" ng-click="add(urole07)"> Quản lý nhà cung cấp <br/>
                                    <input ng-checked="selected.role.indexOf('manufacturer') != -1" ng-model="urole08" type="checkbox" ng-true-value="'manufacturer'" ng-false-value="'manufacturer'" ng-click="add(urole08)"> Quản lý nhà sản xuất <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kho </label> <br/>
                                    <input ng-checked="selected.role.indexOf('store') != -1" ng-model="urole09" type="checkbox" ng-true-value="'store'" ng-false-value="'store'" ng-click="add(urole09)"> Quản lý danh sách kho <br/>
                                    <input ng-checked="selected.role.indexOf('product-in-store') != -1" ng-model="urole10" type="checkbox" ng-true-value="'product-in-store'" ng-false-value="'product-in-store'" ng-click="add(urole10)"> Quản lý sản phẩm tồn kho <br/>
                                    <input ng-checked="selected.role.indexOf('input-store') != -1" ng-model="urole11" type="checkbox" ng-true-value="'input-store'" ng-false-value="'input-store'" ng-click="add(urole11)"> Quản lý nhập kho <br/>
                                    <input ng-checked="selected.role.indexOf('store-tranfer') != -1" ng-model="urole13" type="checkbox" ng-true-value="'store-tranfer'" ng-false-value="'store-tranfer'" ng-click="add(urole13)"> Quản lý chuyển kho <br/>
                                    <input ng-checked="selected.role.indexOf('store-output') != -1" ng-model="urole22" type="checkbox" ng-true-value="'store-output'" ng-false-value="'store-output'" ng-click="add(urole22)"> Quản lý xuất kho <br/>
                                    <input ng-checked="selected.role.indexOf('price-input') != -1" ng-model="urole12" type="checkbox" ng-true-value="'price-input'" ng-false-value="'price-input'" ng-click="add(urole12)"> Quản lý bảng giá mua <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kế toán </label> <br/>
                                    <input ng-checked="selected.role.indexOf('account') != -1" ng-model="urole14" type="checkbox" ng-true-value="'account'" ng-false-value="'account'" ng-click="add(urole14)"> Quản lý tài khoản <br/>
                                    <input ng-checked="selected.role.indexOf('voucher') != -1" ng-model="urole15" type="checkbox" ng-true-value="'voucher'" ng-false-value="'voucher'" ng-click="add(urole15)"> Quản lý thu/chi <br/>
                                    <input ng-checked="selected.role.indexOf('customer-invoice') != -1" ng-model="urole16" type="checkbox" ng-true-value="'customer-invoice'" ng-false-value="'customer-invoice'" ng-click="add(urole16)"> Thanh toán đơn hàng <br/>
                                    <input ng-checked="selected.role.indexOf('supplier-invoice') != -1" ng-model="urole17" type="checkbox" ng-true-value="'supplier-invoice'" ng-false-value="'supplier-invoice'" ng-click="add(urole17)"> Thanh toán nhà cung cấp <br/>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label> Báo cáo </label> <br/>
                                    <input ng-checked="selected.role.indexOf('report') != -1" ng-model="urole18" type="checkbox" ng-true-value="'report'" ng-false-value="'report'" ng-click="add(urole18)"> Quản lý báo cáo <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Khách hàng </label> <br/>
                                    <input ng-checked="selected.role.indexOf('customer') != -1" ng-model="urole19" type="checkbox" ng-true-value="'customer'" ng-false-value="'customer'" ng-click="add(urole19)"> Quản lý khách hàng <br/>
                                </div>
                                {{--<div class="col-xs-3">--}}
                                    {{--<label> Khuyến mãi </label>--}}
                                {{--</div>--}}
                                <div class="col-xs-3">
                                    <label> Nhân viên </label> <br/>
                                    <input ng-checked="selected.role.indexOf('user') != -1" ng-model="urole20" type="checkbox" ng-true-value="'user'" ng-false-value="'user'" ng-click="add(urole20)"> Quản lý nhân viên <br/>
                                    <input ng-checked="selected.role.indexOf('position') != -1" ng-model="urole21" type="checkbox" ng-true-value="'position'" ng-false-value="'position'" ng-click="add(urole21)"> Quản lý chức vụ <br/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updatePosition" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updatePosition()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !XÓA CHỨC VỤ!--}}
        <div class="modal fade" id="deletePosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa chức vụ </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa chức vụ này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deletePosition()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/PositionController.js') }}"></script>
@endsection