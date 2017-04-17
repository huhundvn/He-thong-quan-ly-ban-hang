<!-- Danh sách các chức năng hệ thống -->
<div class="w3-sidebar w3-collapse w3-animate-left w3-border-right" id="mySidebar" style="padding: 5px;"><br>
    <!-- hiển thị thông tin người dùng đăng nhập -->
    <div class="w3-container w3-row" align="center">
        <a href="{{route('home')}}">
            <img src="{{asset('icon_logo.png')}}" class="w3-circle w3-margin-right" height="50px">
        </a>
    </div>
    <br/>

    <div class="panel-group" id="accordion">

        {{-- Danh mục bán hàng--}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        <span class="glyphicon glyphicon-shopping-cart"></span> &nbsp; @lang('catalog.sale') </a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="#" class="list-group-item"> Đơn hàng </a>
                    <a href="{{route('list-price-output')}}" class="list-group-item"> Bảng giá bán </a>
                    <a href="#" class="list-group-item"> Trả về </a>
                </div>
            </div>
        </div>

        {{-- Danh mục sản phẩm--}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                        <span class="glyphicon glyphicon-scale"></span> &nbsp; @lang('catalog.product') </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{route('list-product')}}" class="list-group-item"> Sản phẩm </a>
                    <a href="{{route('list-category')}}" class="list-group-item"> Nhóm sản phẩm </a>
                    <a href="{{route('list-attribute')}}" class="list-group-item"> Thuộc tính sản phẩm </a>
                    <a href="{{route('list-unit')}}" class="list-group-item"> Đơn vị tính </a>
                    <a href="{{route('list-manufacturer')}}" class="list-group-item"> Nhà sản xuất </a>
                    <a href="{{route('list-supplier')}}" class="list-group-item"> Nhà cung cấp </a>
                </div>
            </div>
        </div>

        {{-- Danh mục khuyến mãi --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                        <span class="glyphicon glyphicon-star-empty"></span> &nbsp; @lang('catalog.promotion') </a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
            </div>
        </div>

        {{-- Danh mục kho --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                        <span class="glyphicon glyphicon-briefcase"></span> &nbsp; @lang('catalog.store') </a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{route('list-store')}}" class="list-group-item"> Danh sách kho </a>
                    <a href="{{route('list-input-store')}}" class="list-group-item"> Nhập hàng </a>
                    <a href="#" class="list-group-item"> Xuất kho </a>
                    <a href="#" class="list-group-item"> Điều chỉnh kho </a>
                    <a href="#" class="list-group-item"> Chuyển kho </a>
                </div>
            </div>
        </div>

        {{-- Danh mục kế toán --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                        <span class="glyphicon glyphicon-list-alt"></span> &nbsp; @lang('catalog.accountant') </a>
                </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{route('list-account')}}" class="list-group-item"> Danh sách tài khoản </a>
                    <a href="#" class="list-group-item"> Khoản thu </a>
                    <a href="#" class="list-group-item"> Khoản chi </a>
                </div>
            </div>
        </div>

        {{-- Danh mục báo cáo --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="{{route('home-report')}}">
                        <span class="glyphicon glyphicon-duplicate"></span> &nbsp; @lang('catalog.report') </a>
                </h4>
            </div>
        </div>

        {{-- Danh mục khách hàng--}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                        <span class="glyphicon glyphicon-education"></span> &nbsp; @lang('catalog.customer') </a>
                </h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{route('list-customer')}}" class="list-group-item"> Danh sách khách hàng </a>
                    <a href="{{route('list-customer-group')}}" class="list-group-item"> Nhóm khách hàng </a>
                    <a href="#" class="list-group-item"> Lịch sử mua hàng </a>
                </div>
            </div>
        </div>

        {{-- Danh mục nhân viên --}}
        <div class="panel w3-blue-grey">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                        <span class="glyphicon glyphicon-user"></span> &nbsp; @lang('catalog.user') </a>
                </h4>
            </div>
            <div id="collapse8" class="panel-collapse collapse">
                <div class="list-group">
                    <a href="{{route('list-user')}}" class="list-group-item"> Quản lý nhân viên </a>
                    <a href="{{route('list-position')}}" class="list-group-item"> Quản lý chức vụ </a>
                </div>
            </div>
        </div>


    </div>
</div>