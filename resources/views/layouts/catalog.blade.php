<!-- Danh sách các chức năng hệ thống -->
<div ng-controller="HomeController">
<div class="w3-sidebar w3-collapse w3-border-right" id="mySidebar" style="padding: 5px;">
    <div class="panel-group" id="accordion">

        {{-- TRANG CHỦ --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="{{ route('home') }}">
                        <span class="glyphicon glyphicon-home"></span> &nbsp; Trang chủ </a>
                </h4>
            </div>
        </div>

        {{-- BÁN HÀNG--}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('order') != -1 || roles.indexOf('price-output') != -1 || roles.indexOf('return') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        <span class="glyphicon glyphicon-shopping-cart"></span> &nbsp; Bán hàng </a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('order') != -1" href="list-order" class="list-group-item"> Đơn hàng </a>
                    <a ng-show="roles.indexOf('price-output') != -1" href="{{ route('list-price-output') }}" class="list-group-item"> Bảng giá bán </a>
                    {{--<a ng-show="roles.indexOf('return') != -1" href="{{ route('list-return-product') }}" class="list-group-item"> Trả về </a>--}}
                </div>
            </div>
        </div>

        {{-- SẢN PHẨM --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('product') != -1 || roles.indexOf('manufacturer') != -1 || roles.indexOf('supplier') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                        <span class="glyphicon glyphicon-scale"></span> &nbsp; @lang('catalog.product') </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('product') != -1" href="{{route('list-product')}}" class="list-group-item"> Sản phẩm </a>
                    <a ng-show="roles.indexOf('product') != -1" href="{{route('list-category')}}" class="list-group-item"> Nhóm sản phẩm </a>
                    <a ng-show="roles.indexOf('product') != -1" href="{{route('list-attribute')}}" class="list-group-item"> Thuộc tính sản phẩm </a>
                    <a ng-show="roles.indexOf('product') != -1" href="{{route('list-unit')}}" class="list-group-item"> Đơn vị tính </a>
                    <a ng-show="roles.indexOf('supplier') != -1" href="{{route('list-supplier')}}" class="list-group-item"> Nhà cung cấp </a>
                    <a ng-show="roles.indexOf('manufacturer') != -1" href="{{route('list-manufacturer')}}" class="list-group-item"> Nhà sản xuất </a>
                </div>
            </div>
        </div>

        {{-- KHO --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('store') != -1 || roles.indexOf('product-in-store') != -1 || roles.indexOf('price-input') != -1 || roles.indexOf('input-store') != -1 || roles.indexOf('store-tranfer') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                        <span class="glyphicon glyphicon-briefcase"></span> &nbsp; @lang('catalog.store') </a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('store') != -1" href="{{route('list-store')}}" class="list-group-item"> Danh sách kho </a>
                    <a ng-show="roles.indexOf('input-store') != -1" href="{{route('list-input-store')}}" class="list-group-item"> Nhập kho </a>
                    <a ng-show="roles.indexOf('store-output') != -1" href="{{route('list-store-output')}}" class="list-group-item"> Xuất kho </a>
                    <a ng-show="roles.indexOf('store-tranfer') != -1" href="{{route('list-store-tranfer')}}" class="list-group-item"> Chuyển kho </a>
                    <a ng-show="roles.indexOf('product-in-store') != -1" href="{{route('list-product-in-store')}}" class="list-group-item"> Sản phẩm trong kho </a>
                    <a ng-show="roles.indexOf('price-input') != -1" href="{{route('list-price-input')}}" class="list-group-item"> Bảng giá mua </a>
                </div>
            </div>
        </div>

        {{-- KẾ TOÁN --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('account') != -1 || roles.indexOf('voucher') != -1 || roles.indexOf('customer-invoice') != -1 || roles.indexOf('supplier-invoice') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                        <span class="glyphicon glyphicon-list-alt"></span> &nbsp; @lang('catalog.accountant') </a>
                </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('account') != -1" href="{{ route('list-account') }}" class="list-group-item"> Danh sách tài khoản </a>
                    <a ng-show="roles.indexOf('voucher') != -1" href="{{ route('list-voucher') }}" class="list-group-item"> Phiếu thu, phiếu chi </a>
                    <a ng-show="roles.indexOf('customer-invoice') != -1" href="{{ route('list-customer-invoice') }}" class="list-group-item"> Khách hàng thanh toán </a>
                    <a ng-show="roles.indexOf('supplier-invoice') != -1" href="{{ route('list-input-store-invoice') }}" class="list-group-item"> Thanh toán nhà cung cấp </a>
                </div>
            </div>
        </div>

        {{-- BÁO CÁO --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('report') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                        <span class="glyphicon glyphicon-duplicate"></span> &nbsp; @lang('catalog.report') </a>
                </h4>
            </div>
            <div id="collapse6" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{ route('top-product') }}" class="list-group-item"> Sản phẩm bán chạy </a>
                    <a href="{{ route('report-revenue') }}" class="list-group-item"> Doanh thu bán hàng </a>
                    <a href="{{ route('report-input-store') }}" class="list-group-item"> Bảng kê nhập kho </a>
                    <a href="{{ route('report-product-in-store') }}" class="list-group-item"> Bảng kê tồn kho </a>
                </div>
            </div>
        </div>

        {{-- KHÁCH HÀNG --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('customer') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                        <span class="glyphicon glyphicon-education"></span> &nbsp; @lang('catalog.customer') </a>
                </h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('customer') != -1" href="{{route('list-customer')}}" class="list-group-item"> Danh sách khách hàng </a>
                    <a ng-show="roles.indexOf('customer') != -1" href="{{route('list-customer-group')}}" class="list-group-item"> Nhóm khách hàng </a>
                </div>
            </div>
        </div>

        {{-- NHÂN VIÊN --}}
        <div class="panel w3-blue-grey" ng-show="roles.indexOf('user') != -1 || roles.indexOf('position') != -1">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                        <span class="glyphicon glyphicon-user"></span> &nbsp; Nhân viên </a>
                </h4>
            </div>
            <div id="collapse8" class="panel-collapse collapse">
                <div class="list-group">
                    <a ng-show="roles.indexOf('user') != -1" href="{{route('list-user')}}" class="list-group-item"> Quản lý nhân viên </a>
                    <a ng-show="roles.indexOf('position') != -1" href="{{route('list-position')}}" class="list-group-item"> Quản lý chức vụ </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>