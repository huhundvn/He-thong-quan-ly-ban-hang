@extends('layouts.app')

@section('title')
    Larose | Danh sách phiếu
@endsection

@section('location')
    <li> Kế toán </li>
    <li> Danh sách phiếu </li>
@endsection

@section('content')
    <div ng-controller="VoucherController">

        {{-- TÌM KIẾM BẢNG GIÁ --}}
        <div class="row">
            <div class="col-lg-4 col-xs-2">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#createVoucher">
                    Phiếu thu mới </button>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#createPaymentVoucher">
                    Phiếu chi mới </button>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input type="text" ng-model="term" class="form-control input-sm" placeholder="Nhập mã phiếu ...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Chờ duyệt </option>
                    <option value="0"> Đã từ chối </option>
                    <option value="2"> Áp dụng </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{priceOutputs.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH PHIẾU THU/CHI--}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã </th>
            <th> Ngày lập </th>
            <th> Người tạo </th>
            <th> Người nhận </th>
            <th> Loại </th>
            <th> Tổng tiền </th>
            <th> Duyệt </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="vouchers.length > 0" class="item"
                dir-paginate="voucher in vouchers | filter:term | filter:term2 | itemsPerPage: 7" ng-click="readVoucher(voucher)">
                <td data-toggle="modal" data-target="#readVoucher"> BGBH-@{{ voucher.id }} </td>
                <td data-toggle="modal" data-target="#readVoucher"> @{{ voucher.name }} </td>
                <td data-toggle="modal" data-target="#readVoucher"> @{{ voucher.start_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readVoucher"> @{{ voucher.end_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput">
                    <p ng-show="0==priceOutput.status"> Đã từ chối </p>
                    <p ng-show="1==priceOutput.status"> Chờ duyệt </p>
                    <p ng-show="2==priceOutput.status"> Áp dụng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changePriceOutput">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-sm" ng-show="0==priceOutput.status"
                            data-toggle="modal" data-target="#deletePriceOutput">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="vouchers.length==0">
                <td colspan="8"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 45%">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- THÊM PHIẾU THU, PHIẾU CHI MỚI! --}}
        <div class="modal fade" id="createVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form id="createUserForm" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm phiếu thu </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Người nhận </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.created_by" type="text" class="form-control input-sm"
                                           placeholder="{{Auth::user()->name}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Người nộp tiền </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.receiver" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên người nộp tiền...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Số tiền </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Lý do thu </label>
                                <div class="col-sm-9">
                                    <textarea ng-model="new.address" class="form-control input-sm"> </textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ng-click="createUser()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="createPaymentVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form id="createUserForm" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm phiếu chi </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Người chi </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.created_by" type="text" class="form-control input-sm"
                                           placeholder="{{Auth::user()->name}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Tài khoản </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.receiver" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên người nộp tiền...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Người nhận </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.receiver" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên người nộp tiền...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Số tiền </label>
                                <div class="col-sm-9">
                                    <input ng-model="new.address" type="text" class="form-control input-sm"
                                           placeholder="Nhập địa chỉ...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Lý do thu </label>
                                <div class="col-sm-9">
                                    <textarea ng-model="new.address" class="form-control input-sm"> </textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button ng-click="createUser()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    {{-- XEM BIỂU MẪU --}}
    <div class="modal fade" id="readVoucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
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
                                    <div class="col-sm-8">
                                        Công ty TNHH Larose <br/>
                                        142 Võ Văn Tân, TP.HCM <br/>
                                        ĐT: 0979369407
                                    </div>
                                    <div class="col-sm-4">
                                        Số: <br/>
                                        Ngày...tháng...năm...
                                    </div>
                                </div>
                                <div class="row">
                                    <h1 align="center"> <b> Phiếu thu </b> </h1>
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        Ngày bắt đầu: @{{ selected.start_date | date: "dd/MM/yyyy"}} <br/>
                                        Ngày kết thúc : @{{ selected.end_date | date: "dd/MM/yyyy" }} <br/>
                                    </div>
                                    <div class="col-sm-6">
                                        Tên bảng giá: @{{ selected.name }}<br/>
                                        <div ng-repeat="customerGroup in customerGroups" ng-show="customerGroup.id==selected.customer_group_id">
                                            Áp dụng cho: @{{customerGroup.name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12"> Ghi chú: </div>
                                </div>
                                <h1></h1>
                                <div class="row">
                                    <table class="w3-table table-bordered w3-centered">
                                        <thead>
                                        <th> STT </th>
                                        <th> Mã vạch </th>
                                        <th> Tên </th>
                                        <th> Đơn vị tính </th>
                                        <th> Giá bán (VNĐ) </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-show="detail.length > 0" class="item" ng-repeat="item in detail">
                                            <td> @{{ $index+1 }}</td>
                                            <td> @{{ item.code }} </td>
                                            <td> @{{ item.name }} </td>
                                            <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">@{{ unit.name }}</td>
                                            <td> @{{ item.price_output | number:0 }} </td>
                                        </tr>
                                        <tr class="item" ng-show="detail.length==0">
                                            <td colspan="9"> Không có dữ liệu </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1></h1>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4" align="center">
                                        <b> Chủ cửa hàng </b><br/> (Ký tên)
                                    </div>
                                    <div class="col-sm-4" align="center">
                                        <b> Kế toán </b> <br/> (Ký tên)
                                    </div>
                                    <div class="col-sm-4" align="center">
                                        <b> Người lập phiếu </b> <br/> (Ký tên)
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer hidden-print">
                                <button type="button" class="btn btn-success btn-sm" ng-click="print()">
                                    <span class="glyphicon glyphicon-print"></span> In
                                </button>
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Đóng </button>
                            </div>
                </div>
            </div>
        </div>
    </div>

    {{-- XÓA PHIẾU CHI NHẬP --}}
    <div class="modal fade" id="deletePriceOutput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa bảng giá </h4>
                </div>
                <div class="modal-body">
                    Bạn thực sự muốn xóa bảng giá này?
                </div>
                <div class="modal-footer">
                    <button ng-click="deletePriceOutput()" type="submit" class="btn btn-danger"> Xác nhận </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/VoucherController.js') }}"></script>
@endsection