@extends('layouts.app')

@section('title')
    Larose | Tạo đơn hàng mới
@endsection

@section('location')
    <li> Bán hàng </li>
    <li> Tạo đơn hàng mới </li>
@endsection

@section('content')
    <div ng-controller="OrderController">

        <button ng-click="createOrder()" class="btn btn-sm btn-success"> Xác nhận </button>
        <a href="{{ route('list-order') }}" class="btn btn-sm btn-default"> Quay lại </a>

        <hr/>

        {{-- Lựa chọn mục --}}
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#selectMenu1"> 1. Khách hàng </a></li>
            <li> <a data-toggle="tab" href="#selectMenu2"> 2. Sản phẩm </a></li>
            <li> <a data-toggle="tab" href="#selectMenu3"> 3. Thanh toán </a></li>
            <li> <a data-toggle="tab" href="#selectMenu4"> 4. Giao hàng </a></li>
        </ul>

        {{-- Thông tin --}}
        <div class="tab-content">
            <div id="selectMenu1" class="tab-pane fade in active">
                <h3> </h3>
                <div class="row">
                    <label class="col-sm-3"> Bảng giá </label>
                    <div class="col-sm-9">
                        <select ng-model="new.price_output_id" class="form-control input-sm">
                            <option value="" selected> --Không chọn-- </option>
                            <option ng-repeat="priceOutput in priceOutputs" value="@{{priceOutput.id}}"> @{{priceOutput.name}} </option>
                        </select>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Khách hàng </label>
                    <div class="col-sm-9">
                        <div angucomplete-alt
                             placeholder="Khách hàng..."
                             pause="100"
                             selected-object="selectedCustomer"
                             local-data="customers"
                             search-fields="name"
                             title-field="name"
                             description-field="address"
                             minlength="1"
                             input-class="form-control input-sm">
                        </div>
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class="col-sm-3"> Tên khách hàng </label>
                    <div class="col-sm-9">
                        <input value="@{{ selectedCustomer.originalObject.name }}" class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Nhóm khách hàng </label>
                    <div class="col-sm-9">
                        <select class="form-control input-sm" disabled>
                            <option value=""> -- Nhóm khách hàng -- </option>
                            <option ng-repeat="customerGroup in customerGroups" ng-selected="customerGroup.id == selectedCustomer.originalObject.customer_group_id">
                                @{{ customerGroup.name }} </option>
                        </select>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Địa chỉ </label>
                    <div class="col-sm-9">
                        <input value="@{{ selectedCustomer.originalObject.address }}" class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Số điện thoại </label>
                    <div class="col-sm-9">
                        <input value="@{{ selectedCustomer.originalObject.phone }}"class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Email </label>
                    <div class="col-sm-9">
                        <input value="@{{ selectedCustomer.originalObject.email }}"class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> </label>
                    <div class="col-sm-9">
                        <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCustomer">
                            <span class="glyphicon glyphicon-plus"></span> Thêm khách hàng mới </button>
                    </div>
                </div>
            </div>
            <div id="selectMenu2" class="tab-pane fade">
                <h3> </h3>
                {{-- NHẬP SẢN PHẨM --}}
                <div class="row">
                    <div class="col-lg-3 col-xs-3">
                        <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseProduct"> Chọn SP </button>
                        <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readReport"> Xem trước </button>
                    </div>
                    <div class="col-lg-3 col-xs-3">
                        <button class="btn btn-sm w3-blue-grey"> Danh sách: @{{ data.length }} mục </button>
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
                    <th> Giá bán (VNĐ) </th>
                    <th> Thành tiền (VNĐ) </th>
                    <th> Xóa </th>
                    </thead>
                    <tbody>
                    <tr ng-show="data.length > 0" class="item" dir-paginate="item in data | itemsPerPage: 4">
                        <td> @{{ $index+1 }}</td>
                        <td> @{{ item.code }} </td>
                        <td> @{{ item.name }} </td>
                        <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">
                            @{{ unit.name }}
                        </td>
                        <td>
                            <input cleave="options.numeral" type="text" ng-model="item.quantity" class="form-control input-sm input-numeral">
                        </td>
                        <td>
                            @{{ item.web_price | number:0 }}
                        </td>
                        <td>
                            @{{ item.quantity * item.web_price | number:0 }}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger btn-sm" ng-click="delete(item)">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                    <tr class="item" ng-show="data.length==0">
                        <td colspan="8"> Không có dữ liệu </td>
                    </tr>
                    </tbody>
                </table>

                <p>
                    <h1></h1>
                    <b> Số tiền: @{{ getTotal() | number:0 }} VNĐ <br/>
                    Thuế VAT (10%): @{{ getTotal() * 0.1 | number:0 }} VNĐ <br/>
                    <hr/>
                    Tổng tiền: @{{ getTotal() -- getTotal() * 0.1 | number:0 }} VNĐ </b>
                </p>

                {{-- PHÂN TRANG --}}
                <div style="margin-left: 35%;">
                    <dir-pagination-controls max-size="4"> </dir-pagination-controls>
                </div>

            </div>
            <div id="selectMenu3" class="tab-pane fade">
                <h3> </h3>
                <div class="row">
                    <label class="col-sm-3"> Hình thức thanh toán </label>
                    <div class="col-sm-9">
                        <select ng-model="new.payment_method" class="form-control input-sm">
                            <option value="" selected> --Không chọn-- </option>
                            <option value="Tiền mặt"> Tiền mặt </option>
                            <option value="Thẻ ngân hàng"> Thẻ ngân hàng </option>
                        </select>
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class="col-sm-3"> Tài khoản ngân hàng </label>
                    <div class="col-sm-9">
                        <input ng-model="new.bank_account" type="text" class="form-control input-sm" placeholder="Số tài khoản...">
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class="col-sm-3"> Ngân hàng </label>
                    <div class="col-sm-9">
                        <input ng-model="new.bank" type="text" class="form-control input-sm" placeholder="Ngân hàng...">
                    </div>
                </div>
            </div>
            <div id="selectMenu4" class="tab-pane fade">
                <h3></h3>
                <div class=row>
                    <label class="col-sm-3"> Địa chỉ </label>
                    <div class="col-sm-9">
                        <input ng-model="new.contact_address" type="text" class="form-control input-sm" placeholder="Địa chỉ giao hàng...">
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Người liên hệ </label>
                    <div class="col-sm-9">
                        <input ng-model="new.contact_name" type="text" class="form-control input-sm" placeholder="Liên hệ...">
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class="col-sm-3"> Số diện thoại </label>
                    <div class="col-sm-9">
                        <input ng-model="new.contact_phone" type="text" class="form-control input-sm" placeholder="Số điện thoại...">
                    </div>
                </div>
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
                                <div class="col-sm-6">
                                    <div ng-repeat="supplier in suppliers" ng-show="supplier.id==info.supplier_id">
                                        Nhà cung cấp: @{{ supplier.name }} <br/>
                                        Địa chỉ: @{{ supplier.address }} <br/>
                                        Số điện thoại: @{{ supplier.phone }}
                                    </div>
                                    <div ng-repeat="account in accounts" ng-show="account.id==info.account_id">
                                        Hình thức thanh toán: @{{account.name}}
                                    </div>
                                    Tổng tiền: <br/>
                                </div>
                                <div class="col-sm-6">
                                    <div ng-repeat="store in stores" ng-show="store.id==info.store_id">
                                        Nhập về kho: @{{ store.name }} <br/>
                                        Địa chỉ: @{{ store.address }} <br/>
                                        Số điện thoại: @{{ store.phone }}
                                    </div>
                                    Ngày giao hàng: @{{info.input_date | date: "dd/MM/yyyy"}}<br/>
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
                                        <td ng-repeat="unit in units" ng-show="unit.id==item.unit_id">@{{ unit.name }}</td>
                                        <td> @{{ item.quantity }} </td>
                                        <td> @{{ item.price | number:0 }} </td>
                                        <td> @{{ item.expried_date | date: "dd/MM/yyyy"}} </td>
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
                        <table class="w3-table table-hover table-bordered w3-centered">
                            <thead>
                            <tr class="w3-blue-grey">
                                <th> STT </th>
                                <th> Tên </th>
                                <th> Mã vạch </th>
                                <th> Đơn vị tính </th>
                                <th> Số lượng </th>
                                <th> Tình trạng </th>
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
                                <td> @{{ product.total_quantity | number: 0 }} </td>
                                <td>
                                    <p ng-show="product.total_quantity != 0"> Còn hàng </p>
                                    <p ng-show="product.total_quantity == 0"> Hết hàng </p>
                                </td>
                            </tr>
                            <tr class="item" ng-show="products.length==0">
                                <td colspan="7"> Không có dữ liệu </td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="margin-left: 35%;">
                            <dir-pagination-controls pagination-id="product" max-size="4"> </dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- !TẠO KHÁCH HÀNG MỚI! --}}
        <div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm khách hàng mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên đầy đủ </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Email </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Số điện thoại </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại..." value="{{old('phoneUser')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Địa chỉ </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ..." value="{{old('addressUser')}}">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Tài khoản ngân hàng </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.bank_account" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ngân hàng </label>
                                <div class="col-sm-9">
                                    <input ng-model="newCustomer.bank" type="text" class="form-control input-sm" placeholder="Nhập ngân hàng...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class="col-sm-3"> Nhóm khách hàng </label>
                                <div class="col-sm-9">
                                    <select ng-model="newCustomer.customer_group_id" class="form-control input-sm">
                                        <option ng-repeat="x in customerGroups" value="@{{x.id}}"> @{{x.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Ghi chú </label>
                                <div class="col-sm-9">
                                    <textarea ng-model="newCustomer.note" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createCustomer()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
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