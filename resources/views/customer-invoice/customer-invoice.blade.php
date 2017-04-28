@extends('layouts.app')

@section('title')
    Larose | Hóa đơn khách hàng
@endsection

@section('location')
    <li> Kế toán </li>
    <li> Khách hàng thanh toán </li>
@endsection

@section('content')

    <div ng-controller="OrderController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <a href="{{ route('createCustomerInvoice') }}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Tạo mới </a>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term.id" class="form-control input-sm" placeholder="Nhập tên nhà cung cấp...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.created_by" class="form-control input-sm">
                    <option value="" selected> -- Nhân viên -- </option>
                    <option ng-repeat="user in users" value="@{{user.id}}"> NV@{{user.id}} - @{{user.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Chờ duyệt </option>
                    <option value="0"> Đã từ chối </option>
                    <option value="2"> Đã xác nhận </option>
                    <option value="3"> Đã nhập kho </option>s
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{orders.length}} mục </button>
            </div>
        </div>
        <hr/>

        {{-- DANH SÁCH ĐƠN HÀNG --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã hóa đơn  </th>
            <th> Ngày thanh toán </th>
            <th> Tạo bởi </th>
            <th> Khách hàng </th>
            <th> Mã đơn hàng </th>
            <th> Tổng tiền </th>
            <th> Khách đã trả </th>
            <th> Trạng thái </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="orders.length > 0" class="item"
                dir-paginate="order in orders | filter:term | filter:term2 | filter:term3 | itemsPerPage: 7" ng-click="readOrder(order)">
                <td data-toggle="modal" data-target="#readInputStore"> DH-@{{ order.id }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.created_at | date: "dd/MM/yyyy" }} </td>
                <td data-toggle="modal" data-target="#readInputStore" ng-repeat="user in users" ng-show="user.id == order.created_by">
                    @{{ user.name }}
                </td>
                <td data-toggle="modal" data-target="#readInputStore" ng-repeat="customer in customers" ng-show="customer.id==order.customer_id">
                    @{{ customer.name }}
                </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.total | number:0 }} VNĐ </td>
                <td data-toggle="modal" data-target="#readInputStore">
                    <p ng-show="0==order.status"> Đã hủy </p>
                    <p ng-show="1==order.status"> Chờ duyệt </p>
                    <p ng-show="2==order.status"> Đã duyệt, đang ship hàng </p>
                    <p ng-show="3==order.status"> Đã giao hàng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeInputStore">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td>
                    <button ng-show="0==order.status" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteInputStore">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="orders.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <dir-pagination-controls max-size="4"></dir-pagination-controls>

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
                                        <div ng-repeat="customer in customers" ng-show="customer.id==selected.customer_id">
                                            Khách hàng: @{{ customer.name }} <br/>
                                            Địa chỉ: @{{ customer.address }} <br/>
                                            Số điện thoại: @{{ customer.phone }}
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        Người nhận hàng: @{{ selected.contact_name }} <br/>
                                        Địa chỉ giao hàng: @{{ selected.contact_address }} <br/>
                                        Số điện thoại: @{{ selected.contact_phone }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <hr/>
                                        Phương thức thanh toán: @{{ selected.payment_method }} <br/>
                                        Tổng tiền: @{{ selected.total | number:0 }} VNĐ <br/>
                                        Ghi chú: @{{ selected.note }}
                                    </div>
                                </div>
                                <h1></h1>

                                <div class="row">
                                    <table class="w3-table table-bordered w3-centered">
                                        <thead>
                                        <th> STT </th>
                                        <th> Mã vạch </th>
                                        <th> Tên </th>
                                        <th> Đơn vị tính </th>
                                        <th> Số lượng </th>
                                        <th> Đơn giá (VNĐ) </th>
                                        <th> Thành tiền (VNĐ) </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-show="selected.order_details.length > 0" class="item" ng-repeat="item in selected.order_details">
                                            <td> @{{ item.product_id }}</td>
                                            <td ng-repeat="product in products" ng-show="product.id==item.product_id">
                                                @{{ product.code }}
                                            </td>
                                            <td ng-repeat="product in products" ng-show="product.id==item.product_id">
                                                @{{ product.name }}
                                            </td>
                                            <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">
                                                @{{ unit.name }}
                                            </td>
                                            <td> @{{ item.quantity }} </td>
                                            <td> @{{ item.price | number:0 }} </td>
                                            <td> @{{ item.quantity * item.price | number: 0 }} </td>
                                        </tr>
                                        <tr class="item" ng-show="selected.order_details.length==0">
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
                            <button type="button" class="btn btn-success btn-sm" ng-click="print()">
                                <span class="glyphicon glyphicon-print"></span> In
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Đóng </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- THAY ĐỔI TRẠNG THÁI NHẬP HÀNG --}}
        <div class="modal fade" id="changeInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Xác nhận đơn hàng </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Trạng thái </label>
                                <div class="col-sm-9">
                                    <select ng-model="newStatus" class="form-control input-sm" required>
                                        <option value="" selected> -- Trạng thái -- </option>
                                        <option value="2"> Xác nhận đơn hàng </option>
                                        <option value="0"> Hủy đơn hàng </option>
                                        <option value="3"> Đã nhập vào kho </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="changeStatus()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- XÓA ĐƠN HÀNG --}}
        <div class="modal fade" id="deleteInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa đơn hàng </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa đơn hàng này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteOrder()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/OrderController.js') }}"></script>
@endsection