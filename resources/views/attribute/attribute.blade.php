@extends('layouts.app')

@section('title')
    Larose | Danh sách thuộc tính
@endsection

@section('location')
    <li> Thuộc tính sản phẩm </li>
@endsection

@section('content')
    <div ng-controller="AttributeController">

        {{-- !TÌM KIẾM THUỘC TÍNH!--}}
        <div class="row">
            <div class="col-lg-2 col-xs-4">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#createAttribute"> Thêm mới
                    </button>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li> <a href="#" data-toggle="modal" data-target="#inputFromFile">
                                <span class="glyphicon glyphicon-file"></span> Nhập từ file </a> </li>
                        <li class="divider"></li>
                        <li> <a href="">
                                <span class="glyphicon glyphicon-download-alt"></span> Tải mẫu nhập </a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <button class="btn btn-sm btn-info"> @{{from}}-@{{to}} trong tổng số @{{total}} </button>
            </div>
            <div class="col-lg-4 col-xs-6">
                <input ng-change="searchAttribute" ng-model="term" class="form-control input-sm" placeholder="Nhập tên thuộc tính...">
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH THUỘc TÍNH!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
                <th> Tên </th>
                <th> Mô tả </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-repeat="attribute in attributes" ng-click="readAttribute(attribute)">
                <td data-toggle="modal" data-target="#readAttribute"> @{{ unit.name }} </td>
                <td data-toggle="modal" data-target="#readAttribute"> @{{ unit.description }}</td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAttribute">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        {{-- !PHÂN TRANG! --}}
        <div align="center">
            <ul class="pagination">
                <li> <span ng-click="change(prev_page_url)"> &laquo; </span>  </li>
                <li> <span> @{{current_page}}/@{{last_page}} </span> </li>
                <li> <span ng-click="change(next_page_url)"> &raquo; </span> </li>
            </ul>
        </div>

        {{-- !TẠO THUỘC TÍNH MỚI! --}}
        <div class="modal fade" id="createAttribute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm thuộc tính mới </h4>
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
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createAttribute()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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

        {{-- !XEM, SỬA THÔNG TIN THUỘC TÍNH! --}}
        <div class="modal fade" id="readAttribute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <button id="updateAttribute" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateAttribute()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !XÓA NHÀ CUNG CẤP!--}}
        <div class="modal fade" id="deleteAttribute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa thuộc tính </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa thuộc tính này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteUnit()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/AttributeController.js') }}"></script>
@endsection