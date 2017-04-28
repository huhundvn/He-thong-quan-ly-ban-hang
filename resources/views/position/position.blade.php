@extends('layouts.app')

@section('title')
    Danh sách chức vụ
@endsection

@section('location')
    <li> Danh sách chức vụ </li>
@endsection

@section('content')
    <div ng-controller="PositionController">

        {{-- TÌM KIẾM DANH MỤC SẢN PHẨM --}}
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createPosition">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <button class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </button>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{positions.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH CHỨC VỤ!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
                <th> STT </th>
                <th> Tên </th>
                <th> Mô tả </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="positions.length > 0" class="item" dir-paginate="position in positions | filter:term | itemsPerPage: 7" ng-click="readPosition(position)">
                <td data-toggle="modal" data-target="#readPosition"> @{{ $index+1 }} </td>
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

        {{-- !TẠO CHỨC VỤ MỚI! --}}
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
                                    <input ng-model="role.num1" type="checkbox"> Quản lý đơn hàng <br/>
                                    <input ng-model="role.num2" type="checkbox"> Quản lý bảng giá <br/>
                                    <input ng-model="role.num3" type="checkbox"> Quản lý trả về <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Sản phẩm </label> <br/>
                                    <input ng-model="role.num4" type="checkbox"> Quản lý sản phẩm <br/>
                                    <input ng-model="role.num5" type="checkbox"> Quản lý nhà cung cấp <br/>
                                    <input ng-model="role.num6" type="checkbox"> Quản lý nhà sản xuất <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kho </label> <br/>
                                    <input ng-model="role.num7" type="checkbox"> Quản lý danh sách kho <br/>
                                    <input ng-model="role.num8" type="checkbox"> Quản lý sản phẩm ở kho <br/>
                                    <input ng-model="role.num9" type="checkbox"> Quản lý nhập hàng <br/>
                                    <input ng-model="role.num10" type="checkbox"> Quản lý xuất kho <br/>
                                    <input ng-model="role.num11" type="checkbox"> Quản lý chuyển kho <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Kế toán </label> <br/>
                                    <input ng-model="role.num12" type="checkbox"> Quản lý tài khoản <br/>
                                    <input ng-model="role.num13" type="checkbox"> Quản lý thu/chi <br/>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label> Báo cáo </label>
                                </div>
                                <div class="col-xs-3">
                                    <label> Khách hàng </label> <br/>
                                    <input ng-model="role.num13" type="checkbox"> Quản lý khách hàng <br/>
                                    <input ng-model="role.num14" type="checkbox"> Quản lý nhóm khách hàng <br/>
                                    <input ng-model="role.num15" type="checkbox"> Xem lịch sử mua hàng <br/>
                                </div>
                                <div class="col-xs-3">
                                    <label> Khuyến mãi </label>
                                </div>
                                <div class="col-xs-3">
                                    <label> Nhân viên </label> <br/>
                                    <input ng-model="role.num16" type="checkbox"> Quản lý nhân viên <br/>
                                    <input ng-model="role.num17" type="checkbox"> Quản lý chức vụ <br/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @{{role}}
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
                    <form enctype="multipart/form-data" action="" method="post"> {{csrf_field()}}
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

        {{-- !XEM, SỬA THÔNG TIN CHỨC VỤ! --}}
        <div class="modal fade" id="readPosition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> </h4>
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