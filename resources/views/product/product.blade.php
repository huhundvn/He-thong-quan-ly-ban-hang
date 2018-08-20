@extends('layouts.app')

@section('title')
    Danh sách sản phẩm
@endsection

@section('location')
    <li> Sản phẩm </li>
    <li> Danh sách sản phẩm </li>
@endsection

@section('content')
    <div ng-controller="ProductController">

        {{-- TÌM KIẾM SẢN PHẨM--}}
        <div class="row">
            <div class="col-lg-4  ">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createProduct">
                    <span class="glyphicon glyphicon-plus w3-hide-medium"></span> Thêm SP </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Từ File </button>
                <a href="{{route('downloadProductTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-2  ">
                <input ng-model="term1.name" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
            </div>
            <div class="col-lg-2  ">
                <select ng-model="term2.category_id" class="form-control input-sm">
                    <option value="" selected> -- Nhóm SP -- </option>
                    <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                </select>
            </div>
            <div class="col-lg-2  ">
                <select ng-model="term3.status" class="form-control input-sm">
                    <option value="" selected> -- Trạng thái -- </option>
                    <option value="1"> Còn hàng </option>
                    <option value="0"> Hết hàng </option>
                </select>
            </div>
            <!-- <div class="col-lg-1 col-md-1">
                <button class="btn btn-sm btn-info"> @{{ products.length }} mục </button>
            </div> -->
            <div class="col-lg-2  ">
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

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- DANH SÁCH SẢN PHẨM --}}
        <table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã SP </th>
                <th> Tên </th>
                <th> Mã vạch </th>
                <th> Đơn vị tính </th>
                <th> Tổng số lượng </th>
                <th> Tình trạng </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="products.length > 0" dir-paginate="product in products | filter:term1 | filter:term2 | filter:term3 | itemsPerPage: 8" ng-click="readProduct(product)">
                <td> SP@{{("000"+product.id).slice(-4)}} </td>
                <td data-toggle="modal" data-target="#readProduct"> <p class="entry-text"> @{{ product.name}} </p> </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.code }}</td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.unit.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.total_quantity | number: 0 }}</td>
                <td data-toggle="modal" data-target="#readProduct">
                    <p ng-show="product.status == 1"> Còn hàng </p>
                    <p ng-show="product.status == 0"> Hết hàng </p>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProduct" ng-show="0==product.status">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <tr class="item" ng-show="products.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        {{-- Xem dạng hình ảnh--}}
        <div id="grid" class="row" align="center" hidden>
            <div class="col-lg-3  " style="margin-bottom: 20px" ng-show="products.length > 0" dir-paginate="product in products | filter:term1 | filter:term2 | filter:term3 | itemsPerPage: 8" ng-click="readProduct(product)">
                <img src="@{{product.default_image}}" class="image">
                <b> <h5 class="w3-text-blue-gray entry-text"> @{{ product.name}} </h5>
                Tổng số: @{{product.total_quantity}} sản phẩm </b>
                <div class="middle">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#readProduct"> Xem SP </button>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProduct" ng-show="0==product.status"> Xóa SP </button>
                </div>
            </div>
        </div>

        {{-- PHÂN TRANG --}}
        <div style="margin-left: 40%">
            <dir-pagination-controls max-size="4"> </dir-pagination-controls>
        </div>


        {{-- !THÊM SẢN PHẨM MỚI! --}}
        <div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-green" id="myModalLabel"> Thêm sản phẩm mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="new.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mã vạch </label>
                                <div class="">
                                    <input cleave="options.code" ng-model="new.code" type="text" class="form-control input-sm"
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
                                            <select ng-model="new.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCategory"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Nhà sản xuất </label>
                                        <div class="">
                                            <select ng-model="new.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createManufacturer"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đơn vị tính </label>
                                        <div class="">
                                            <select ng-model="new.unit_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="unit in units" value="@{{unit.id}}"> @{{unit.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createUnit"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Giá Web </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="new.web_price" type="text" class="form-control input-sm" placeholder="Nhập giá...">
                                        </div>
                                        <div class="">
                                            <label> VNĐ </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu4" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối thiểu </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="new.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối đa </label>
                                        <div class="">
                                            <input cleave="options.numeral" ng-model="new.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Bảo hành </label>
                                        <div class="">
                                            <input ng-model="new.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian bảo hành...">
                                        </div>
                                        <div class="">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đổi hàng </label>
                                        <div class="">
                                            <input ng-model="new.return_period" type="number" class="form-control input-sm"
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
                                            <input ng-model="new.weight" type="text" class="form-control input-sm" placeholder="Nhập khối lượng...">
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
                                            <input ng-model="new.volume" type="text" class="form-control input-sm"
                                                   placeholder="Nhập thể tích...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="">
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#chooseAttribute"> Thêm thuộc tính </button>
                                        </div>
                                    </div>
                                    {{-- THÊM THUỘC TÍNH SẢN PHẨM --}}
                                    <div class="form-group" ng-show="data.length > 0" ng-repeat="item in data">
                                        <label class=""> @{{item.name}} </label>
                                        <div class="">
                                            <input ng-model="item.description" type="text" class="form-control input-sm"
                                                   placeholder="Nhập mô tả...">
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-danger" ng-click="deleteAttribute(item)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <div class="">
                                            <form id="my_dropzone" method="post" action="{{route('uploadImage')}}" class="dropzone"> {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                                <div class="fallback">
                                                    <input name="file" type="file">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="">
                                            <button ng-click="uploadImage()" class="btn btn-sm btn-success"> Upload ảnh </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createProduct()" type="submit" class="btn btn-sm btn-success"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </div>
            </div>
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
                                <label class=""> Tên </label>
                                <div class="">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mã vạch </label>
                                <div class="">
                                    <input id="code" cleave="options.code" ng-model="selected.code" type="text" class="form-control input-sm"
                                           placeholder="Không có">
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
                                <li> <a data-toggle="tab" href="#selectMenu8"> Đánh giá </a></li>
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
                                        <label class=""> Nhóm sản phẩm </label>
                                        <div class="">
                                            <select id="category" ng-model="selected.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" ng-selected="selected.category_id===category.id" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createCategory"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Nhà sản xuất </label>
                                        <div class="">
                                            <select id="manufacturer" ng-model="selected.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" ng-selected="manufacturer.id==selected.manufacturer_id" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createManufacturer"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đơn vị tính </label>
                                        <div class="">
                                            <select id="unit" ng-model="selected.unit_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="unit in units" ng-selected="unit.id==selected.unit_id" value="@{{unit.id}}"> @{{unit.name}} </option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createUnit"> Thêm </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Giá Web </label>
                                        <div class="">
                                            <input id="web_price" cleave="options.numeral" ng-model="selected.web_price" type="text" class="form-control input-sm" placeholder="Nhập giá...">
                                        </div>
                                        <div class="">
                                            <label> VNĐ </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu4" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối thiểu </label>
                                        <div class="">
                                            <input id="min_inventory" cleave="options.numeral" ng-model="selected.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Không có">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Tồn kho tối đa </label>
                                        <div class="">
                                            <input id="max_inventory" cleave="options.numeral" ng-model="selected.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Không có">
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Bảo hành </label>
                                        <div class="">
                                            <input id="warranty_period" ng-model="selected.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Không có">
                                        </div>
                                        <div class="">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Đổi hàng </label>
                                        <div class="">
                                            <input id="return_period" ng-model="selected.return_period" type="number" class="form-control input-sm"
                                                   placeholder="Không có">
                                        </div>
                                        <div class="">
                                            ngày
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu6" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class=""> Khối lượng </label>
                                        <div class="">
                                            <input id="weight" ng-model="selected.weight" type="text" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Kích thước </label>
                                        <div class="">
                                            <input id="size" ng-model="selected.size" type="text" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class=""> Thể tích </label>
                                        <div class="">
                                            <input id="volume" ng-model="selected.volume" type="text" class="form-control input-sm">
                                        </div>
                                    </div>

                                    {{-- Danh sách thuộc tính hiện có sản phẩm --}}
                                    <div class="form-group" ng-show="selected.attributes.length > 0" ng-repeat="item in selected.attributes">
                                        <label class="" ng-repeat="attribute in attributes" ng-show="attribute.id==item.attribute_id">
                                            @{{attribute.name}}
                                        </label>
                                        <div class="">
                                            <input id="volume" ng-model="item.description" type="text" class="form-control input-sm">
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-danger" ng-click="deleteProductAttribute(item)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="">
                                            <button id="addAttribute" class="btn btn-sm btn-success" data-toggle="modal" data-target="#chooseAttribute"> Thêm thuộc tính </button>
                                        </div>
                                    </div>

                                    {{-- THÊM THUỘC TÍNH SẢN PHẨM --}}
                                    <div class="form-group" ng-show="data.length > 0" ng-repeat="item in data">
                                        <label class=""> @{{item.name}} </label>
                                        <div class="">
                                            <input ng-model="item.description" type="text" class="form-control input-sm"
                                                   placeholder="Nhập mô tả...">
                                        </div>
                                        <div class="">
                                            <button class="btn btn-sm btn-danger" ng-click="deleteAttribute(item)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hình ảnh sản phẩm --}}
                                <div id="selectMenu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <div class="">
                                            <form id="my_dropzone02" method="post" action="{{route('uploadImage')}}" class="dropzone" enctype="multipart/form-data"> {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple>
                                                </div>
                                            </form>
                                            <h3></h3>
                                            <button id="addImage" ng-click="uploadImage()" class="btn btn-success"> Upload ảnh </button>
                                        </div>
                                        <div class="" align="center">
                                            <img src="@{{selected.default_image}}" class="image"> <br/>
                                            <a href="" ng-click="selected.default_image=null"> Xóa </a>
                                        </div>
                                        <div class="" align="center">
                                            <div class="thumbnail " ng-repeat="item in selected.images" align="center">
                                                <img src="@{{item.image}}" align="center">
                                                <div class="caption" align="center">
                                                    <a href="" ng-click="deleteProductImage(item)"> Xóa </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Đánh giá sản phẩm --}}
                                <div id="selectMenu8" class="tab-pane fade">
                                    <h3> </h3>
                                    <div class="fb-comments" data-href="http://larose-admin.herokuapp.com/list-product" data-width="800" data-num-posts="5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="updateProduct" type="button" class="btn btn-sm btn-info"> Chỉnh sửa </button>
                            <button id="submit" ng-click="updateProduct()" type="submit" class="btn btn-sm btn-success" hidden> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- !TẠO ĐƠN VỊ TÍNH MỚI! --}}
        <div class="modal fade" id="createUnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm đơn vị tính mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="newUnit.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mô tả </label>
                                <div class="">
                                    <textarea ng-model="newUnit.description" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createUnit()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !TẠO NHÀ CUNG CẤP MỚI! --}}
        <div class="modal fade" id="createManufacturer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm nhà sản xuất mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Thương hiệu </label>
                                <div class="">
                                    <input ng-model="newManufacturer.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Quốc gia </label>
                                <div class="">
                                    <input ng-model="newManufacturer.country" type="text" class="form-control input-sm" placeholder="Nhập quốc gia...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mô tả </label>
                                <div class="">
                                    <textarea ng-model="newManufacturer.description" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createManufacturer()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- !TẠO DANH MỤC SẢN PHẨM MỚI! --}}
        <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Thêm danh mục mới </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class=""> Tên </label>
                                <div class="">
                                    <input ng-model="newCategory.name" type="text" class="form-control input-sm" placeholder="Nhập tên...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Danh mục cha </label>
                                <div class="">
                                    <select ng-model="newCategory.parent_id" class="form-control input-sm">
                                        <option value="" selected> --Không chọn-- </option>
                                        <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=""> Mô tả </label>
                                <div class="">
                                    <textarea ng-model="newCategory.description" class="form-control"> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button ng-click="createCategory()" type="button" class="btn btn-sm btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- CHỌN THUỘC TÍNH --}}
        <div class="modal fade" id="chooseAttribute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-blue" id="myModalLabel"> Chọn thuộc tính </h4>
                    </div>
                    <div class="modal-body">
                        <input ng-model="termAttribute" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
                        <h1></h1>
                        {{--DANH SÁCH THUỘC TÍNH--}}
                        <table class="w3-table table-hover table-bordered w3-centered">
                            <thead class="w3-blue-grey">
                            <th> Tên </th>
                            <th> Mô tả </th>
                            </thead>
                            <tbody>
                            <tr ng-show="attributes.length > 0" class="item"
                                dir-paginate="attribute in attributes | filter:termAttribute | itemsPerPage: 4"
                                ng-click="addAttribute(attribute)" pagination-id="chooseAttribute">
                                <td> @{{ attribute.name }} </td>
                                <td> @{{ attribute.description }} </td>
                            </tr>
                            <tr class="item" ng-show="attributes.length==0">
                                <td colspan="4"> Không có dữ liệu </td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="margin-left: 35%;">
                            <dir-pagination-controls pagination-id="chooseAttribute" max-size="4"> </dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- !NHẬP TỪ FILE! --}}
        <div class="modal fade" id="inputFromFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form enctype="multipart/form-data" action="{{route('importProductFromFile')}}" method="post"> {{csrf_field()}}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Nhập từ File </h4>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" accept=".xlsx">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info"> Xác nhận </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- !XÓA SẢN PHẨM! --}}
        <div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title w3-text-red" id="myModalLabel"> Xóa sản phẩm </h4>
                    </div>
                    <div class="modal-body">
                        Bạn thực sự muốn xóa sản phẩm này?
                    </div>
                    <div class="modal-footer">
                        <button ng-click="deleteProduct()" type="submit" class="btn btn-danger"> Xác nhận </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('angularJS/ProductController.js') }}"></script>

@endsection