@extends('layouts.app')

@section('title')
    Lịch sử xuất kho
@endsection

@section('location')
    <li> Kho </li>
    <li> Lịch sử xuất kho </li>
@endsection

@section('content')

    <div ng-controller="StoreOutputController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-8 col-xs-8">
                <a href="{{route('createStoreOutput')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Xuất kho </a>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term.store_id" class="form-control input-sm">
                    <option value="" selected> -- Kho xuất -- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{storeOutputs.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{-- DANH SÁCH XUẤT KHO --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã đơn  </th>
            <th> Ngày xuất </th>
            <th> Tạo bởi </th>
            <th> Kho xuất </th>
            <th> Mã đơn hàng </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="storeOutputs.length > 0" class="item"
                dir-paginate="storeOutput in storeOutputs | filter:term | itemsPerPage: 6"
                ng-click="readStoreOutput(storeOutput)">
                <td data-toggle="modal" data-target="#readStoreTranfer"> XK-@{{ storeOutput.id }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeOutput.created_at }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeOutput.user.name }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeOutput.store.name }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> DH-@{{ storeOutput.order_id }} </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteInputStore">
                    <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="storeTranfers.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <dir-pagination-controls max-size="4"></dir-pagination-controls>

        {{-- Xem biểu mẫu --}}
        <div class="modal fade" id="readStoreTranfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="" method="post"> {{csrf_field()}}
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
                                <div class="col-sm-8 col-xs-8">
                                    Công ty TNHH Larose <br/>
                                    142 Võ Văn Tân, TP.HCM <br/>
                                    ĐT: 0979369407
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    Số: <br/>
                                    Ngày...tháng...năm...
                                </div>
                            </div>
                            <div class="row">
                                <h2 align="center"> <b> Phiếu xuất kho </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    Tạo bởi: @{{ selected.user.name }} <br/>
                                    Kho xuất: @{{ selected.store.name }} <br/>
                                    Địa chỉ: @{{ selected.store.address }} <br/>
                                    Số điện thoại: @{{ selected.store.phone }} <br/>
                                    Đơn hàng: DH-@{{ selected.order_id }} <br/>
                                </div>
                            </div>
                            <div class="row">
                                <table class="w3-table table-bordered w3-centered">
                                    <thead>
                                    <th> Mã SP </th>
                                    <th> Tên </th>
                                    <th> Mã vạch </th>
                                    <th> Đơn vị tính </th>
                                    <th> Số lượng </th>
                                    <th> Giá nhập (VNĐ) </th>
                                    <th> Giá bán (VNĐ) </th>
                                    <th> Hạn sử dụng </th>
                                    </thead>
                                    <tbody>
                                    <tr ng-show="detail.length > 0" class="item" dir-paginate="item in detail | itemsPerPage: 4">
                                        <td> SP-@{{ item.product_id }}</td>
                                        <td> @{{ item.name }} </td>
                                        <td> @{{ item.code }} </td>
                                        <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id"> @{{ unit.name }} </td>
                                        <td> @{{ item.quantity | number: 0}} </td>
                                        <td> @{{ item.price_input | number: 0 }} </td>
                                        <td> @{{ item.price_output | number: 0 }} </td>
                                        <td> @{{ item.expried_date | date: "dd/MM/yyyy" }} </td>
                                    </tr>
                                    <tr class="item" ng-show="selected.detail_store_tranfers.length==0">
                                        <td colspan="9"> Không có dữ liệu </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h1></h1>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-xs-4" align="center">
                                    <b> Quản lý kho </b><br/> (Ký tên)
                                </div>
                                <div class="col-lg-4 col-xs-4" align="center">
                                    <b> Kế toán </b> <br/> (Ký tên)
                                </div>
                                <div class="col-lg-4 col-xs-4" align="center">
                                    <b> Người lập phiếu </b> <br/> (Ký tên)
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm" ng-click="print()">
                                <span class="glyphicon glyphicon-print"></span> In
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- XÓA YÊU CẦU --}}
        <div class="modal fade" id="deleteInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa xuất kho </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa xuất kho này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteStoreOutput()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/StoreOutputController.js') }}"></script>
@endsection