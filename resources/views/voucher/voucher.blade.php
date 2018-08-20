@extends('layouts.app')

@section('title')
    Larose | Danh sách phiếu
@endsection

@section('location')
    <li> Kế toán </li>
    <li> Danh sách phiếu </li>
@endsection

@section('content')
    <div ng-controller="VoucherController">

        {{-- TÌM KIẾM BẢNG GIÁ --}}
        <div class="row">
            <div class="col-lg-4 ">
                <h3></h3>
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#createVoucher">
                    Phiếu thu mới </button>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#createPaymentVoucher">
                    Phiếu chi mới </button>
            </div>
            <div class="col-lg-2 ">
                <label> Từ ngày </label>
                <input ng-model="search.start_date" type="date" class="form-control input-sm" ng-change="searchVoucher()">
            </div>
            <div class="col-lg-2 ">
                <label> Đến ngày </label>
                <input ng-model="search.end_date" type="date" class="form-control input-sm" ng-change="searchVoucher()">
            </div>
            <div class="col-lg-2 ">
                <label> Loại phiếu </label>
                <select ng-model="term2.type" class="form-control input-sm">
                    <option value="" selected> -- Loại -- </option>
                    <option value="0"> Phiếu thu </option>
                    <option value="1"> Phiếu chi </option>
                </select>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH PHIẾU THU/CHI--}}
        <table class="w3-table table-hover table-bordered w3-centered" >
            <thead class="w3-blue-grey">
            <th> Mã </th>
            <th> Ngày lập </th>
            <th> Người tạo </th>
            <th> Người thanh toán </th>
            <th> Loại </th>
            <th> Mô tả </th>
            <th> Tổng tiền (VNĐ) </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="vouchers.length > 0" class="item"
                dir-paginate="voucher in vouchers | filter:term | filter:term2 | itemsPerPage: 8" ng-click="readVoucher(voucher)">
                <td data-toggle="modal" data-target="#readVoucher">
                    <p ng-show="0==voucher.type">PT-@{{ voucher.id }}</p>
                    <p ng-show="1==voucher.type">PC-@{{ voucher.id }}</p>
                </td>
                <td data-toggle="modal" data-target="#readVoucher"> @{{ voucher.created_at | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readVoucher">
                    <p ng-repeat="user in users" ng-show="user.id==voucher.created_by"> @{{ user.name }} </p> </td>
                <td data-toggle="modal" data-target="#readVoucher"> @{{ voucher.name }} </td>
                <td data-toggle="modal" data-target="#readVoucher">
                    <p ng-show="voucher.type==0"> Phiếu thu </p>
                    <p ng-show="voucher.type==1"> Phiếu chi </p> </td>
                <td data-toggle="modal" data-target="#readVoucher">
                    @{{ voucher.description }}
                </td>
                <td data-toggle="modal" data-target="#readVoucher">
                    @{{ voucher.total | number:0 }}
                </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-sm"
                            data-toggle="modal" data-target="#deletePriceOutput">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="vouchers.length==0">
                <td colspan="8"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; position: fixed; bottom: 0">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- THÊM PHIẾU THU MỚI --}}
        <div class="modal fade" id="createVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form id="createUserForm" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm phiếu thu </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Người tạo </label>
                                <div class="">
                                    <input type="text" value="{{Auth::user()->name}}"
                                           class="form-control input-sm" ng-init="new.created_by={{Auth::user()->id}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Người nộp tiền </label>
                                <div class="">
                                    <input ng-model="new.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên người nộp tiền..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Địa chỉ </label>
                                <div class="">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ..." required>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class=""> Số tiền </label>
                                <div class="">
                                    <input cleave="options.numeral" ng-model="new.total" type="text" class="form-control input-sm"
                                           placeholder="Nhập số tiền..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Lý do thu </label>
                                <div class="">
                                    <textarea ng-model="new.description" class="form-control input-sm"> </textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ng-click="createVoucher()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- THÊM PHIẾU CHI MỚI --}}
        <div class="modal fade" id="createPaymentVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form id="createUserForm" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm phiếu chi </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Người chi </label>
                                <div class="">
                                    <input ng-init="newPayment.created_by={{Auth::user()->id}}" type="text" class="form-control input-sm"
                                           value="{{Auth::user()->name}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Tài khoản </label>
                                <div class="">
                                    <select ng-model="newPayment.account_id" class="form-control input-sm" required>
                                        <option value=""> -- Chọn tài khoản thanh toán -- </option>
                                        <option ng-repeat="account in accounts"> @{{account.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Người nhận </label>
                                <div class="">
                                    <input ng-model="newPayment.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên người nhận..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Địa chỉ </label>
                                <div class="">
                                    <input ng-model="newPayment.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ..." required>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class=""> Số tiền </label>
                                <div class="">
                                    <input ng-model="newPayment.total" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Lý do chi </label>
                                <div class="">
                                    <textarea ng-model="newPayment.description" class="form-control input-sm"> </textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ng-click="createPaymentVoucher()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- XEM BIỂU MẪU --}}
        <div class="modal fade" id="readVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Biểu mẫu </h4>
                        </div>
                        <div id="print-content">
                            <style>
                                @media print {
                                    body * {
                                        visibility: hidden;
                                    }
                                    #print-content * {
                                        visibility: visible;
                                    }
                                    .modal{
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                        margin: 0;
                                        padding: 0;
                                    }
                                }
                            </style>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="">
                                        Công ty TNHH Larose <br/>
                                        142 Võ Văn Tân, TP.HCM <br/>
                                        ĐT: 0979369407
                                    </div>
                                    <div class="">
                                        Số: <br/>
                                        Ngày...tháng...năm...
                                    </div>
                                </div>
                                <div class="row">
                                    <h1 align="center">
                                        <b ng-show="0==selected.type"> Phiếu thu </b>
                                        <b ng-show="1==selected.type"> Phiếu chi </b>
                                    </h1>
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div class=" ">
                                        Ngày tạo: @{{ selected.created_at | date: "dd/MM/yyyy"}} <br/>
                                        Họ tên người nộp: @{{ selected.name }} <br/>
                                        Địa chỉ: @{{ selected.address }} <br/>
                                        Lý do: @{{ selected.description }} <br/>
                                        Số tiền: @{{ selected.total | number:0 }} VNĐ <br/>
                                        <br/>
                                    </div>
                                </div>
                                <h1></h1>
                                <div class="row">
                                    <div class="" align="center">
                                        <b> Giám đốc </b><br/> (Ký tên)
                                    </div>
                                    <div class="" align="center">
                                        <b> Người nộp tiền </b><br/> (Ký tên)
                                    </div>
                                    <div class="" align="center">
                                        <b> Kế toán </b> <br/> (Ký tên)
                                    </div>
                                    <div class="" align="center">
                                        <b> Người lập phiếu </b> <br/> (Ký tên)
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer hidden-print">
                                <button type="button" class="btn btn-success btn-sm" ng-click="print()">
                                    <span class="glyphicon glyphicon-print"></span> In
                                </button>
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Đóng </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- XÓA PHIẾU CHI NHẬP --}}
        <div class="modal fade" id="deletePriceOutput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa phiếu </h4>
                </div>
                <div class="modal-body">
                    Bạn thực sự muốn xóa phiếu này?
                </div>
                <div class="modal-footer">
                    <button ng-click="deleteVoucher()" type="submit" class="btn btn-danger"> Xác nhận </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/VoucherController.js') }}"></script>
@endsection