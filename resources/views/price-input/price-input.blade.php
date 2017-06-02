@extends('layouts.app')

@section('title')
    Larose | Danh sách bảng giá nhà cung cấp
@endsection

@section('location')
    <li> Kho </li>
    <li> Danh sách bảng giá nhà cung cấp </li>
@endsection

@section('content')
    <div ng-controller="PriceInputController">

        {{-- TÌM KIẾM BẢNG GIÁ --}}
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <h3></h3>
                <a href="{{route('createPriceInput')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </a>
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Tên BG </label>
                <input type="text" ng-model="term.name" class="form-control input-sm" placeholder="Nhập tên bảng giá...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Nhà cung cấp </label>
                <select ng-model="term2.supplier_id" class="form-control input-sm">
                    <option value="" selected> -- Nhà cung cấp -- </option>
                    <option value="@{{supplier.id}}"> @{{supplier.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Từ ngày </label>
                <input ng-model="search.start_date" type="date" class="form-control input-sm" ng-change="searchPriceInput()">
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Đến ngày </label>
                <input ng-model="search.end_date" type="date" class="form-control input-sm" ng-change="searchPriceInput()">
            </div>
            <div class="col-lg-2 col-xs-2">
                <label> Trạng thái </label>
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Chờ duyệt </option>
                    <option value="0"> Đã từ chối </option>
                    <option value="2"> Áp dụng </option>
                </select>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH BẢNG GIÁ --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã </th>
            <th> Tên bảng giá </th>
            <th> Nhà cung cấp </th>
            <th> Ngày bắt đầu </th>
            <th> Ngày kết thúc </th>
            <th> Trạng thái </th>
            <th> Duyệt </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="priceInputs.length > 0" class="item"
                dir-paginate="priceInput in priceInputs | filter:term | filter:term2 | filter:term3 | itemsPerPage: 8" ng-click="readPriceInput(priceInput)">
                <td data-toggle="modal" data-target="#readPriceOutput"> BGMH-@{{ priceInput.id }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceInput.name }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput" ng-repeat="supplier in suppliers" ng-show="supplier.id==priceInput.supplier_id">
                    @{{ supplier.name }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceInput.start_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceInput.end_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput">
                    <p ng-show="0==priceInput.status"> Đã từ chối </p>
                    <p ng-show="1==priceInput.status"> Chờ duyệt </p>
                    <p ng-show="2==priceInput.status"> Áp dụng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changePriceOutput">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-sm" ng-show="0==priceInput.status"
                            data-toggle="modal" data-target="#deletePriceOutput">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="priceInputs.length==0">
                <td colspan="8"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; position: fixed; bottom: 0">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- Xem biểu mẫu --}}
        <div class="modal fade" id="readPriceOutput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                    <h1 align="center"> <b> Bảng giá mua </b> </h1>
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        Ngày bắt đầu: @{{ selected.start_date | date: "dd/MM/yyyy"}} <br/>
                                        Ngày kết thúc : @{{ selected.end_date | date: "dd/MM/yyyy" }} <br/>
                                    </div>
                                    <div class="col-sm-6">
                                        Tên bảng giá: @{{ selected.name }}<br/>
                                        <div ng-repeat="supplier in suppliers" ng-show="supplier.id==selected.supplier_id">
                                            Nhà cung cấp: @{{supplier.name}}
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
                                        <th> Giá mua (VNĐ) </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-show="detail.length > 0" class="item" ng-repeat="item in detail">
                                            <td> @{{ $index+1 }}</td>
                                            <td> @{{ item.code }} </td>
                                            <td> @{{ item.name }} </td>
                                            <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">@{{ unit.name }}</td>
                                            <td> @{{ item.price_input | number:0 }} </td>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- THAY ĐỔI TRẠNG THÁI BẢNG GIÁ --}}
    <div class="modal fade" id="changePriceOutput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-blue" id="myModalLabel"> Duyệt bảng giá </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3"> Trạng thái </label>
                            <div class="col-sm-9">
                                <select ng-model="newStatus" class="form-control input-sm" required>
                                    <option value="" selected> -- Trạng thái -- </option>
                                    <option value="0"> Không duyệt bảng giá </option>
                                    <option value="2"> Áp dụng bảng giá </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button ng-click="changeStatus()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- XÓA BẢNG GIÁ--}}
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
                    <button ng-click="deletePriceInput()" type="submit" class="btn btn-danger"> Xác nhận </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/PriceInputController.js') }}"></script>
@endsection