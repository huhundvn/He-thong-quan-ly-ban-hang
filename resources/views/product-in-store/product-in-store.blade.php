@extends('layouts.app')

@section('title')
    Danh sách sản phẩm trong kho
@endsection

@section('location')
    <li> Kho hàng </li>
    <li> Danh sách sản phẩm trong kho </li>
@endsection

@section('content')
    <div ng-controller="ProductInStoreController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-2 col-xs-2">
                <a class="btn btn-sm btn-success" href="{{route('createInputStore')}}">
                    <span class="glyphicon glyphicon-plus"></span> Nhập hàng </a>
            </div>
            <div class="col-lg-2 col-xs-2">
                <input ng-model="term1.name" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term2.supplier_id" class="form-control input-sm">
                    <option value="" selected> -- Nhà cung cấp -- </option>
                    <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}"> @{{ supplier.name }} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <select ng-model="term3.store_id" class="form-control input-sm">
                    <option value="" selected> -- Tất cả các kho -- </option>
                    <option ng-repeat="store in stores" value="@{{store.id}}"> @{{ store.name }} </option>
                </select>
            </div>
            <div class="col-lg-2 col-xs-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{productInStores.length}} mục </button>
            </div>
            <div class="col-lg-2 col-xs-2">
                <div class="btn-group">
                    <button id="viewList" type="button" class="btn btn-sm btn-default w3-blue-grey">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <button id="viewGrid" type="button" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-th"></span>
                    </button>
                </div>
            </div>
        </div>

        <hr/>

        {{-- !DANH SÁCH SẢN PHẨM! --}}
        <table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã SP </th>
                <th> Tên </th>
                <th> Mã vạch </th>
                <th> Đơn vị tính </th>
                <th> Nhà cung cấp </th>
                <th> Số lượng </th>
                <th> Giá mua (VNĐ) </th>
                <th> Hạn sử dụng </th>
                <th> Kho hàng </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="productInStores.length > 0" dir-paginate="productInStore in productInStores | filter:term1 | filter:term2 | filter:term3 | itemsPerPage: 8" ng-click="readProduct(productInStore)">
                <td data-toggle="modal" data-target="#readProduct"> SP-@{{ productInStore.product_id }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.code }}</td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="unit in units" ng-show="unit.id==productInStore.unit_id">
                    @{{ unit.name }}
                </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.supplier.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.quantity | number: 0 }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.price_input | number: 0 }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.expried_date | date: "dd/MM/yyyy" }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ productInStore.store.name }} </td>
            </tr>
            <tr class="item" ng-show="productInStores.length==0">
                <td colspan="9"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        <div id="grid" class="row" align="center" hidden>
            <div class="col-lg-3" ng-show="productInStores.length > 0" dir-paginate="productInStore in productInStores | filter:term1 | filter:term2 | filter:term3 | itemsPerPage: 8" ng-click="readProduct(productInStore)">
                <img src="@{{productInStore.default_image}}" class="image">
                <b> <h5 class="w3-text-blue-gray"> <b> @{{productInStore.name}} </b> </h5>
                Giá nhập: @{{productInStore.price_input | number: 0}} VNĐ <br/>
                Đang có: @{{productInStore.quantity | number: 0}} sản phẩm <br/>
                Hạn dùng: @{{productInStore.expried_date | date: "dd/MM/yyyy" }}  </b> <br/>
                <div class="middle">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#readProduct"> Xem SP </button>
                </div>
            </div>
        </div>

        {{-- !PHÂN TRANG! --}}
        <div style="margin-left: 40%;">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>

        {{-- Xem thông tin sản phẩm --}}
        <div class="modal fade" id="readProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mã vạch </label>
                                <div class="col-sm-9">
                                    <input id="code" cleave="options.code" ng-model="selected.code" type="text" class="form-control input-sm">
                                </div>
                            </div>

                            {{-- Lựa chọn mục --}}
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#selectMenu1"> Mô tả </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu2"> Hướng dẫn sử dụng </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu3"> Thông tin </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu4"> Tồn kho </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu5"> Chính sách bán hàng </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu6"> Thuộc tính </a></li>
                                <li> <a data-toggle="tab" href="#selectMenu7"> Hình ảnh </a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="selectMenu1" class="tab-pane fade in active">
                                    <h3> </h3>
                                    <textarea id="description" name="editor3" ng-model="selected.description" class="ckeditor">
                                    </textarea>
                                </div>
                                <div id="selectMenu2" class="tab-pane fade">
                                    <h3> </h3>
                                    <textarea id="user_guide" name="editor4" ng-model="selected.user_guide" class="ckeditor">
                                    </textarea>
                                </div>
                                <div id="selectMenu3" class="tab-pane fade">
                                    <h3> </h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Nhóm sản phẩm </label>
                                        <div class="col-sm-9">
                                            <select id="category" ng-model="selected.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" ng-selected="category.id==selected.category_id" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Nhà sản xuất </label>
                                        <div class="col-sm-9">
                                            <select id="manufacturer" ng-model="selected.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" ng-selected="manufacturer.id==selected.manufacturer_id" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đơn vị tính </label>
                                        <div class="col-sm-9">
                                            <select id="unit" ng-model="selected.unit_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="unit in units" ng-selected="unit.id==selected.unit_id" value="@{{unit.id}}"> @{{unit.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu4" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối thiểu </label>
                                        <div class="col-sm-9">
                                            <input id="min_inventory" cleave="options.numeral" ng-model="selected.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối đa </label>
                                        <div class="col-sm-9">
                                            <input id="max_inventory" cleave="options.numeral" ng-model="selected.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Bảo hành </label>
                                        <div class="col-sm-8">
                                            <input id="warranty_period" ng-model="selected.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian bảo hành...">
                                        </div>
                                        <div class="col-sm-1">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đổi hàng </label>
                                        <div class="col-sm-8">
                                            <input id="return_period" ng-model="selected.return_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian đổi trả...">
                                        </div>
                                        <div class="col-sm-1">
                                            ngày
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu6" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Khối lượng </label>
                                        <div class="col-sm-9">
                                            <input id="weight" cleave="options.numeral" ng-model="selected.weight" type="text" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Kích thước </label>
                                        <div class="col-sm-9">
                                            <input id="size" ng-model="selected.size" type="text" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Thể tích </label>
                                        <div class="col-sm-9">
                                            <input id="volume" ng-model="selected.volume" type="text" class="form-control input-sm">
                                        </div>
                                    </div>

                                    {{-- Danh sách thuộc tính hiện có sản phẩm --}}
                                    <div class="form-group" ng-show="selected.attributes.length > 0" ng-repeat="item in selected.attributes">
                                        <label class="col-sm-3" ng-repeat="attribute in attributes" ng-show="attribute.id==item.attribute_id">
                                            @{{attribute.name}}
                                        </label>
                                        <div class="col-sm-9">
                                            <input id="volume" ng-model="item.description" type="text" class="form-control input-sm">
                                        </div>
                                    </div>
                                </div>

                                {{-- Hình ảnh sản phẩm --}}
                                <div id="selectMenu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <div class="col-sm-5" align="center">
                                            <img src="@{{selected.default_image}}" class="image w3-round">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('angularJS/ProductInStoreController.js') }}"></script>
@endsection