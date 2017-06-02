@extends('layouts.app')

@section('title')
    Hóa đơn khách hàng
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
                <label> Khách hàng </label>
                <select ng-model="term.customer_id" class="form-control input-sm">
                    <option value="" selected> -- Khách hàng  -- </option>
                    <option ng-repeat="customer in customers" value="@{{customer.id}}"> @{{customer.name}} - @{{customer.address}}</option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Người tạo </label>
                <select ng-model="term2.created_by" class="form-control input-sm">
                    <option value="" selected> -- Nhân viên -- </option>
                    <option ng-repeat="user in users" value="@{{user.id}}"> NV@{{user.id}} - @{{user.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Từ ngày </label>
                <input ng-model="search.start_date" type="date" class="form-control input-sm" ng-change="searchOrder()">
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Đến ngày </label>
                <input ng-model="search.end_date" type="date" class="form-control input-sm" ng-change="searchOrder()">
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Trạng thái </label>
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="2"> Đã xác nhận </option>
                    <option value="3"> Đang giao  </option>
                    <option value="4"> Đã thanh toán </option>s
                </select>
            </div>
        </div>
        <hr/>

        {{-- DANH SÁCH ĐƠN HÀNG --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Ngày thanh toán </th>
            <th> Mã đơn hàng </th>
            <th> Thanh toán bởi </th>
            <th> Khách hàng </th>
            <th> Tổng tiền (VNĐ) </th>
            <th> Khách đã trả (VNĐ) </th>
            <th> Còn nợ (VNĐ) </th>
            <th> Thanh toán </th>
            </thead>
            <tbody>
            <tr ng-show="orders.length > 0" class="item"
                dir-paginate="order in paidOrders | filter:term | filter:term2 | filter:term3 | itemsPerPage: 7" ng-click="readOrder(order)">
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.updated_at  }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> DH-@{{ order.id }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.user.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.customer.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.total | number:0 }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.total_paid | number:0 }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ order.total - order.total_paid | number:0 }} </td>
                <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeInputStore" ng-show="order.total - order.total_paid != 0">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="orders.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; position: fixed; bottom: 0">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
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
                                <hr/>
                                <div class="row">
                                    <div class="col-xs-6">
                                        Người tạo: @{{ selected.user.name }} <br/>
                                        Bảng giá áp dụng: @{{ selected.price_output.name }} <br/>
                                        Phương thức thanh toán: @{{ selected.payment_method }} <br/>
                                        Ghi chú: @{{ selected.note }}
                                    </div>
                                    <div class="col-xs-6">
                                        Thuế VAT: @{{ selected.tax }}% <br/>
                                        Giảm giá: @{{ selected.discount }} (VNĐ) <br/>
                                        Tổng tiền: @{{ selected.total | number:0 }} (VNĐ) <br/>
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
                                        <tr ng-show="detail.length > 0" class="item" ng-repeat="item in detail">
                                            <td> SP-@{{ item.product_id }}</td>
                                            <td> @{{ item.code }} </td>
                                            <td> @{{ item.name }} </td>
                                            <td> @{{ item.unit.name }} </td>
                                            <td> @{{ item.quantity }} </td>
                                            <td> @{{ item.price | number:0 }} </td>
                                            <td> @{{ item.quantity * item.price | number: 0 }} </td>
                                        </tr>
                                        <tr class="item" ng-show="detail.length==0">
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

        {{-- THANH TOÁN ĐƠN HÀNG --}}
        <div class="modal fade" id="changeInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thanh toán đơn hàng </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tổng tiền </label>
                                <div class="col-sm-9">
                                    <input type="text" cleave="options.numeral" ng-model="selected.total" class="form-control input-sm" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Đã thanh toán </label>
                                <div class="col-sm-9">
                                    <input type="text" cleave="options.numeral" ng-model="selected.total_paid" class="form-control input-sm" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Thanh toán thêm </label>
                                <div class="col-sm-9">
                                    <input type="text" cleave="options.numeral" ng-model="selected.more_paid" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Còn lại </label>
                                <div class="col-sm-9">
                                    <input type="text" value="@{{selected.total - selected.total_paid - selected.more_paid | number:0}}" class="form-control input-sm" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="updateOrder()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/OrderController.js') }}"></script>
@endsection