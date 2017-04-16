/**
 * Created by Good on 3/28/2017.
 */
app.controller('CustomerController', function($scope, $http, API) {

    /**
     * Load danh sách danh mục sản phẩm
     */
    $scope.loadCustomer = function () {
        $http.get(API + 'customer').then(function (response) {
            $scope.customers = response.data;
        });
    };
    $scope.loadCustomer();

    /**
     * Lấy danh sách nhóm khách hàng
     */
    $http.get(API + 'customerGroup').then(function (response) {
        $scope.customerGroups = response.data;
    });

    /**
     * CRUD khách hàng
     */
    $scope.createCustomer = function () {
        $http({
            method : 'POST',
            url : API + 'customer',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomer();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readCustomer = function (customer) {
        $http.get(API + 'customer/' + customer.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateCustomer = function () {
        $http({
            method : 'PUT',
            url : API + 'customer/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomer();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteCustomer = function () {
        $http({
            method : 'DELETE',
            url : API + 'customer/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomer();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createCustomer').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readCustomer').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin khách hàng');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#email').attr('readOnly', true);
    modal.find('#phone').attr('readOnly', true);
    modal.find('#address').attr('readOnly', true);
    modal.find('#bank_account').attr('readOnly', true);
    modal.find('#bank').attr('readOnly', true);
    modal.find('#customer_group').attr('disabled', true);
    modal.find('#note').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateCustomer').show();
    modal.find('#updateCustomer').click(function () {
        modal.find('.modal-title').text('Sửa thông tin khách hàng');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#email').removeAttr('readOnly');
        modal.find('#phone').removeAttr('readOnly');
        modal.find('#address').removeAttr('readOnly');
        modal.find('#bank_account').removeAttr('readOnly');
        modal.find('#bank').removeAttr('readOnly');
        modal.find('#customer_group').removeAttr('disabled');
        modal.find('#note').removeAttr('readOnly');
        modal.find('#updateCustomer').hide();
        modal.find('#submit').show();
    });
});