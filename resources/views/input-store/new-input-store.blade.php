@extends('layouts.app')

@section('title')
    Larose | Yêu cầu nhập hàng
@endsection

@section('location')
    <li> Yêu cầu nhập hàng </li>
@endsection

@section('content')
    <div ng-controller="StoreController">

        {{-- Thông tin nhập--}}
        <div class="row">
            <div class="col-sm-3">
                <label> Mgày tạo </label>
                <input type="date" class="form-control input-sm">
            </div>
            <div class="col-sm-3">
                <label> Nhà kho </label>
                <select class="form-control input-sm">
                    <option> abc </option>
                </select>
            </div>
            <div class="col-sm-3">
                <label> Nhà cung cấp </label>
                <select class="form-control input-sm">
                    <option> abc </option>
                </select>
            </div>
            <div class="col-sm-3">
                <label> Tài khoản thanh toán </label>
                <select class="form-control input-sm">
                    <option> abc </option>
                </select>
            </div>
        </div>

        <hr/>

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" placeholder="Nhập tên sản phẩm hoặc mã vạch...">
                    <span class="input-group-btn">
                    <button class="btn btn-info btn-sm" type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <button class="btn btn-sm btn-info"> Tổng tiền: 1,000,000 VNĐ </button>
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
            <th> Mã vạch </th>
            <th> Tên </th>
            <th> Đơn vị tính </th>
            <th> Số lượng </th>
            <th> Giá nhập </th>
            <th> Hạn sử dụng </th>
            <th> Thành tiền </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-repeat="store in stores" ng-click="readStore(store)">
                <td> @{{ $index+1 }}</td>
                <td> YC17-0001 </td>
                <td> Công ty 123 </td>
                <td> 19/04/2017 </td>
                <td> 1,000,000 VNĐ </td>
                <td> Kho Linh Đàm </td>
                <td> Duyệt </td>
                <td>
                    abc
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStore">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <hr/>
        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-4 col-xs-2">
                <button class="btn btn-sm btn-primary"> Xem trước </button>
                <button class="btn btn-sm btn-success"> Gửi yêu cầu </button>
                <button class="btn btn-sm btn-danger"> Hủy </button>
            </div>
            <div class="col-lg-2 col-xs-4">

            </div>
            <div class="col-lg-6 col-xs-6">
                <label> Ghi chú </label>
                <textarea class="form-control" rows="5"></textarea>
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