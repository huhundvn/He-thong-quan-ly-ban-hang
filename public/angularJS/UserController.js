/**
 * Created by Good on 3/28/2017.
 */
app.controller('UserController', function($scope, $http, API, $interval) {

    /**
     * Load danh sách nhân viên
     */
    $scope.loadUser = function () {
        $http.get(API + 'store').then(function (response) {
            $scope.stores = response.data;
        });

        $http.get(API + 'position').then(function (response) {
            $scope.positions = response.data;
        });

        $http.get(API + 'user').then(function (response) {
            $scope.users = response.data;
        });
    };
    $scope.loadUser();
    // $interval($scope.loadUser, 5000);

    /**
     * CRUD nhân viên
     */
    $scope.createUser = function () {
        $http({
            method : 'POST',
            url : API + 'user',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUser();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readUser = function (user) {
        $http.get(API + 'user/' + user.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateUser = function () {
        $http({
            method : 'PUT',
            url : API + 'user/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUser();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteUser = function () {
        $http({
            method : 'DELETE',
            url : API + 'user/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUser();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createUser').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readUser').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin nhân viên');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#nameUser').attr('readOnly', true);
    modal.find('#emailUser').attr('readOnly', true);
    modal.find('#phoneUser').attr('readOnly', true);
    modal.find('#addressUser').attr('readOnly', true);
    modal.find('#workplace').attr('disabled', true);
    modal.find('#position').attr('disabled', true);
    modal.find('#status').attr('disabled', true);
    modal.find('#submit').hide();
    modal.find('#updateUser').show();
    modal.find('#updateUser').click(function () {
        modal.find('.modal-title').text('Sửa thông tin nhân viên');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#nameUser').removeAttr('readOnly');
        modal.find('#emailUser').removeAttr('readOnly');
        modal.find('#phoneUser').removeAttr('readOnly');
        modal.find('#addressUser').removeAttr('readOnly');
        modal.find('#workplace').removeAttr('disabled');
        modal.find('#position').removeAttr('disabled');
        modal.find('#status').removeAttr('disabled');
        modal.find('#updateUser').hide();
        modal.find('#submit').show();
    });
});