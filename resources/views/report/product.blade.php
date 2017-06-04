@extends('layouts.app')

@section('title')
    Sản phẩm được quan tâm nhiều
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Top 10 sản phẩm bán chạy </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="row">
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="btn-group">
                    <button id="viewList" type="button" class="btn btn-sm btn-default w3-blue-grey">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <button id="viewGrid" type="button" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-signal"></span>
                    </button>
                </div>
            </div>
        </div>

        <hr> </hr>

        <h4 align="center"> Biểu đồ thống kê 10 sản phẩm bán chạy </h4>

        {{-- DANH SÁCH SẢN PHẨM --}}
        <table id="list" class="w3-table table-hover table-bordered w3-centered">
            <thead>
            <tr class="w3-blue-grey">
                <th> Mã SP </th>
                <th> Tên </th>
                <th> Mã vạch </th>
                <th> Đơn vị tính </th>
                <th> Số lượng bán ra </th>
            </thead>
            <tbody>
                <tr class="item" ng-if="topProducts.length > 0" dir-paginate="product in topProducts | itemsPerPage: 8" ng-click="readProduct(product)">
                <td data-toggle="modal" data-target="#readProduct"> SP@{{("000"+product.product_id).slice(-4)}} </td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.name}} </td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.code }}</td>
                <td data-toggle="modal" data-target="#readProduct" ng-repeat="item in products" ng-if="item.id==product.product_id"> @{{ item.unit.name }} </td>
                <td data-toggle="modal" data-target="#readProduct"> @{{ product.sum | number: 0 }}</td>
            </tr>
            <tr class="item" ng-if="topProducts.length==0">
                <td colspan="7"> Không có dữ liệu </td>
            </tr>
            </tbody>
        </table>

        <div id="grid" class="container-fluid" hidden>
            <canvas class="chart-horizontal-bar" chart-series="series" chart-data="data" chart-labels="labels" ng-show="data.length>0"></canvas>
           	<h1 ng-show="data.length==0"> Không có dữ liệu </h1>
        </div>

        {{-- Xem thông tin sản phẩm --}}
        <div class="modal fade" id="readProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title w3-text-blue" id="myModalLabel"> Xem thông tin sản phẩm </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3"> Tên </label>
                                <div class="col-sm-9">
                                    <input id="name" ng-model="selected.name" type="text" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3"> Mã vạch </label>
                                <div class="col-sm-9">
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
                                        <label class="col-sm-3"> Nhóm sản phẩm </label>
                                        <div class="col-sm-9">
                                            <select id="category" ng-model="selected.category_id" class="form-control input-sm">
                                                <option value="" selected> --Không chọn-- </option>
                                                <option ng-repeat="category in categorys" ng-selected="selected.category_id===category.id" value="@{{category.id}}"> @{{category.name}} </option>
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
                                    <div class="form-group">
                                        <label class="col-sm-3"> Giá Web </label>
                                        <div class="col-sm-7">
                                            <input id="web_price" cleave="options.numeral" ng-model="selected.web_price" type="text" class="form-control input-sm" placeholder="Nhập giá...">
                                        </div>
                                        <div class="col-sm-2">
                                            <label> VNĐ </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu4" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối thiểu </label>
                                        <div class="col-sm-9">
                                            <input id="min_inventory" cleave="options.numeral" ng-model="selected.min_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Không có">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Tồn kho tối đa </label>
                                        <div class="col-sm-9">
                                            <input id="max_inventory" cleave="options.numeral" ng-model="selected.max_inventory" type="text" class="form-control input-sm input-numeral"
                                                   placeholder="Không có">
                                        </div>
                                    </div>
                                </div>
                                <div id="selectMenu5" class="tab-pane fade">
                                    <h3></h3>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Bảo hành </label>
                                        <div class="col-sm-8">
                                            <input id="warranty_period" ng-model="selected.warranty_period" type="number" class="form-control input-sm"
                                                   placeholder="Không có">
                                        </div>
                                        <div class="col-sm-1">
                                            tháng
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3"> Đổi hàng </label>
                                        <div class="col-sm-8">
                                            <input id="return_period" ng-model="selected.return_period" type="number" class="form-control input-sm"
                                                   placeholder="Không có">
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
                                            <input id="weight" ng-model="selected.weight" type="text" class="form-control input-sm">
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
                                        <div class="col-xs-4">
                                            <form id="my_dropzone02" method="post" action="{{route('uploadImage')}}" class="dropzone" enctype="multipart/form-data"> {{csrf_field()}}
                                                <div class="dz-message needsclick">
                                                    <h3> Kéo thả ở đây </h3> hoặc
                                                    <strong> nhấn vào đây </strong>
                                                </div>
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-xs-4" align="center">
                                            <img src="@{{selected.default_image}}" class="image"> <br/>
                                        </div>
                                        <div class="col-xs-4" align="center">
                                            <div class="thumbnail col-xs-4" ng-repeat="item in selected.images" align="center">
                                                <img src="@{{item.image}}" align="center">
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
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Đóng </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection