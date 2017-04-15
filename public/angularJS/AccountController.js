/**
 * Created by Good on 4/12/2017.
 */
app.controller('AccountController', function($scope, $http, API) {
    /**
     * Load danh sách danh mục sản phẩm
     */
    $scope.loadAccount = function () {
        $http.get(API + 'account').then(function (response) {
            $scope.accounts = response.data;
        });
    };
    $scope.loadAccount();

    /**
     * Tìm thông tin tài khoản
     */
    $scope.searchAccount = function () {
        if ($scope.term == '') {
            $scope.loadAccount();
        } else {
            $http.get(API + 'account/search/' + $scope.term).then(function (response) {
                $scope.accounts = response.data;
            });
        }
    };

    /**
     * CRUD tài khoản
     */
    $scope.createAccount = function () {
        $http({
            method : 'POST',
            url : API + 'account',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAccount();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readAccount = function (account) {
        $http.get(API + 'account/' + account.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateAccount = function () {
        $http({
            method : 'PUT',
            url : API + 'account/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAccount();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteAccount = function () {
        $http({
            method : 'DELETE',
            url : API + 'account/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAccount();
            } else
                toastr.error(response.data[0]);
        });
    };

    $scope.options = {
        numeral: {
            numeral: true
        }
    };
});

$('#createAccount').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readAccount').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin tài khoản');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#bank_account').attr('readOnly', true);
    modal.find('#bank').attr('readOnly', true);
    modal.find('#total').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateAccount').show();
    modal.find('#updateAccount').click(function () {
        modal.find('.modal-title').text('Sửa thông tin tài khoản');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#bank_account').removeAttr('readOnly');
        modal.find('#bank').removeAttr('readOnly');
        modal.find('#total').removeAttr('readOnly');
        modal.find('#updateAccount').hide();
        modal.find('#submit').show();
    });
});