@extends('layouts.app')

@section('title')
    Larose | Danh sách bảng giá
@endsection

@section('location')
    <li> Danh sách bảng giá </li>
@endsection

@section('content')
    <div ng-controller="PriceOutputController">

        {{-- TÌM KIẾM BẢNG GIÁ --}}
        <div class="row">
            <div class="col-lg-2 ">
                <h3></h3>
                <a href="{{route('createPriceOutput')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </a>
            </div>
            <div class="col-lg-2 ">
                <label> Tên BG </label>
                <input type="text" ng-model="term.name" class="form-control input-sm" placeholder="Nhập tên bảng giá...">
            </div>
            <div class="col-lg-2 ">
                <label> Từ ngày </label>
                <input ng-model="search.start_date" type="date" class="form-control input-sm" ng-change="searchPriceOutput()">
            </div>
            <div class="col-lg-2 ">
                <label> Đến ngày </label>
                <input ng-model="search.end_date" type="date" class="form-control input-sm" ng-change="searchPriceOutput()">
            </div>
            <div class="col-lg-2 ">
                <label> Trạng thái </label>
                <select ng-model="term2.status" class="form-control input-sm">
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
        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã </th>
            <th> Tên bảng giá </th>
            <th> Ngày bắt đầu </th>
            <th> Ngày kết thúc </th>
            <th> Trạng thái </th>
            <th ng-show="roles.indexOf('confirm-price-output') != -1"> Duyệt </th>
            <th ng-show="roles.indexOf('confirm-price-output') != -1"> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="priceOutputs.length > 0" class="item"
                dir-paginate="priceOutput in priceOutputs | filter:term | filter:term2 | itemsPerPage: 8" ng-click="readPriceOutput(priceOutput)">
                <td data-toggle="modal" data-target="#readPriceOutput"> BGBH-@{{ priceOutput.id }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.name }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.start_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.end_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput">
                    <p ng-show="0==priceOutput.status"> Đã từ chối </p>
                    <p ng-show="1==priceOutput.status"> Chờ duyệt </p>
                    <p ng-show="2==priceOutput.status"> Áp dụng </p>
                </td>
                <td ng-show="roles.indexOf('confirm-price-output') != -1">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changePriceOutput">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td ng-show="roles.indexOf('confirm-price-output') != -1">
                    <button class="btn btn-sm btn-danger btn-sm" ng-show="0==priceOutput.status"
                            data-toggle="modal" data-target="#deletePriceOutput">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="priceOutputs.length==0">
                <td colspan="6"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>

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
                                <div class="">
                                    Công ty TNHH Larose <br/>
                                    142 Võ Văn Tân, TP.HCM <br/>
                                    ĐT: 0979369407
                                </div>
                                <div class="">
                                    Số: <br/>
                                    Ngày...tháng...năm...
                                </div>
                            </div>
                            <div class="row">
                                <h1 align="center"> <b> Bảng giá bán </b> </h1>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="">
                                    Người tạo: @{{ selected.user.name }} <br/>
                                    Ngày bắt đầu: @{{ selected.start_date | date: "dd/MM/yyyy"}} <br/>
                                    Ngày kết thúc : @{{ selected.end_date | date: "dd/MM/yyyy" }} <br/>
                                </div>
                                <div class="">
                                    Tên bảng giá: @{{ selected.name }}<br/>
                                    Áp dụng cho: @{{selected.customer_group.name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class=""> Ghi chú: </div>
                            </div>
                            <h1></h1>
                            <div class="row">
                                <div class="table-responsive"><table class="w3-table table-bordered w3-centered">
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
                                </table></div>
                                <h1></h1>
                            </div>
                            <div class="row">
                                <div class="" align="center">
                                    <b> Chủ cửa hàng </b><br/> (Ký tên)
                                </div>
                                <div class="" align="center">
                                    <b> Kế toán </b> <br/> (Ký tên)
                                </div>
                                <div class="" align="center">
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
                                <label class=""> Trạng thái </label>
                                <div class="">
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
    <script src="{{ asset('angularJS/PriceOutputController.js') }}"></script>
@endsection