<div class="w3-bar w3-small w3-blue-grey">
    <button class="w3-bar-item w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open()">
        <span class="glyphicon glyphicon-align-justify"></span>
    </button>
    <a href="{{route('home')}}" class="w3-button w3-hover-none w3-hover-text-light-grey"> Larose </a>

    {{-- Nếu là nhân viên hiện chức năng --}}
    @if(!Auth::guest())
    <div class="w3-dropdown-hover w3-right" >
        <button class="w3-button"> {{Auth::user()->name}} <span class="caret"></span> </button>
        <div class="w3-dropdown-content w3-bar-block w3-card-2" style="right:-100">
            <a href="#" class="w3-bar-item w3-button" data-toggle="modal" data-target="#changePass"> Đổi mật khẩu </a>
            <a href="#" class="w3-bar-item w3-button" data-toggle="modal" data-target="#logout"> Đăng xuất </a>
        </div>
    </div>
    @endif
    <a class="w3-button w3-hover-none w3-hover-text-light-grey w3-right" onclick="window.open('http://43.239.223.142:8088/')"> Cửa hàng Online </a>
</div>

{{-- ĐỔI MẬT KHẨU --}}
<div id="changePass" class="modal fade" role="dialog" ng-controller="HomeController">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title w3-text-blue"> Đổi mật khẩu </h4>
            </div>
            <form class="form-horizontal"> {{ csrf_field() }}
            <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-4"> Mật khẩu cũ </label>
                        <div class="col-sm-8">
                            <input ng-model="password.old_pass" type="password" class="form-control input-sm" placeholder="Nhập mật khẩu cũ...">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="col-sm-4"> Mật khẩu mới </label>
                        <div class="col-sm-8">
                            <input ng-model="password.new_pass" type="password" class="form-control input-sm" placeholder="Nhập mật khẩu mới...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"> Xác nhận mật khẩu </label>
                        <div class="col-sm-8">
                            <input ng-model="password.confirm_pass" type="password" class="form-control input-sm" placeholder="Xác nhận mật khẩu...">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button ng-click="changePassword()" type="submit" class="btn btn-info"> Xác nhận </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- ĐĂNG XUẤT --}}
<div id="logout" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title w3-text-red"> @lang('header.logout') </h4>
            </div>
            <div class="modal-body">
                <h5> @lang('header.warn') </h5>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    @lang('header.submit')
                </a>
                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal"> @lang('header.cancel') </button>
            </div>
        </div>
    </div>
</div>