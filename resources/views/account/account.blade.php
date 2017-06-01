@extends('layouts.app')

@section('title')
    Larose | Danh sách tài khoản
@endsection

@section('location')
    <li> Kế toán </li>
    <li> Danh sách tài khoản </li>
@endsection

@section('content')
    <div ng-controller="AccountController">

        {{-- TÌM KIẾM TÀI KHOẢN--}}
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createAccount">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadAccountTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{accounts.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{-- DANH SÁCH TÀI KHOẢN --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã tài khoản </th>
            <th> Tên tài khoản </th>
            <th> Tổng tiền (VNĐ) </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="accounts.length > 0" class="item" dir-paginate="account in accounts | filter:term | itemsPerPage: 7" ng-click="readAccount(account)">
                <td data-toggle="modal" data-target="#readAccount"> TK-@{{ account.id }} </td>
                <td data-toggle="modal" data-target="#readAccount"> @{{ account.name }} </td>
                <td data-toggle="modal" data-target="#readAccount"> @{{ account.total | number:0 }} </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAccount">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="accounts.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; bottom:0; position: fixed;">
            <dir-pagination-controls></dir-pagination-controls>
        </div>

        {{-- !TẠO TÀI KHOẢN MỚI! --}}
        <div class="modal fade" id="createAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm tài khoản mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Số tài khoản </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.bank_account" type="text" class="form-control input-sm" placeholder="Số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ngân hàng </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.bank" type="text" class="form-control input-sm" placeholder="Ngân hành...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Tổng tiền </label>
                                <div class="col-sm-7">
                                    <input cleave="options.numeral" ng-model="new.total" type="text" class="form-control input-sm input-numeral" placeholder="Tổng tiền...">
                                </div>
                                <div class="col-sm-2">
                                    <select disabled class="form-control input-sm">
                                        <option> VNĐ </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createAccount()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
                    <form enctype="multipart/form-data" action="" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Nhập từ File </h4>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" accept=".xlsx">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- !XEM, SỬA THÔNG TIN TÀI KHOẢN! --}}
        <div class="modal fade" id="readAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel">  </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Số tài khoản </label>
                                <div class="col-sm-9">
                                    <input id="bank_account" ng-model="seleced.bank_account" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ngân hàng </label>
                                <div class="col-sm-9">
                                    <input id="bank" ng-model="selected.bank" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Tổng tiền </label>
                                <div class="col-sm-7">
                                    <input cleave="options.numeral" id="total" ng-model="selected.total" type="text" class="form-control input-sm">
                                </div>
                                <div class="col-sm-2">
                                    <select disabled class="form-control input-sm">
                                        <option> VNĐ </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateAccount" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateAccount()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- XÓA TÀI KHOẢN --}}
        <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa tài khoản </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa tài khoản này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteAccount()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/AccountController.js') }}"></script>
@endsection