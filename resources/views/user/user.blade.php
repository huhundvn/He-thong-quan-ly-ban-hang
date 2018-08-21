@extends('layouts.app')

@section('title')
    Danh sách nhân viên
@endsection

@section('location')
    <li> Nhân viên </li>
    <li> Danh sách nhân viên </li>
@endsection

@section('content')
    <div ng-controller="UserController">

        {{-- TÌM KIẾM NHÂN VIÊN --}}
        <div class="row">
            <div class="col-lg-6 ">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createUser">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadUserTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-2 ">
                <input ng-model="term.name" class="form-control input-sm" placeholder="Nhập tên...">
            </div>
            <div class="col-lg-2 ">
                <select ng-model="term2.status" class="form-control input-sm">
                    <option value=""> --Trạng thái--</option>
                    <option value="1"> Hoạt động </option>
                    <option value="0"> Dừng hoạt động </option>
                </select>
            </div>
            <div class="col-lg-2 ">
                <button class="btn btn-sm btn-info"> Tổng số: @{{users.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH NHÂN VIÊN --}}
        <div class="table-responsive"><table id="listUser" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã </th>
                <th> @lang('user.name') </th>
                <th> @lang('user.email') </th>
                <th> @lang('user.phone') </th>
                <th> @lang('user.workplace') </th>
                <th> @lang('user.position') </th>
                <th> @lang('user.status') </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="users.length > 0" class="item" dir-paginate="user in users | filter:term | filter:term2 | itemsPerPage: 7" ng-click="readUser(user)">
                <td data-toggle="modal" data-target="#readUser"> NV-@{{ user.id}} </td>
                <td data-toggle="modal" data-target="#readUser"> @{{ user.name}} </td>
                <td data-toggle="modal" data-target="#readUser"> @{{ user.email}}</td>
                <td data-toggle="modal" data-target="#readUser"> @{{ user.phone}} </td>
                <td data-toggle="modal" data-target="#readUser">
                    <p ng-repeat="store in stores" ng-show="store.id === user.work_place_id"> @{{store.name}} </p>
                </td>
                <td data-toggle="modal" data-target="#readUser">
                    <p ng-repeat="position in positions" ng-show="position.id === user.position_id"> @{{position.name}} </p>
                </td>
                <td data-toggle="modal" data-target="#readUser">
                    <p ng-show="user.status==1"> Hoạt động </p>
                    <p ng-show="user.status==0"> Dừng hoạt động </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUser" ng-show="0==user.status">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="users.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>

        {{-- PHÂN TRANG --}}
        <div class="text-center">
            <dir-pagination-controls></dir-pagination-controls>
        </div>

        <!-- !THÊM NHÂN VIÊN MỚI! -->
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form id="createUserForm" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm nhân viên mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="new.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Email </label>
                                <div class="">
                                    <input ng-model="new.email" type="email" class="form-control input-sm"
                                           placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mật khẩu </label>
                                <div class="">
                                    <input ng-model="new.pass" type="text" class="form-control input-sm"
                                           placeholder="Nhập mật khẩu...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Số điện thoại </label>
                                <div class="">
                                    <input ng-model="new.phone" type="text" class="form-control input-sm"
                                           placeholder="Nhập số điện thoại...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Địa chỉ </label>
                                <div class="">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="">Nơi làm việc </label>
                                <div class="">
                                    <select ng-model="new.work_place_id" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Phân quyền </label>
                                <div class="">
                                    <select ng-model="new.position_id" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-repeat="position in positions" value="@{{position.id}}"> @{{position.name}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createUser()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- !NHẬP TỪ FILE! -->
        <div class="modal fade" id="inputFromFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="{{route('importUserFromFile')}}" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Nhập từ File </h4>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" accept=".xlsx" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- !THÔNG TIN CHI TIẾT NHÂN VIÊN! -->
        <div class="modal fade" id="readUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thông tin nhân viên </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="selected.name" id="nameUser" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Email </label>
                                <div class="">
                                    <input ng-model="selected.email" id="emailUser" type="email" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Số điện thoại </label>
                                <div class="">
                                    <input ng-model="selected.phone" id="phoneUser" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Địa chỉ </label>
                                <div class="">
                                    <input ng-model="selected.address" id="addressUser" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class=""> Nơi làm việc </label>
                                <div class="">
                                    <select id="workplace" ng-model="selected.work_place_id" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-repeat="store in stores" ng-selected="store.id === selected.work_place_id" value="@{{store.id}}"> @{{store.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Phân quyền </label>
                                <div class="">
                                    <select id="position" ng-model="selected.position_id" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-repeat="position in positions" ng-selected="position.id === selected.position_id" value="@{{position.id}}"> @{{position.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Tình trạng </label>
                                <div class="">
                                    <select id="status" ng-model="selected.status" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-selected="1 === selected.status" value="1"> Hoạt động </option>
                                        <option ng-selected="0 === selected.status" value="0"> Dừng hoạt động </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateUser" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateUser()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- !XÓA NHÂN VIÊN! -->
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa nhân viên </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa nhân viên này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteUser()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('angularJS/UserController.js') }}"></script>
@endsection