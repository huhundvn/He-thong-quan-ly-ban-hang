@extends('layouts.app')

@section('title')
    Danh sách khách hàng
@endsection

@section('location')
    <li> Kho </li>
    <li> Danh sách kho, cửa hàng </li>
@endsection

@section('content')
    <div ng-controller="StoreController">

        {{-- !TÌM KIẾM KHO / CỬA HÀNG!--}}
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createStore">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadStoreTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-2 col-xs-2">
                <input ng-model="term.name" class="form-control input-sm" placeholder="Nhập tên kho...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.type" class="form-control input-sm">
                    <option value="" selected> -- Loại -- </option>
                    <option value="1"> Cửa hàng </option>
                    <option value="0"> Kho </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Hoạt động </option>
                    <option value="0"> Dừng hoạt động </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{stores.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{--!DANH SÁCH KHO CỬA HÀNG!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
                <th> STT </th>
                <th> Tên kho </th>
                <th> Địa chỉ </th>
                <th> Số điện thoại </th>
                <th> Loại </th>
                <th> Trạng thái </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="stores.length > 0" dir-paginate="store in stores | filter:term | filter:term2 | filter:term3 | itemsPerPage: 7" ng-click="readStore(store)">
                <td data-toggle="modal" data-target="#readStore"> @{{ $index+1 }} </td>
                <td data-toggle="modal" data-target="#readStore"> @{{ store.name }} </td>
                <td data-toggle="modal" data-target="#readStore"> @{{ store.address }}</td>
                <td data-toggle="modal" data-target="#readStore"> @{{ store.phone }} </td>
                <td data-toggle="modal" data-target="#readStore">
                    <p ng-show="store.type==0"> Kho </p>
                    <p ng-show="store.type==1"> Cửa hàng </p>
                </td>
                <td data-toggle="modal" data-target="#readStore">
                    <p ng-show="store.status==1"> Hoạt động </p>
                    <p ng-show="store.status==0"> Dừng hoạt động </p>
                </td>
                <td>
                    <button  ng-show="0==store.status" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStore">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="stores.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 40%">
            <dir-pagination-controls></dir-pagination-controls>
        </div>

        {{-- !TẠO KHO CỬA HÀNG MỚI! --}}
        <div class="modal fade" id="createStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm kho/cửa hàng mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Email </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Số điện thoại </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại..." value="{{old('phoneUser')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ..." value="{{old('addressUser')}}">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Quản lý bởi </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.managed_by" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Loại </label>
                                <div class="col-sm-9">
                                    <select ng-model="new.type" class="form-control input-sm">
                                        <option value=""> --Không chọn-- </option>
                                        <option value="0"> Nhà kho </option>
                                        <option value="1"> Cửa hàng </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" ng-show="1 == new.type">
                                <label class="col-sm-3"> Kho hàng </label>
                                <div class="col-sm-9">
                                    <select ng-model="new.store_id" class="form-control input-sm">
                                        <option ng-repeat="storage in storages" value="@{{storage.id}}"> @{{storage.name}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createStore()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
                    <form action="{{route('importStoreFromFile')}}" enctype="multipart/form-data" method="post"> {{csrf_field()}}
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

        {{-- !XEM, SỬA THÔNG TIN KHO HÀNG! --}}
        <div class="modal fade" id="readStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm kho mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên kho </label>
                                <div class="col-sm-9">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Email </label>
                                <div class="col-sm-9">
                                    <input id="email" ng-model="selected.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Số điện thoại </label>
                                <div class="col-sm-9">
                                    <input id="phone" ng-model="selected.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input id="address" ng-model="selected.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Quản lý bởi </label>
                                <div class="col-sm-9">
                                    <input id="managed_by" ng-model="selected.managed_by" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Loại </label>
                                <div class="col-sm-9">
                                    <select id="type" ng-model="selected.type" class="form-control input-sm">
                                        <option value=""> --Không chọn-- </option>
                                        <option ng-selected="0 === selected.type" value="0"> Nhà kho </option>
                                        <option ng-selected="1 === selected.type" value="1"> Cửa hàng </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" ng-show="1 == selected.type">
                                <label class="col-sm-3"> Kho hàng </label>
                                <div class="col-sm-9">
                                    <select id="storage" ng-model="selected.store_id" class="form-control input-sm">
                                        <option value=""> --Không chọn-- </option>
                                        <option ng-repeat="storage in storages" ng-selected="storage.id === selected.store_id" value="@{{storage.id}}"> @{{storage.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Trạng thái </label>
                                <div class="col-sm-9">
                                    <select id="status" ng-model="selected.status" class="form-control input-sm">
                                        <option value=""> --Không chọn-- </option>
                                        <option ng-selected="1 === selected.status" value="1"> Hoạt động </option>
                                        <option ng-selected="0 === selected.status" value="0"> Dừng hoạt động </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateStore" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateStore()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !XÓA KHO HÀNG!--}}
        <div class="modal fade" id="deleteStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa kho/cửa hàng </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa kho/cửa hàng này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteStore()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/StoreController.js') }}"></script>
@endsection