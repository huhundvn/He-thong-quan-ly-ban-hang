@extends('layouts.app')

@section('title')
    Yêu cầu nhập kho
@endsection

@section('location')
    <li> Yêu cầu nhập hàng </li>
@endsection

@section('content')
    <div ng-controller="InputStoreController">

        {{-- NHẬP SẢN PHẨM --}}
        <div class="row">
            <div class="col-lg-4 ">
                <button type="submit" class="btn btn-success btn-sm" ng-click="createInputStore()"> Xác nhận  </button>
                <a href="{{route('list-input-store')}}" class="btn btn-default btn-sm"> Quay lại </a>
            </div>
            <div class="col-lg-6 ">
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseProduct"> Chọn SP </button>
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#createProduct"> Thêm SP mới </button>
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readReport"> Xem trước </button>
            </div>
            <div class="col-lg-2 ">
                <button class="btn btn-sm w3-blue-grey"> Danh sách: @{{ data.length }} mục </button>
            </div>
        </div>
        <hr/>

        {{-- Thông tin nhập--}}
        <div class="row">
            <div class="">
                <label> Ngày nhập dự kiến </label>
                <input ng-model="info.input_date" type="date" class="form-control input-sm">
            </div>
            <div class="">
                <label> Kho nhập </label>
                <select ng-model="info.store_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="">
                <label> Nhà cung cấp </label>
                <select ng-model="info.supplier_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}"> @{{supplier.name}} </option>
                </select>
            </div>
            <div class="">
                <label> Bảng giá mua </label>
                <select ng-model="info.price_input_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="priceInput in priceInputs" value="@{{priceInput.id}}"> @{{priceInput.name}} </option>
                </select>
            </div>
            <div class="">
                <label> Tài khoản thanh toán </label>
                <select ng-model="info.account_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="account in accounts" value="@{{account.id}}"> @{{account.name}} </option>
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
            <th> Số lượng </th>
            <th> Giá nhập (VNĐ) </th>
            <th> Hạn sử dụng </th>
            <th> Thành tiền (VNĐ) </th>
            <th> Xóa </th>
            </thead>
            <tbody>
            <tr ng-show="data.length > 0" class="item" dir-paginate="item in data | itemsPerPage: 4">
                <td> @{{ $index+1 }}</td>
                <td> @{{ item.code }} </td>
                <td> @{{ item.name }} </td>
                <td> @{{ item.unit.name }} </td>
                <td>
                    <input cleave="options.numeral" type="text" ng-model="item.quantity" class="form-control input-sm input-numeral">
                </td>
                <td>
                    <input cleave="options.numeral" type="text" ng-model="item.price_input" class="form-control input-sm input-numeral">
                </td>
                <td>
                    <input type="date" ng-model="item.expried_date" class="form-control input-sm">
                </td>
                <td>
                    @{{ item.quantity * item.price_input | number:0 }}
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
                    <input ng-model="info.tax" type="text" class="form-control input-sm">
                </div>
                <label class=" control-label"> = @{{ getTotal() * (info.tax/100) | number:0 }} (VNĐ) </label>
            </div>
            <div class="form-group">
                <label class=" control-label"> Chiết khấu (VNĐ) </label>
                <div class="">
                    <input cleave="options.numeral" ng-model="info.discount" type="text" class="form-control input-sm">
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label class=" control-label"> Tổng tiền:  </label>
                <label class=" control-label"> @{{ getTotal() -- (getTotal() * (info.tax/100)) - info.discount | number:0 }} (VNĐ) </label>
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
                                    <h2 align="center"> <b> Phiếu mua hàng </b> </h2>
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
                                        Số tiền ban đầu: @{{ getTotal() | number:0 }} (VNĐ) <br/>
                                        Chiết khấu: @{{ info.discount | number:0 }} (VNĐ) <br/>
                                        Thuế VAT: @{{ info.tax }} % <br/>
                                        Tổng tiền: @{{ getTotal() -- getTotal() * (info.tax/100) - info.discount | number:0 }} (VNĐ) <br/>
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
                                            <td> @{{ item.price_input | number:0 }} </td>
                                            <td> @{{ item.expried_date | date: "dd/MM/yyyy"}} </td>
                                            <td> @{{ item.quantity * item.price_input | number: 0 }} </td>
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
                        <div class="row">
                            <div class="">
                                <input ng-model="term" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
                            </div>
                            <div class="">
                                <select ng-model="term2.status" class="form-control input-sm">
                                    <option value=""> -- Trạng thái -- </option>
                                    <option value="1"> Còn hàng </option>
                                    <option value="0"> Hết hàng </option>
                                </select>
                            </div>
                        </div>
                        <h1></h1>
                        {{-- !DANH SÁCH SẢN PHẨM! --}}
                        <div class="table-responsive"><table class="w3-table table-hover table-bordered w3-centered">
                            <thead>
                            <tr class="w3-blue-grey">
                                <th> Mã SP </th>
                                <th> Tên </th>
                                <th> Đơn vị tính </th>
                                <th> Số lượng </th>
                                <th> Tình trạng </th>
                            </thead>
                            <tbody>
                            <tr class="item"
                                ng-show="products.length > 0" dir-paginate="product in products | filter:term | filter:term2 | itemsPerPage: 5"
                                ng-click="add(product)" pagination-id="product">
                                <td> SP-@{{ product.id }}</td>
                                <td> @{{ product.name }} </td>
                                <td> @{{ product.unit.name }} </td>
                                <td> @{{ product.total_quantity | number: 0 }}</td>
                                <td>
                                    <p ng-show="product.total_quantity != 0"> Còn hàng </p>
                                    <p ng-show="product.total_quantity == 0"> Hết hàng </p>
                                </td>
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

        {{-- !THÊM SẢN PHẨM MỚI! --}}
        <div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm sản phẩm mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="newProduct.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mã vạch </label>
                                <div class="">
                                    <input cleave="options.code" ng-model="newProduct.code" type="text" class="form-control input-sm"
                                           placeholder="Nhập mã vạch..." required>
                                </div>
                            </div>

                            {{-- Lựa chọn mục --}}
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#menu1"> Mô tả </a></li>
                                <li> <a data-toggle="tab" href="#menu2"> Hướng dẫn sử dụng </a></li>
                                <li> <a data-toggle="tab" href="#menu3"> Thông tin </a></li>
                                <li> <a data-toggle="tab" href="#menu4"> Tồn kho </a></li>
                                <li> <a data-toggle="tab" href="#menu5"> Chính sách bán hàng </a></li>
                                <li> <a data-toggle="tab" href="#menu6"> Thuộc tính </a></li>
                                <li> <a data-toggle="tab" href="#menu7"> Hình ảnh </a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="menu1" class="tab-pane fade in active">
                                    <h3> </h3>
                                    <textarea id="newDescription" name="editor1" ng-model="new.description" class="ckeditor">
                                    </textarea>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h3> </h3>
                                    <textarea id="newUserGuide" name="editor2" ng-model="new.user_guide" class="ckeditor">
                                    </textarea>
                                </div>
                                <div id="menu3" class="tab-pane fade">
                                    <h3> </h3>
                                    <div class="form-group">
                                        <label class=""> Nhóm sản phẩm </label>
                                        <div class="">
                                            <select ng-model="newProduct.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Nhà sản xuất </label>
                                        <div class="">
                                            <select ng-model="newProduct.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đơn vị tính </label>
                                        <div class="">
                                            <select ng-model="newProduct.unit_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="unit in units" value="@{{unit.id}}"> @{{unit.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu4" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối thiểu </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="newProduct.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối đa </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="newProduct.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Bảo hành </label>
                                        <div class="">
                                            <input ng-model="newProduct.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian bảo hành...">
                                        </div>
                                        <div class="">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đổi hàng </label>
                                        <div class="">
                                            <input ng-model="newProduct.return_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian đổi trả...">
                                        </div>
                                        <div class="">
                                            ngày
                                        </div>
                                    </div>
                                </div>
                                <div id="menu6" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Khối lượng </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="newProduct.weight" type="text" class="form-control input-sm"
                                                   placeholder="Nhập khối lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Kích thước </label>
                                        <div class="">
                                            <input ng-model="new.size" type="text" class="form-control input-sm"
                                                   placeholder="Nhập kích thước...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Thể tích </label>
                                        <div class="">
                                            <input ng-model="newProduct.volume" type="text" class="form-control input-sm"
                                                   placeholder="Nhập thể tích...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Hình ảnh</label>
                                        <div class="">
                                            <form id="my-dropzone" action="{{route('uploadImage')}}" class="dropzone"> {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createProduct()" type="submit" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
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