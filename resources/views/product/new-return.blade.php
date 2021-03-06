@extends('layouts.app')

@section('title')
    Tạo đơn trả hàng
@endsection

@section('location')
    <li> Bán hàng </li>
    <li> Tạo đơn trả hàng </li>
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
                    <label class=""> Khách hàng </label>
                    <div class="">
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
                    <label class=""> Bảng giá </label>
                    <div class="">
                        <select ng-model="new.price_output_id" class="form-control input-sm">
                            <option value="" selected> --Không chọn-- </option>
                            <option ng-repeat="priceOutput in priceOutputs"
                                    ng-show="priceOutput.customer_group_id == selectedCustomer.originalObject.customer_group_id"
                                    value="@{{priceOutput.id}}"> @{{priceOutput.name}} </option>
                        </select>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Tên khách hàng </label>
                    <div class="">
                        <input value="@{{ selectedCustomer.originalObject.name }}" class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Nhóm khách hàng </label>
                    <div class="">
                        <select class="form-control input-sm" disabled>
                            <option value=""> -- Nhóm khách hàng -- </option>
                            <option ng-repeat="customerGroup in customerGroups" ng-selected="customerGroup.id == selectedCustomer.originalObject.customer_group_id">
                                @{{ customerGroup.name }} </option>
                        </select>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Địa chỉ </label>
                    <div class="">
                        <input value="@{{ selectedCustomer.originalObject.address }}" class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Số điện thoại </label>
                    <div class="">
                        <input value="@{{ selectedCustomer.originalObject.phone }}"class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Email </label>
                    <div class="">
                        <input value="@{{ selectedCustomer.originalObject.email }}"class="form-control input-sm" readonly>
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> </label>
                    <div class="">
                        <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCustomer">
                            <span class="glyphicon glyphicon-plus"></span> Thêm khách hàng mới </button>
                    </div>
                </div>
            </div>
            <div id="selectMenu2" class="tab-pane fade">
                <h3> </h3>
                {{-- NHẬP SẢN PHẨM --}}
                <div class="row">
                    <div class="col-lg-3 ">
                        <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseProduct"> Chọn SP </button>
                        <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readReport"> Xem trước </button>
                    </div>
                    <div class="col-lg-3 ">
                        <button class="btn btn-sm w3-blue-grey"> Danh sách: @{{ data.length }} mục </button>
                    </div>
                </div>
                <hr/>
                {{-- Danh sách mặt hàng --}}
                <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
                    <thead class="w3-blue-grey">
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
                        <td> @{{ item.code }} </td>
                        <td> @{{ item.name }} </td>
                        <td> @{{ item.unit.name }}
                        </td>
                        <td>
                            <input cleave="options.numeral" type="text" ng-model="item.quantity" class="form-control input-sm input-numeral">
                        </td>
                        <td>
                            <input cleave="options.numeral" type="text" ng-model="item.web_price" class="form-control input-sm input-numeral">
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
                </table></div>

                {{-- PHÂN TRANG --}}
                <div style="margin-left: 35%;">
                    <dir-pagination-controls max-size="4"> </dir-pagination-controls>
                </div>

                <p></p>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class=" control-label"> Số tiền ban đầu:  </label>
                        <label class=" control-label"> @{{ getTotal() | number:0 }} (VNĐ) </label>
                    </div>
                    <div class="form-group">
                        <label class=" control-label"> Thuế VAT (%) </label>
                        <div class="">
                            <input ng-model="new.tax" type="text" class="form-control input-sm">
                        </div>
                        <label class=" control-label"> = @{{ getTotal() * (new.tax/100) | number:0 }} (VNĐ) </label>
                    </div>
                    <div class="form-group">
                        <label class=" control-label"> Giảm giá (VNĐ) </label>
                        <div class="">
                            <input cleave="options.numeral" ng-model="new.discount" type="text" class="form-control input-sm">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class=" control-label"> Tổng tiền:  </label>
                        <label class=" control-label"> @{{ getTotal() -- (getTotal() * (new.tax/100)) - new.discount | number:0 }} (VNĐ) </label>
                    </div>
                </div>

            </div>
            <div id="selectMenu3" class="tab-pane fade">
                <h3> </h3>
                <div class="row">
                    <label class=""> Hình thức thanh toán </label>
                    <div class="">
                        <select ng-model="new.payment_method" class="form-control input-sm">
                            <option value="" selected> --Không chọn-- </option>
                            <option value="Tiền mặt"> Tiền mặt </option>
                            <option value="Thẻ ngân hàng"> Thẻ ngân hàng </option>
                            <option value="Chuyển khoản"> Chuyển khoản </option>
                        </select>
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Tài khoản ngân hàng </label>
                    <div class="">
                        <input ng-model="new.bank_account" type="text" class="form-control input-sm" placeholder="Số tài khoản...">
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Ngân hàng </label>
                    <div class="">
                        <input ng-model="new.bank" type="text" class="form-control input-sm" placeholder="Ngân hàng...">
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Tài khoản nhận tiền </label>
                    <div class="">
                        <select ng-model="new.account_id" class="form-control input-sm">
                            <option value=""> -- Chọn tài khoản -- </option>
                            <option ng-repeat="account in accounts" value="@{{account.id}}"> @{{account.name}} </option>
                        </select>
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Số tiền cần thanh toán </label>
                    <div class="">
                        <input type="text" class="form-control input-sm" value="@{{ getTotal() -- (getTotal() * (new.tax/100)) - new.discount | number:0 }}" readonly>
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Số tiền đã thanh toán </label>
                    <div class="">
                        <input cleave="options.numeral" ng-model="new.total_paid" type="text" class="form-control input-sm" placeholder="Nhập số...">
                    </div>
                </div> <h3> </h3>
                <div class="row">
                    <label class=""> Còn lại </label>
                    <div class="">
                        <input type="text" class="form-control input-sm" value="@{{getTotal() -- (getTotal() * (new.tax/100)) - new.discount - new.total_paid | number:0}}" readonly>
                    </div>
                </div>
            </div>
            <div id="selectMenu4" class="tab-pane fade">
                <h3></h3>
                <div class=row>
                    <label class=""> Địa chỉ </label>
                    <div class="">
                        <input ng-model="new.contact_address" type="text" class="form-control input-sm" placeholder="Địa chỉ giao hàng...">
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Người liên hệ </label>
                    <div class="">
                        <input ng-model="new.contact_name" type="text" class="form-control input-sm" placeholder="Liên hệ...">
                    </div>
                </div> <h3></h3>
                <div class="row">
                    <label class=""> Số diện thoại </label>
                    <div class="">
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
                                <h2 align="center"> <b> Đơn hàng </b> </h2>
                                <hr/>
                            </div>
                            <div class="row">
                                <div class="">
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
                                <div class="">
                                    <div ng-repeat="store in stores" ng-show="store.id==info.store_id">
                                        Nhập về kho: @{{ store.name }} <br/>
                                        Địa chỉ: @{{ store.address }} <br/>
                                        Số điện thoại: @{{ store.phone }}
                                    </div>
                                    Ngày giao hàng: @{{info.input_date | date: "dd/MM/yyyy"}}<br/>
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
                                </table></div>
                                <h1></h1>
                            </div>
                            <div class="row">
                                <div class="" align="center">
                                    <b> Giám đốc </b><br/> (Ký tên)
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
                                <th> Số lượng còn </th>
                                <th> Giá </th>
                            </thead>
                            <tbody>
                            <tr class="item"
                                ng-show="products.length > 0" dir-paginate="product in products | filter:term | itemsPerPage: 5"
                                ng-click="add(product)" pagination-id="product">
                                <td> @{{$index+1}} </td>
                                <td> @{{ product.name}} </td>
                                <td> @{{ product.code }}</td>
                                <td> @{{ product.unit.name }} </td>
                                <td> @{{ product.total_quantity | number: 0 }} </td>
                                <td> @{{ product.web_price | number:0 }} </td>
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
                                <label class=""> Tên đầy đủ </label>
                                <div class="">
                                    <input ng-model="newCustomer.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Email </label>
                                <div class="">
                                    <input ng-model="newCustomer.email" type="email" class="form-control input-sm" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Số điện thoại </label>
                                <div class="">
                                    <input ng-model="newCustomer.phone" type="text" class="form-control input-sm" placeholder="Nhập số điện thoại..." value="{{old('phoneUser')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Địa chỉ </label>
                                <div class="">
                                    <input ng-model="newCustomer.address" type="text" class="form-control input-sm" placeholder="Nhập địa chỉ..." value="{{old('addressUser')}}">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class=""> Tài khoản ngân hàng </label>
                                <div class="">
                                    <input ng-model="newCustomer.bank_account" type="text" class="form-control input-sm" placeholder="Nhập số tài khoản...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Ngân hàng </label>
                                <div class="">
                                    <input ng-model="newCustomer.bank" type="text" class="form-control input-sm" placeholder="Nhập ngân hàng...">
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label class=""> Nhóm khách hàng </label>
                                <div class="">
                                    <select ng-model="newCustomer.customer_group_id" class="form-control input-sm">
                                        <option ng-repeat="x in customerGroups" value="@{{x.id}}"> @{{x.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Ghi chú </label>
                                <div class="">
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