@extends('layouts.app')

@section('title')
    Larose | Yêu cầu nhập hàng
@endsection

@section('location')
    <li> Yêu cầu nhập hàng </li>
@endsection

@section('content')
    <div ng-controller="CreateInputStoreController">

        {{-- Thông tin nhập--}}
        <div class="row">
            <div class="col-sm-3">
                <label> Mgày nhập dự kiến </label>
                <input ng-model="new.date" type="date" class="form-control input-sm">
            </div>
            <div class="col-sm-3">
                <label> Nhà kho </label>
                <select ng-model="new.store_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-sm-3">
                <label> Nhà cung cấp </label>
                <select ng-model="new.supplier_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}"> @{{supplier.name}} </option>
                </select>
            </div>
            <div class="col-sm-3">
                <label> Tài khoản thanh toán </label>
                <select ng-model="new.account_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="account in accounts" value="@{{account.id}}"> @{{account.name}} </option>
                </select>
            </div>
        </div>

        <hr/>

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <angucomplete-alt placeholder="Nhập tên hoặc mã sản phẩm"
                                  pause="300" selected-object="selected" local-data="products"
                                  local-search="searchProduct"
                                  title-field="name, code"
                                  image-field="pic"
                                  minlength="1"
                                  input-class="form-control input-sm"
                                  match-class="highlight" />
            </div>
            <div class="col-lg-3 col-xs-4">
                <button class="btn btn-sm btn-success" ng-click="add(selected.originalObject)"> Thêm </button>
            </div>
            <div class="col-lg-3 col-xs-4">
                <button class="btn btn-sm btn-info"> Tổng tiền: @{{ total }} VNĐ </button>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{datas.length}} mục </button>
            </div>

        </div>

        <hr/>

        {{-- Danh sách mặt hàng --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead class="w3-blue-grey">
            <th> STT </th>
            <th> Mã vạch </th>
            <th> Tên </th>
            <th> Đơn vị tính </th>
            <th> Số lượng </th>
            <th> Giá nhập (VNĐ) </th>
            <th> Hạn sử dụng </th>
            <th> Thành tiền (VNĐ) </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="data.length > 0" class="item" dir-paginate="item in data | itemsPerPage: 4" ng-init="setTotal(data)">
                <td> @{{ $index+1 }}</td>
                <td> @{{ item.code }} </td>
                <td> @{{ item.name }} </td>
                <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">
                    @{{ unit.name }}
                </td>
                <td>
                    <input cleave="options.numeral" type="text" ng-model="item.quantity" class="form-control">
                </td>
                <td>
                    <input cleave="options.numeral" type="text" ng-model="item.price" class="form-control">
                </td>
                <td>
                    <input type="date" ng-model="item.period_date" class="form-control">
                </td>
                <td>
                    @{{item.quantity * item.price | number: 0 }}
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" ng-click="delete(item)">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="data.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        <hr/>

        {{-- Xác nhận --}}
        <div class="row">
            <div class="col-lg-4 col-xs-2">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#readReport"> Xem trước </button>
                <a href="{{route('list-input-store')}}" class="btn btn-sm btn-success"> Gửi yêu cầu </a>
                <a href="{{route('list-input-store')}}" class="btn btn-sm btn-danger"> Hủy </a>
            </div>
            <div class="col-lg-2 col-xs-4">

            </div>
            <div class="col-lg-6 col-xs-6">
                <label> Ghi chú </label>
                <textarea class="form-control"></textarea>
            </div>
        </div>

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
                                <h2 align="center"> <b> Phiếu mua hàng </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div ng-repeat="supplier in suppliers" ng-show="supplier.id==new.supplier_id">
                                        Nhà cung cấp: @{{ supplier.name }} <br/>
                                        Địa chỉ: @{{ supplier.address }} <br/>
                                        Số điện thoại: @{{ supplier.phone }}
                                    </div>
                                    <div ng-repeat="account in accounts" ng-show="account.id==new.account_id">
                                        Hình thức thanh toán: @{{account.name}}
                                    </div>
                                    Tổng tiền: <br/>
                                </div>
                                <div class="col-sm-6">
                                    <div ng-repeat="store in stores" ng-show="store.id==new.store_id">
                                        Nhập về kho: @{{ store.name }} <br/>
                                        Địa chỉ: @{{ store.address }} <br/>
                                        Số điện thoại: @{{ store.phone }}
                                    </div>
                                    Ngày giao hàng: @{{new.date | date: "dd/MM/yyyy"}}<br/>
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
                                    <th> Số lượng </th>
                                    <th> Giá nhập (VNĐ) </th>
                                    <th> Hạn sử dụng </th>
                                    <th> Thành tiền (VNĐ) </th>
                                    </thead>
                                    <tbody>
                                    <tr ng-show="data.length > 0" class="item" ng-repeat="item in data">
                                        <td> @{{ $index+1 }}</td>
                                        <td> @{{ item.code }} </td>
                                        <td> @{{ item.name }} </td>
                                        <td ng-repeat="unit in units" ng-show="unit.id==data.unit_id">@{{ unit.name }}</td>
                                        <td> @{{ item.quantity }} </td>
                                        <td> @{{ item.price | number:0 }} </td>
                                        <td> @{{ item.period_date | date: "dd/MM/yyyy"}} </td>
                                        <td> @{{ item.quantity * item.price | number: 0 }} </td>
                                    </tr>
                                    <tr class="item" ng-show="data.length==0">
                                        <td colspan="9"> Không có dữ liệu </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h1></h1>
                            </div>
                            <div class="row">
                                <div class="col-sm-4" align="center">
                                    <b> Giám đốc </b><br/> (Ký tên)
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

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/CreateInputStoreController.js') }}"></script>
@endsection