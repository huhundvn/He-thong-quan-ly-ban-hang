@extends('layouts.app')

@section('title')
    Lịch sử nhập kho
@endsection

@section('location')
    <li> Quản lý kho </li>
    <li> Lịch sử nhập kho </li>
@endsection

@section('content')

    <div ng-controller="InputStoreController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <a href="{{route('createInputStore')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Nhập hàng </a>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term.id" class="form-control input-sm" placeholder="Nhập tên nhà cung cấp...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.store_id" class="form-control input-sm">
                    <option value="" selected> -- Kho nhập -- </option>
                    <option ng-repeat="store in stores" value="@{{ store.id }}"> @{{ store.name }} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Chờ duyệt </option>
                    <option value="0"> Đã từ chối </option>
                    <option value="2"> Đã xác nhận </option>
                    <option value="3"> Đang lấy hàng </option>
                    <option value="4"> Đã nhập kho </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{inputStores.length}} mục </button>
            </div>
        </div>

        <hr/>

        {{--!DANH SÁCH NHÀ CUNG CẤP!--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã đơn  </th>
            <th> Nhà cung cấp </th>
            <th> Ngày tạo </th>
            <th> Tạo bởi </th>
            <th> Tổng tiền (VNĐ) </th>
            <th> Kho nhập </th>
            <th> Trạng thái </th>
            <th> Duyệt </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="inputStores.length > 0" class="item"
                dir-paginate="inputStore in inputStores | filter:term | filter:term2 | filter:term3 | itemsPerPage: 7" ng-click="readInputStore(inputStore)">
                <td data-toggle="modal" data-target="#readInputStore"> YCNH-@{{ inputStore.id }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.supplier.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.created_at | date: "dd/MM/yyyy" }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.user.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.total | number:0 }} </td>
                <td data-toggle="modal" data-target="#readInputStore"> @{{ inputStore.store.name }} </td>
                <td data-toggle="modal" data-target="#readInputStore">
                    <p ng-show="0==inputStore.status"> Đã từ chối </p>
                    <p ng-show="1==inputStore.status"> Chờ duyệt </p>
                    <p ng-show="2==inputStore.status"> Đã xác nhận </p>
                    <p ng-show="3==inputStore.status"> Đang lấy hàng </p>
                    <p ng-show="4==inputStore.status"> Đã nhập kho </p>
                </td>
                <td>
                    <button ng-show="4!=inputStore.status" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeInputStore">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td>
                    <button ng-show="0==inputStore.status||4==inputStore.status" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteInputStore"">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="inputStores.length==0">
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
                                        <option value="3"> Đang lấy hàng </option>
                                        <option value="4"> Đã nhập vào kho </option>
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
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa yêu cầu nhập hàng này </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa yêu cầu nhập hàng này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteInputStore()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/InputStoreController.js') }}"></script>
@endsection