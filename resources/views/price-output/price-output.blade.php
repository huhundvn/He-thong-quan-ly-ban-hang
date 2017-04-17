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
            <div class="col-lg-6 col-xs-6">
                <a href="{{route('createPriceOutput')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Thêm mới </a>
            </div>
            <div class="col-lg-4 col-xs-4">
                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên...">
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

        {{-- DANH SÁCH BẢNG GIÁ --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> STT </th>
            <th> Tên bảng giá </th>
            <th> Ngày bắt đầu </th>
            <th> Ngày kết thúc </th>
            <th> Trạng thái </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="priceOutputs.length > 0" class="item"
                dir-paginate="priceOutput in priceOutputs | filter:term | itemsPerPage: 7" ng-click="readPriceOutput(priceOutput)">
                <td> @{{$index + 1}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.name }} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.start_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput"> @{{ priceOutput.end_date | date: "dd/MM/yyyy"}} </td>
                <td data-toggle="modal" data-target="#readPriceOutput">
                    <p ng-show="0==priceOutput.status"> Không áp dụng </p>
                    <p ng-show="1==priceOutput.status"> Chờ duyệt </p>
                    <p ng-show="2==priceOutput.status"> Áp dụng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#changePriceOutput">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="priceOutputs.length==0">
                <td colspan="6"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%; bottom:0; position: fixed;">
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
                                <h2 align="center"> <b> Bảng giá bán </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    Ngày bắt đầu: @{{ selected.start_date | date: "dd/MM/yyyy"}} <br/>
                                    Ngày kết thúc : @{{ selected.end_date | date: "dd/MM/yyyy" }} <br/>
                                    <div ng-repeat="customerGroup in customerGroups" ng-show="customerGroup.id==selected.customer_group_id">
                                        Áp dụng cho: @{{customerGroup.name}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    Tên bảng giá: @{{ selected.name }}<br/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12"> Ghi chú: </div>
                            </div>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </form>
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
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Xác nhận đơn hàng </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Trạng thái </label>
                                <div class="col-sm-9">
                                    <select ng-model="changeStatus" class="form-control">
                                        <option value=""> -- Trạng thái -- </option>
                                        <option value="1"> Không duyệt </option>
                                        <option value="2"> Áp dụng </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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
    <script src="{{ asset('angularJS/PriceOutputController.js') }}"></script>
@endsection