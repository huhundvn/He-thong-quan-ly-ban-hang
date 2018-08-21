@extends('layouts.app')

@section('title')
    Larose | Tạo bảng giá mới
@endsection

@section('location')
    <li> Bảng giá </li>
    <li> Tạo bảng giá </li>
@endsection

@section('content')
    <div ng-controller="PriceOutputController">

        {{-- NHẬP SẢN PHẨM --}}
        <div class="row">
            <div class="col-lg-3 ">
                <button type="submit" class="btn btn-success btn-sm" ng-click="createPriceOutput()"> Xác nhận </button>
                <a href="{{route('list-price-output')}}" class="btn btn-default btn-sm"> Quay lại </a>
            </div>
            <div class="col-lg-3 ">
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseProduct"> Chọn SP </button>
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readReport"> Xem trước </button>
            </div>
            <div class="col-lg-3 ">

            </div>
            <div class="col-lg-3 ">
                <button class="btn btn-sm w3-blue-grey"> Danh sách: @{{ data.length }} mục </button>
            </div>

        </div>

        <hr/>

        {{-- Thông tin nhập--}}
        <div class="row">
            <div class="">
                <label> Tên bảng giá </label>
                <input ng-model="info.name" type="text" class="form-control input-sm">
            </div>
            <div class="">
                <label> Ngày bắt đầu </label>
                <input ng-model="info.start_date" type="date" class="form-control input-sm">
            </div>
            <div class="">
                <label> Ngày kết thúc </label>
                <input ng-model="info.end_date" type="date" class="form-control input-sm">
            </div>
            <div class="">
                <label> Nhóm khách hàng </label>
                <select ng-model="info.customer_group_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="customerGroup in customerGroups" value="@{{customerGroup.id}}"> @{{customerGroup.name}} </option>
                </select>
            </div>
        </div>

        <hr/>



        {{-- Danh sách mặt hàng --}}
        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> STT </th>
            <th> Mã vạch </th>
            <th> Tên </th>
            <th> Đơn vị tính </th>
            <th> Giá bán (VNĐ) </th>
            <th> Xóa </th>
            </thead>
            <tbody ng-init="total = 0">
            <tr ng-show="data.length > 0" class="item" dir-paginate="item in data | itemsPerPage: 4">
                <td> @{{ $index+1 }}</td>
                <td> @{{ item.code }} </td>
                <td> @{{ item.name }} </td>
                <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">
                    @{{ unit.name }}
                </td>
                <td>
                    <input cleave="options.numeral" type="text" ng-model="item.price_output"
                    ng-init="item.price_output=item.web_price" class="form-control input-sm input-numeral">
                </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-sm" ng-click="delete(item)">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="data.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table></div>

        {{-- PHÂN TRANG --}}
        <dir-pagination-controls max-size="4"></dir-pagination-controls>

        {{-- Xem biểu mẫu --}}
        <div class="modal fade" id="readReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Biểu mẫu </h4>
                        </div>
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
                                <h2 align="center"> <b> Bảng giá bán </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="">
                                    Ngày bắt đầu: @{{ info.start_date | date: "dd/MM/yyyy"}} <br/>
                                    Ngày kết thúc : @{{ info.end_date | date: "dd/MM/yyyy" }} <br/>
                                    Áp dụng cho: @{{ info.phone }}
                                </div>
                                <div class="">
                                    Tên bảng giá: @{{ info.name }}<br/>
                                </div>
                            </div>
                            <div class="row">
                                <div class=""> Ghi chú: </div>
                            </div>
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
                                    <tr ng-show="data.length > 0" class="item" ng-repeat="item in data">
                                        <td> @{{ $index+1 }}</td>
                                        <td> @{{ item.code }} </td>
                                        <td> @{{ item.name }} </td>
                                        <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">@{{ unit.name }}</td>
                                        <td> @{{ item.price_output | number:0 }} </td>
                                    </tr>
                                    <tr class="item" ng-show="data.length==0">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CHỌN SẢN PHẨM --}}
        <div class="modal fade" id="chooseProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-blue" id="myModalLabel"> Chọn sản phẩm </h4>
                    </div>
                    <div class="modal-body">
                        <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
                        <h1></h1>
                        {{-- !DANH SÁCH SẢN PHẨM! --}}
                        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
                            <thead>
                            <tr class="w3-blue-grey">
                                <th> STT </th>
                                <th> Tên </th>
                                <th> Mã vạch </th>
                                <th> Đơn vị tính </th>
                                <th> Số lượng </th>
                            </thead>
                            <tbody>
                            <tr class="item"
                                ng-show="products.length > 0" dir-paginate="product in products | filter:term | itemsPerPage: 5"
                                ng-click="add(product)" pagination-id="product">
                                <td> @{{$index+1}} </td>
                                <td> @{{ product.name}} </td>
                                <td> @{{ product.code }}</td>
                                <td ng-repeat="unit in units" ng-show="unit.id==product.unit_id">
                                    @{{ unit.name }}
                                </td>
                                <td> @{{ product.total_quantity | number: 0 }}</td>
                            </tr>
                            <tr class="item" ng-show="products.length==0">
                                <td colspan="7"> Không có dữ liệu </td>
                            </tr>
                            </tbody>
                        </table></div>
                        <div style="margin-left: 35%;">
                            <dir-pagination-controls pagination-id="product" max-size="4"> </dir-pagination-controls>
                        </div>
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