@extends('layouts.app')

@section('title')
    Larose | Danh sách sản phẩm
@endsection

@section('location')
    <li> Quản lý sản phẩm </li>
@endsection

@section('content')
    <div ng-controller="ProductController">

        {{-- !TÌM KIẾM SẢN PHẨM!--}}
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createProduct">
                     Thêm mới </button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#inputFromFile">
                    <span class="glyphicon glyphicon-file"></span> Nhập từ file </button>
                <a href="{{route('downloadProductTemplate')}}" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-download-alt"></span> Mẫu nhập </a>
            </div>
            <div class="col-lg-2 col-md-2">
                <input ng-model="term1.name" class="form-control input-sm" placeholder="Nhập tên sản phẩm...">
            </div>
            <div class="col-lg-2 col-md-2">
                <select ng-model="term2.status" class="form-control input-sm">
                    <option value="" selected> -- Tất cả -- </option>
                    <option value="1"> Còn hàng </option>
                    <option value="0"> Hết hàng </option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2">
                <button class="btn btn-sm btn-info"> Tổng số: @{{products.length}} mục </button>
            </div>
        </div>

        <hr/>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        @endif

        {{-- !DANH SÁCH SẢN PHẨM! --}}
        <table class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã SP </th>
                <th> Tên </th>
                <th> Mã vạch </th>
                <th> Đơn vị tính </th>
                <th> Số lượng </th>
                <th> Tình trạng </th>
                <th> Xóa </th>
            </thead>
            <tbody>
            <tr class="item" ng-show="products.length > 0" dir-paginate="product in products | filter:term1 | filter:term2 | itemsPerPage: 7" ng-click="readProduct(product)">
                <td> SP-@{{product.id}} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.name}} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.code }}</td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="unit in units" ng-show="unit.id==product.unit_id">
                    @{{ unit.name }}
                </td>
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

        {{-- !PHÂN TRANG! --}}
        <div style="margin-left: 35%; bottom:0; position: fixed;">
            <dir-pagination-controls max-size="5"> </dir-pagination-controls>
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
                                    <input ng-model="new.name" type="text" class="form-control input-sm"
                                           placeholder="Nhập tên..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mã vạch </label>
                                <div class="col-sm-9">
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
                                        <label class="col-sm-3"> Nhóm sản phẩm </label>
                                        <div class="col-sm-9">
                                            <select ng-model="new.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" value="@{{category.id}}"> @{{category.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Nhà sản xuất </label>
                                        <div class="col-sm-9">
                                            <select ng-model="new.manufacturer_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="manufacturer in manufacturers" value="@{{manufacturer.id}}"> @{{manufacturer.name}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đơn vị tính </label>
                                        <div class="col-sm-9">
                                            <select ng-model="new.unit_id" class="form-control input-sm">
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
                                            <input cleave="options.numeral" ng-model="new.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối đa </label>
                                        <div class="col-sm-9">
                                            <input cleave="options.numeral" ng-model="new.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Nhập số lượng...">
                                        </div>
                                    </div>
                                </div>
                                <div id="menu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Bảo hành </label>
                                        <div class="col-sm-8">
                                            <input ng-model="new.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Nhập thời gian bảo hành...">
                                        </div>
                                        <div class="col-sm-1">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đổi hàng </label>
                                        <div class="col-sm-8">
                                            <input ng-model="new.return_period" type="number" class="form-control input-sm"
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
                                            <input cleave="options.numeral" ng-model="new.weight" type="text" class="form-control input-sm"
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
                                            <input ng-model="new.volume" type="text" class="form-control input-sm"
                                                   placeholder="Nhập thể tích...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <button class="btn btn-sm w3-blue-grey" data-toggle="modal" data-target="#chooseAttribute"> Thêm thuộc tính </button>
                                        </div>
                                        <div class="col-sm-9">
                                            <dir-pagination-controls pagination-id="attribute" max-size="4"> </dir-pagination-controls>
                                        </div>
                                    </div>
                                    {{-- THÊM THUỘC TÍNH SẢN PHẨM --}}
                                    <div class="form-group" ng-show="data.length > 0"
                                         dir-paginate="item in data | itemsPerPage: 2" pagination-id="attribute">
                                        <label class="col-sm-3"> @{{item.name}} </label>
                                        <div class="col-sm-8">
                                            <input ng-model="item.description" type="text" class="form-control input-sm"
                                                   placeholder="Nhập mô tả...">
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="btn btn-sm btn-danger" ng-click="deleteAttribute(item)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Hình ảnh</label>
                                        <div class="col-sm-9">
                                            <form id="my-dropzone" method="post" action="{{route('uploadImage')}}" class="dropzone"> {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                                {{--<div class="fallback">--}}
                                                    <input name="file" type="file">
                                                {{--</div>--}}
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
                                    <input id="code" cleave="options.code" ng-model="selected.code" type="text" class="form-control input-sm"
                                           placeholder="Nhập mã vạch..." required>
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
                                            <input id="weight" cleave="options.numeral" ng-model="selected.weight" type="text" class="form-control input-sm"
                                                   placeholder="Nhập khối lượng...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Kích thước </label>
                                        <div class="col-sm-9">
                                            <input id="size" ng-model="selected.size" type="text" class="form-control input-sm"
                                                   placeholder="Nhập kích thước...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Thể tích </label>
                                        <div class="col-sm-9">
                                            <input id="volume" ng-model="selected.volume" type="text" class="form-control input-sm"
                                                   placeholder="Nhập thể tích...">
                                        </div>
                                    </div>
                                    <div class="form-group" ng-show="detail.length > 0"
                                         dir-paginate="item in detail | itemsPerPage: 2" pagination-id="attribute">
                                        <label class="col-sm-3"> @{{item.name}} </label>
                                        <div class="col-sm-9">
                                            <input ng-model="item.description" type="text" class="form-control input-sm"
                                                   placeholder="Nhập mô tả...">
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu7" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Hình ảnh</label>
                                        <div class="col-sm-9">
                                            <div id="my-dropzone" action="{{route('uploadImage')}}" class="dropzone">  {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <input type="file" name="file" accept=".xlsx" required>
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