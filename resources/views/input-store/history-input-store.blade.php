@extends('layouts.app')

@section('title')
    Larose | Lịch sử nhập kho
@endsection

@section('location')
    <li> Danh sách nhập kho </li>
@endsection

@section('content')
    <div ng-controller="StoreController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <a href="{{route('createInputStore')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </a>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadProductTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
                <button class="btn btn-sm btn-default">
                    <span class="glyphicon glyphicon-print"></span> In </button>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-change="searchProduct()" ng-model="term" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{products.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH KHO CỬA HÀNG!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> STT </th>
            <th> Mã đơn hàng </th>
            <th> Nhà cung cấp </th>
            <th> Ngày tạo </th>
            <th> Tổng tiền </th>
            <th> Kho hàng </th>
            <th> Trạng thái </th>
            <th> Duyệt </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-repeat="store in stores" ng-click="readStore(store)">
                <td data-toggle="modal" data-target="#readStore"> @{{ $index+1 }}</td>
                <td data-toggle="modal" data-target="#readStore"> YC17-0001 </td>
                <td data-toggle="modal" data-target="#readStore"> Công ty 123 </td>
                <td data-toggle="modal" data-target="#readStore"> 19/04/2017 </td>
                <td data-toggle="modal" data-target="#readStore">
                    1,000,000 VNĐ
                </td>
                <td data-toggle="modal" data-target="#readStore">
                    Kho Linh Đàm
                </td>
                <td>
                    Duyệt
                </td>
                <td>
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#deleteStore">
                        <span class="glyphicon glyphicon-asterisk"></span>
                    </button>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStore">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

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