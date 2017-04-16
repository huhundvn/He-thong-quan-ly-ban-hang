/**
 * Created by Good on 3/28/2017.
 */
app.controller('CustomerGroupController', function($scope, $http, API) {

    /**
     * Load danh sách danh sách nhóm khách hàng
     */
    $scope.loadCustomerGroup = function () {
        $http.get(API + 'customerGroup').then(function (response) {
            $scope.customerGroups = response.data;
        });
    };
    $scope.loadCustomerGroup();

    /**
     * CRUD nhóm khách hàng
     */
    $scope.createCustomerGroup = function () {
        $http({
            method : 'POST',
            url : API + 'customerGroup',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomerGroup();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readCustomerGroup = function (customerGroup) {
        $http.get(API + 'customerGroup/' + customerGroup.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateCustomerGroup = function () {
        $http({
            method : 'PUT',
            url : API + 'customerGroup/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomerGroup();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteCustomerGroup = function () {
        $http({
            method : 'DELETE',
            url : API + 'customerGroup/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomerGroup();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createCustomerGroup').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readCustomerGroup').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin nhóm khách hàng');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#description').attr('disabled', true);
    modal.find('#submit').hide();
    modal.find('#updateCustomerGroup').show();
    modal.find('#updateCustomerGroup').click(function () {
        modal.find('.modal-title').text('Sửa thông tin nhóm');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#description').removeAttr('disabled');
        modal.find('#updateCustomerGroup').hide();
        modal.find('#submit').show();
    });
});