@extends('layouts.app')

@section('title')
    Lịch sử chuyển kho
@endsection

@section('location')
    <li> Kho </li>
    <li> Lịch sử chuyển kho </li>
@endsection

@section('content')

    <div ng-controller="StoreTranferController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-2 ">
                <h3></h3>
                <a href="{{route('createStoreTranfer')}}" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-plus"></span> Chuyển kho </a>
            </div>
            <div class="col-lg-2 ">
                <label> Từ ngày </label>
                <input ng-model="search.start_date" type="date" class="form-control input-sm" ng-change="searchStoreTranfer()">
            </div>
            <div class="col-lg-2 ">
                <label> Đến ngày </label>
                <input ng-model="search.end_date" type="date" class="form-control input-sm" ng-change="searchStoreTranfer()">
            </div>
            <div class="col-lg-2 ">
                <label> Kho chuyển </label>
                <select ng-model="term.from_store_id" class="form-control input-sm">
                    <option value="" selected> -- Kho chuyển -- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 ">
                <label> Kho nhận </label>
                <select ng-model="term2.to_store_id" class="form-control input-sm">
                    <option value="" selected> -- Kho nhận -- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-lg-2 ">
                <label> Trạng thái </label>
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Chờ duyệt </option>
                    <option value="0"> Đã từ chối </option>
                    <option value="2"> Đã xác nhận </option>
                    <option value="3"> Đã chuyển kho </option>s
                </select>
            </div>
        </div>

        <hr/>

        {{-- DANH SÁCH CHUYỂN KHO --}}
        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> Mã đơn  </th>
            <th> Ngày chuyển </th>
            <th> Tạo bởi </th>
            <th> Kho chuyển </th>
            <th> Kho nhận </th>
            <th> Mô tả </th>
            <th> Trạng thái </th>
            <th> Duyệt </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="storeTranfers.length > 0" class="item"
                dir-paginate="storeTranfer in storeTranfers | filter:term | filter:term2 | filter:term3 | itemsPerPage: 8"
                ng-click="readStoreTranfer(storeTranfer)">
                <td data-toggle="modal" data-target="#readStoreTranfer"> CK-@{{ storeTranfer.id }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeTranfer.updated_at }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeTranfer.user.name }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer" ng-repeat="store in stores" ng-show="store.id==storeTranfer.from_store_id">
                    @{{ store.name }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer" ng-repeat="store in stores" ng-show="store.id==storeTranfer.to_store_id">
                    @{{ store.name }}  </td>
                <td data-toggle="modal" data-target="#readStoreTranfer"> @{{ storeTranfer.reason }} </td>
                <td data-toggle="modal" data-target="#readStoreTranfer">
                    <p ng-show="0==storeTranfer.status"> Đã từ chối </p>
                    <p ng-show="1==storeTranfer.status"> Chờ duyệt </p>
                    <p ng-show="2==storeTranfer.status"> Đang chuyển </p>
                    <p ng-show="3==storeTranfer.status"> Đã chuyển kho </p>
                </td>
                <td>
                    <button ng-show="3 != storeTranfer.status" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeInputStore">
                        <span class="glyphicon glyphicon-hand-up"></span>
                    </button>
                </td>
                <td>
                    <button ng-show="0==storeTranfer.status" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteInputStore">
                    <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="storeTranfers.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>

        {{-- !PHÂN TRANG! --}}
        <div style="margin-left: 35%; position: fixed; bottom: 0">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

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
                                <div class=" ">
                                    Công ty TNHH Larose <br/>
                                    142 Võ Văn Tân, TP.HCM <br/>
                                    ĐT: 0979369407
                                </div>
                                <div class=" ">
                                    Số: <br/>
                                    Ngày...tháng...năm...
                                </div>
                            </div>
                            <div class="row">
                                <h2 align="center"> <b> Phiếu chuyển kho </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class=" ">
                                    <div ng-repeat="store in stores" ng-show="store.id==selected.from_store_id">
                                        Kho chuyển: @{{ store.name }} <br/>
                                        Địa chỉ: @{{ store.address }} <br/>
                                        Số điện thoại: @{{ store.phone }}
                                    </div>
                                </div>
                                <div class=" ">
                                    <div ng-repeat="store in stores" ng-show="store.id==selected.to_store_id">
                                        Kho nhận: @{{ store.name }} <br/>
                                        Địa chỉ: @{{ store.address }} <br/>
                                        Số điện thoại: @{{ store.phone }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <h1></h1>
                                    Ngày chuyển: @{{ selected.updated_at }} <br/>
                                    Lý do chuyển: @{{ selected.reason }}
                                    <h1></h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive"><table class="w3-table table-bordered w3-centered">
                                    <thead>
                                    <th> Mã SP </th>
                                    <th> Tên </th>
                                    <th> Mã vạch </th>
                                    <th> Đơn vị tính </th>
                                    <th> Số lượng chuyển </th>
                                    <th> Giá nhập (VNĐ) </th>
                                    <th> Hạn sử dụng </th>
                                    </thead>
                                    <tbody>
                                    <tr ng-show="detail.length > 0" class="item" dir-paginate="item in detail | itemsPerPage: 4">
                                        <td> SP-@{{ item.product_id }}</td>
                                        <td> @{{ item.name }} </td>
                                        <td> @{{ item.code }} </td>
                                        <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id"> @{{ unit.name }} </td>
                                        <td> @{{ item.quantity_tranfer }} </td>
                                        <td> @{{ item.price_input | number: 0 }} </td>
                                        <td> @{{ item.expried_date | date: "dd/MM/yyyy" }} </td>
                                    </tr>
                                    <tr class="item" ng-show="selected.detail_store_tranfers.length==0">
                                        <td colspan="9"> Không có dữ liệu </td>
                                    </tr>
                                    </tbody>
                                </table></div>
                                <h1></h1>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 " align="center">
                                    <b> Quản lý kho chuyển </b><br/> (Ký tên)
                                </div>
                                <div class="col-lg-3 " align="center">
                                    <b> Quản lý kho nhận </b><br/> (Ký tên)
                                </div>
                                <div class="col-lg-3 " align="center">
                                    <b> Kế toán </b> <br/> (Ký tên)
                                </div>
                                <div class="col-lg-3 " align="center">
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

        {{-- THAY ĐỔI TRẠNG THÁI NHẬP HÀNG --}}
        <div class="modal fade" id="changeInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> 
                                Xác nhận chuyển kho </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Trạng thái </label>
                                <div class="">
                                    <select ng-model="newStatus" class="form-control input-sm" required>
                                        <option value="" selected> -- Trạng thái -- </option>
                                        <option value="2"> Xác nhận yêu cầu </option>
                                        <option value="0"> Hủy yêu cầu </option>
                                        <option value="3"> Đã chuyển vào kho </option>
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

        {{-- XÓA YÊU CẦU --}}
        <div class="modal fade" id="deleteInputStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa yêu cầu chuyển kho này </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa yêu cầu chuyển kho này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteStoreTranfer()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/StoreTranferController.js') }}"></script>
@endsection