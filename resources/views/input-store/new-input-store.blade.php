@extends('layouts.app')

@section('title')
    Larose | Yêu cầu nhập hàng
@endsection

@section('location')
    <li> Yêu cầu nhập hàng </li>
@endsection

@section('content')
    <div ng-controller="InputStoreController">

        {{-- NHẬP SẢN PHẨM --}}
        <div class="row">
            <div class="col-lg-3 col-xs-3">
                <button type="submit" class="btn btn-success btn-sm" ng-click="createInputStore()"> Xác nhận  </button>
                <a href="{{route('list-input-store')}}" class="btn btn-default btn-sm"> Quay lại </a>
            </div>
            <div class="col-lg-3 col-xs-3">
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseProduct"> Chọn SP </button>
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#createProduct"> Thêm SP mới </button>
                <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#readReport"> Xem trước </button>
            </div>
            <div class="col-lg-3 col-xs-3">
                <button class="btn btn-sm w3-blue-grey"> Tổng tiền: @{{ getTotal() | number:0 }} VNĐ </button>
            </div>
            <div class="col-lg-3 col-xs-3">
                <button class="btn btn-sm w3-blue-grey"> Danh sách: @{{ data.length }} mục </button>
            </div>
        </div>

        <hr/>

        {{-- Thông tin nhập--}}
        <div class="row">
            <div class="col-xs-2">
                <label> Ngày nhập dự kiến </label>
                <input ng-model="info.input_date" type="date" class="form-control input-sm">
            </div>
            <div class="col-xs-2">
                <label> Kho nhập </label>
                <select ng-model="info.store_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{store.name}} </option>
                </select>
            </div>
            <div class="col-xs-2">
                <label> Nhà cung cấp </label>
                <select ng-model="info.supplier_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}"> @{{supplier.name}} </option>
                </select>
            </div>
            <div class="col-xs-4">
                <label> Bảng giá mua </label>
                <select ng-model="info.price_input_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="priceInput in priceInputs" value="@{{priceInput.id}}"> @{{priceInput.name}} </option>
                </select>
            </div>
            <div class="col-xs-2">
                <label> Tài khoản thanh toán </label>
                <select ng-model="info.account_id" class="form-control input-sm">
                    <option value="" selected> --Không chọn-- </option>
                    <option ng-repeat="account in accounts" value="@{{account.id}}"> @{{account.name}} </option>
                </select>
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
        </table>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 35%;">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
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
                        </table>
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
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input ng-model="newProduct.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mã vạch </label>
                                <div class="col-sm-9">
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
                                        <label class="col-sm-3"> Nhóm sản phẩm </label>
                                        <div class="col-sm-9">
                                            <select ng-model="newProduct.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Nhà sản xuất </label>
                                        <div class="col-sm-9">
                                            <select ng-model="newProduct.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đơn vị tính </label>
                                        <div class="col-sm-9">
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
                                        <label class="col-sm-3"> Tồn kho tối thiểu </label>
                                        <div class="col-sm-9">
                                            <input cleave="options.numeral" ng-model="newProduct.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối đa </label>
                                        <div class="col-sm-9">
                                            <input cleave="options.numeral" ng-model="newProduct.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Bảo hành </label>
                                        <div class="col-sm-8">
                                            <input ng-model="newProduct.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian bảo hành...">
                                        </div>
                                        <div class="col-sm-1">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đổi hàng </label>
                                        <div class="col-sm-8">
                                            <input ng-model="newProduct.return_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian đổi trả...">
                                        </div>
                                        <div class="col-sm-1">
                                            ngày
                                        </div>
                                    </div>
                                </div>
                                <div id="menu6" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Khối lượng </label>
                                        <div class="col-sm-9">
                                            <input cleave="options.numeral" ng-model="newProduct.weight" type="text" class="form-control input-sm"
                                                   placeholder="Nhập khối lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Kích thước </label>
                                        <div class="col-sm-9">
                                            <input ng-model="new.size" type="text" class="form-control input-sm"
                                                   placeholder="Nhập kích thước...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Thể tích </label>
                                        <div class="col-sm-9">
                                            <input ng-model="newProduct.volume" type="text" class="form-control input-sm"
                                                   placeholder="Nhập thể tích...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Hình ảnh</label>
                                        <div class="col-sm-9">
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