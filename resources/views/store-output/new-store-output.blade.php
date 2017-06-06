@extends('layouts.app')

@section('title')
    Xuất kho
@endsection

@section('location')
    <li> Xuất kho </li>
    <li> Yêu cầu xuất kho </li>
@endsection

@section('content')
    <div ng-controller="StoreOutputController">

        {{-- NHẬP SẢN PHẨM --}}
        <div class="row">
            <div class="col-lg-3 col-xs-4">
                <button type="submit" class="btn btn-success btn-sm" ng-click="createStoreOutput()"> Xác nhận </button>
                <a href="{{route('list-store-output')}}" class="btn btn-default btn-sm"> Quay lại </a>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#chooseProduct"> Chọn SP xuất kho</button>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="new.store_id" class="form-control input-sm" ng-change="loadOrder(info.order_id)">
                    <option value="" selected> -- Kho xuất -- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="info.order_id" class="form-control input-sm" ng-change="loadOrder(info.order_id)">
                    <option value="" selected> -- Đơn hàng cần xuất -- </option>
                    <option ng-repeat="order in orders" value="@{{order.id}}"> DH-@{{order.id}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readInputStore"> Xem đơn hàng </button>
            </div>
        </div>
        <hr/>
        {{-- Danh sách mặt hàng --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Tên </th>
            <th> Mã vạch </th>
            <th> Đơn vị tính </th>
            <th> Số lượng mua </th>
            <th> Số lượng trong kho </th>
            <th> Còn lại </th>
            <th> Giá nhập </th>
            <th> Giá bán </th>
            <th> Hạn sử dụng </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="data.length > 0" class="item" dir-paginate="item in data | itemsPerPage: 4">
                <td> @{{ item.name }} </td>
                <td> @{{ item.code }} </td>
                <td> @{{ item.unit.name }} </td>
                <td> @{{ item.quantity | number:0}} </td>
                <td> @{{ item.quantity_in_store | number:0 }}</td>
                <td> @{{ item.quantity_in_store - item.quantity | number:0}} </td>
                <td> @{{ item.price_input | number:0}} </td>
                <td> @{{ item.price | number:0}} </td>
                <td> @{{ item.expried_date | date: "dd/MM/yyyy" }} </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-sm" ng-click="delete(item)">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="data.length==0">
                <td colspan="10"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%;">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- CHỌN SẢN PHẨM --}}
        <div class="modal fade" id="chooseProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-blue" id="myModalLabel"> Chọn sản phẩm trong kho </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <input ng-model="term.name" type="text" class="form-control input-sm">
                            </div>
                            <div class="col-sm-4">
                                <select ng-model="new.store_id" class="form-control input-sm">
                                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                                </select>
                            </div>
                        </div>
                        <h1></h1>
                        {{-- !DANH SÁCH SẢN PHẨM! --}}
                        <table class="w3-table table-hover table-bordered w3-centered">
                            <thead>
                            <tr class="w3-blue-grey">
                                <th> Mã SP </th>
                                <th> Tên </th>
                                <th> Mã vạch </th>
                                <th> Đơn vị tính </th>
                                <th> Số lượng hiện có </th>
                                <th> Giá mua </th>
                                <th> Hạn sử dụng </th>
                                <th> Kho </th>
                            </thead>
                            <tbody>
                            <tr class="item"
                                ng-show="productInStores.length > 0" ng-repeat="product in productInStores | filter:term | filter:new | itemsPerPage: 5"
                                ng-click="add(product)" pagination-id="product">
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{$index+1}} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.name}} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.code }}</td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.unit.name }} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.quantity | number: 0 }} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.price_input | number: 0 }} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.expried_date | date: "dd/MM/yyyy" }} </td>
                                <td ng-repeat="item in data" ng-if="item.product_id==product.product_id"> @{{ product.store.name }} </td>
                            </tr>
                            <tr class="item" ng-show="products.length==0">
                                <td colspan="7"> Không có dữ liệu </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- <div style="margin-left: 35%;">
                            <dir-pagination-controls pagination-id="product" max-size="4"> </dir-pagination-controls>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        {{-- Xem biểu mẫu --}}
        <div class="modal fade" id="readInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Biểu mẫu </h4>
                        </div>
                        <div id="print-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-8">
                                        Công ty TNHH Larose <br/>
                                        142 Võ Văn Tân, TP.HCM <br/>
                                        ĐT: 0979369407
                                    </div>
                                    <div class="col-xs-4">
                                        Số: <br/>
                                        Ngày...tháng...năm...
                                    </div>
                                </div>
                                <div class="row">
                                    <h2 align="center"> <b> Đơn hàng </b> </h2>
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        Khách hàng: @{{ selectedOrder.customer.name }} <br/>
                                        Địa chỉ: @{{ selectedOrder.customer.address }} <br/>
                                        Số điện thoại: @{{ selectedOrder.customer.phone }}
                                    </div>
                                    <div class="col-xs-6">
                                        Người nhận hàng: @{{ selectedOrder.contact_name }} <br/>
                                        Địa chỉ giao hàng: @{{ selectedOrder.contact_address }} <br/>
                                        Số điện thoại: @{{ selectedOrder.contact_phone }}
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-xs-6">
                                        Người tạo: @{{ selectedOrder.user.name }} <br/>
                                        Bảng giá áp dụng: @{{ selectedOrder.price_output.name }} <br/>
                                        Phương thức thanh toán: @{{ selectedOrder.payment_method }} <br/>
                                        Ghi chú: @{{ selectedOrder.note }}
                                    </div>
                                    <div class="col-xs-6">
                                        Thuế VAT: @{{ selectedOrder.tax }}% <br/>
                                        Giảm giá: @{{ selectedOrder.discount }} (VNĐ) <br/>
                                        Tổng tiền: @{{ selectedOrder.total | number:0 }} (VNĐ) <br/>
                                    </div>
                                </div>
                                <h1></h1>

                                <div class="row">
                                    <table class="w3-table table-bordered w3-centered">
                                        <thead>
                                        <th> Mã SP </th>
                                        <th> Mã vạch </th>
                                        <th> Tên </th>
                                        <th> Đơn vị tính </th>
                                        <th> Số lượng </th>
                                        <th> Đơn giá (VNĐ) </th>
                                        <th> Thành tiền (VNĐ) </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-show="data.length > 0" class="item" ng-repeat="item in data">
                                            <td> SP-@{{ item.product_id }}</td>
                                            <td> @{{ item.code }} </td>
                                            <td> @{{ item.name }} </td>
                                            <td> @{{ item.unit.name }} </td>
                                            <td> @{{ item.quantity }} </td>
                                            <td> @{{ item.price | number:0 }} </td>
                                            <td> @{{ item.quantity * item.price | number: 0 }} </td>
                                        </tr>
                                        <tr class="item" ng-show="data.length==0">
                                            <td colspan="9"> Không có dữ liệu </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1></h1>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3" align="center">
                                        <b> Nhân viên bán hàng </b><br/> (Ký tên)
                                    </div>
                                    <div class="col-xs-3" align="center">
                                        <b> Khách hàng </b> <br/> (Ký tên)
                                    </div>
                                    <div class="col-xs-3" align="center">
                                        <b> Quản lý kho </b> <br/> (Ký tên)
                                    </div>
                                    <div class="col-xs-3" align="center">
                                        <b> Người lập phiếu </b> <br/> (Ký tên)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer hidden-print">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Đóng </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')

    <script src="{{ asset('angularJS/StoreOutputController.js') }}"></script>
@endsection