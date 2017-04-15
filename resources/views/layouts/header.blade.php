<div class="w3-bar w3-small w3-blue-grey">
    <button class="w3-bar-item w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open()">
        <span class="glyphicon glyphicon-align-justify"></span>
    </button>
    <a class="w3-button w3-hover-none w3-hover-text-light-grey"> Larose </a>

    {{-- Nếu là nhân viên hiện chức năng --}}
    @if(!Auth::guest())
    <div class="w3-dropdown-hover w3-right">
        <button class="w3-button"> {{Auth::user()->name}} <span class="caret"></span> </button>
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="#" class="w3-bar-item w3-button" data-toggle="modal" data-target="#changePass"> Đổi mật khẩu </a>
            <a href="#" class="w3-bar-item w3-button" data-toggle="modal" data-target="#logout"> @lang('header.logout') </a>
        </div>
    </div>
    @endif
    <div class="w3-dropdown-hover w3-right">
        <button class="w3-button"> @lang('header.lang') <span class="caret"></span> </button>
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="{{url('/lang/en')}}" class="w3-bar-item w3-button"> @lang('header.en') </a>
            <a href="{{url('/lang/vn')}}" class="w3-bar-item w3-button"> @lang('header.vn') </a>
        </div>
    </div>
</div>

<!-- !ĐỔI MẬT KHẨU!-->
<div id="changePass" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title w3-text-blue"> Đổi mật khẩu </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4"> Mật khẩu cũ </label>
                        <div class="col-sm-8">
                            <input ng-model="password.old" type="password" class="form-control input-sm" placeholder="Nhập mật khẩu cũ...">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="col-sm-4"> Mật khẩu mới </label>
                        <div class="col-sm-8">
                            <input ng-model="password.new" type="password" class="form-control input-sm" placeholder="Nhập mật khẩu mới...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"> Xác nhận mật khẩu </label>
                        <div class="col-sm-8">
                            <input ng-model="password.confirm" type="password" class="form-control input-sm" placeholder="Xác nhận mật khẩu...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info"> Xác nhận </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"> @lang('header.cancel') </button>
            </div>
        </div>
    </div>
</div>

<!-- ĐĂNG XUẤT -->
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