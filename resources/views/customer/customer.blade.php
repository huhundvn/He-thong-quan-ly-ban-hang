@extends('layouts.app')

@section('title')
    Danh sách khách hàng
@endsection

@section('location')
    <li> Quản lý khách hàng </li>
@endsection

@section('content')
    <div ng-controller="CustomerController">

        {{-- !TÌM KIẾM KHÁCH HÀNG!--}}
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCustomer">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadCustomerTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
                <button class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-print"></span> In </button>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-change="searchCustomer()" ng-model="term" class="form-control input-sm" placeholder="Nhập tên khách hàng...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{customers.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH KHÁCH HÀNG!--}}
        <table id="listCustomer" class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã KH </th>
            <th> Tên khách hàng </th>
            <th> Email </th>
            <th> Số điện thoại </th>
            <th> Địa chỉ </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="customers.length > 0" dir-paginate="customer in customers | itemsPerPage: 7" ng-click="readCustomer(customer)">
                <td data-toggle="modal" data-target="#readCustomer"> KH-@{{ customer.id}} </td>
                <td data-toggle="modal" data-target="#readCustomer"> @{{ customer.name}} </td>
                <td data-toggle="modal" data-target="#readCustomer"> @{{ customer.email}}</td>
                <td data-toggle="modal" data-target="#readCustomer"> @{{ customer.phone}} </td>
                <td data-toggle="modal" data-target="#readCustomer"> @{{ customer.address}} </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUser">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="customers.length==0">
                <td colspan="6"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; bottom:0; position: fixed;">
            <dir-pagination-controls></dir-pagination-controls>
        </div>

        {{-- !TẠO KHÁCH HÀNG MỚI! --}}
        <div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm khách hàng mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên đầy đủ </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Email </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Số điện thoại </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại..." value="{{old('phoneUser')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ..." value="{{old('addressUser')}}">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Tài khoản ngân hàng </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.bank_account" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ngân hàng </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.bank" type="text" class="form-control input-sm" placeholder="Nhập ngân hàng...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Nhóm khách hàng </label>
                                <div class="col-sm-9">
                                    <select ng-model="newCustomer.customer_group_id" class="form-control input-sm">
                                        <option ng-repeat="x in customerGroups" value="@{{x.id}}"> @{{x.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ghi chú </label>
                                <div class="col-sm-9">
                                    <textarea ng-model="newCustomer.note" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createCustomer()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
                    <form enctype="multipart/form-data" action="{{route('importCustomerFromFile')}}" method="post"> {{csrf_field()}}
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

        {{-- !XEM, SỬA KHÁCH HÀNG! --}}
        <div class="modal fade" id="readCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên đầy đủ </label>
                                <div class="col-sm-9">
                                    <input id="name" ng-model="selectedCustomer.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Email </label>
                                <div class="col-sm-9">
                                    <input id="email" ng-model="selectedCustomer.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Số điện thoại </label>
                                <div class="col-sm-9">
                                    <input id="phone" ng-model="selectedCustomer.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input id="address" ng-model="selectedCustomer.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Tài khoản ngân hàng </label>
                                <div class="col-sm-9">
                                    <input id="bank_account" ng-model="selectedCustomer.bank_account" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ngân hàng </label>
                                <div class="col-sm-9">
                                    <input id="bank" ng-model="selectedCustomer.bank" type="text" class="form-control input-sm" placeholder="Nhập ngân hàng...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Nhóm khách hàng </label>
                                <div class="col-sm-9">
                                    <select id="customer_group" ng-model="selectedCustomer.customer_group_id" class="form-control">
                                        <option ng-repeat="x in customerGroups" value="@{{x.id}}"
                                                ng-selected="x.id === selectedCustomer.customer_group_id"> @{{x.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ghi chú </label>
                                <div class="col-sm-9">
                                    <textarea id="note" ng-model="selectedCustomer.note" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateCustomer" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateCustomer()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !XÓA KHÁCH HÀNG!--}}
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa khách hàng </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa khách hàng này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteCustomer()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/CustomerController.js') }}"></script>
@endsection