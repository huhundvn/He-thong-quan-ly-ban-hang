@extends('layouts.app')

@section('title')
    Thanh toán nhà cung cấp
@endsection

@section('location')
    <li> Kế toán </li>
    <li> Thanh toán nhà cung cấp </li>
@endsection

@section('content')

    <div ng-controller="InputStoreController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.store_id" class="form-control input-sm">
                    <option value="" selected> -- Kho nhập -- </option>
                    <option ng-repeat="store in stores" value="@{{ store.id }}"> @{{ store.name }} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value=""> -- Trạng thái -- </option>
                    <option value="2" selected> Đã xác nhận </option>
                    <option value="3"> Đang lấy hàng </option>
                    <option value="4"> Đã nhập kho </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{paidInputStores.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH NHÀ CUNG CẤP!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Ngày thanh toán  </th>
            <th> Nhà cung cấp </th>
            <th> Mã nhập </th>
            <th> Thanh toán bởi </th>
            <th> Kho nhập </th>
            <th> Tổng tiền (VNĐ) </th>
            <th> Đã thanh toán (VNĐ) </th>
            <th> Còn nợ (VNĐ) </th>
            <th> Thanh toán </th>
            </thead>
            <tbody>
            <tr ng-show="paidInputStores.length > 0" class="item"
                dir-paginate="inputStore in paidInputStores | filter:term | filter:term2 | filter:term3 | itemsPerPage: 7" ng-click="readInputStore(inputStore)">
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.updated_at | date: "dd/MM/yyyy" }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.supplier.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> YCNH-@{{ inputStore.id }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.user.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.store.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.total | number:0 }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.total_paid | number:0 }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.total - inputStore.total_paid | number:0 }} </td>
                <td>
                    <button ng-show="inputStore.total - inputStore.total_paid !=0" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeInputStore">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="paidInputStores.length==0">
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
                                    <h2 align="center"> <b> Phiếu nhập kho </b> </h2>
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        Nhà cung cấp: @{{ selected.supplier.name }} <br/>
                                        Địa chỉ: @{{ selected.supplier.address }} <br/>
                                        Số điện thoại: @{{ selected.supplier.phone }} <br/>
                                        Hình thức thanh toán: @{{ selected.account.name }}
                                    </div>
                                    <div class="col-xs-6">
                                        Nhập về kho: @{{ selected.store.name }} <br/>
                                        Địa chỉ: @{{ selected.store.address }} <br/>
                                        Số điện thoại: @{{ selected.store.phone }} <br/>
                                        Ngày giao hàng: @{{selected.input_date | date: "dd/MM/yyyy"}}<br/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <hr/>
                                        Chiết khấu: @{{ selected.discount | number:0 }} (VNĐ) <br/>
                                        Thuế VAT: @{{ selected.tax }} % <br/>
                                        Tổng tiền: @{{ selected.total | number:0 }} (VNĐ) <br/>
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
                                        <th> Giá nhập (VNĐ) </th>
                                        <th> Hạn sử dụng </th>
                                        <th> Thành tiền (VNĐ) </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-show="detail.length > 0" class="item" ng-repeat="item in detail">
                                            <td> @{{ $index+1 }}</td>
                                            <td>
                                                <p ng-repeat="product in products" ng-show="product.id==item.product_id"> @{{ product.code }} </p>
                                            </td>
                                            <td>
                                                <p ng-repeat="product in products" ng-show="product.id==item.product_id"> @{{ product.name }} </p>
                                            </td>
                                            <td> <p ng-repeat="unit in units" ng-show="unit.id==item.unit_id"> @{{ unit.name }} </p> </td>
                                            <td> @{{ item.quantity }} </td>
                                            <td> @{{ item.price_input | number:0 }} </td>
                                            <td> @{{ item.expried_date | date: "dd/MM/yyyy"}} </td>
                                            <td> @{{ item.quantity * item.price_input | number: 0 }} </td>
                                        </tr>
                                        <tr class="item" ng-show="detail.length==0">
                                            <td colspan="9"> Không có dữ liệu </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1></h1>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4" align="center">
                                        <b> Giám đốc </b><br/> (Ký tên)
                                    </div>
                                    <div class="col-xs-4" align="center">
                                        <b> Kế toán </b> <br/> (Ký tên)
                                    </div>
                                    <div class="col-xs-4" align="center">
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

        {{-- THANH TOÁN NHẬP HÀNG --}}
        <div class="modal fade" id="changeInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thanh toán cho nhà cung cấp </h4>
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
                            <button ng-click="updateInputStore()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
    <script src="{{ asset('angularJS/InputStoreController.js') }}"></script>
@endsection