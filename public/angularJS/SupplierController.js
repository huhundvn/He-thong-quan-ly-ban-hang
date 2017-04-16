/**
 * Created by Good on 3/28/2017.
 */
app.controller('SupplierController', function($scope, $http, API) {

    /**
     * Load danh sách nhà cung cấp
     */
    $scope.loadSupplier = function () {
        $http.get(API + 'supplier').then(function (response) {
            $scope.suppliers = response.data;
        });
    };
    $scope.loadSupplier();

    /**
     * CRUD nhà cung cấp
     */
    $scope.createSupplier = function () {
        $http({
            method : 'POST',
            url : API + 'supplier',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadSupplier();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readSupplier = function (supplier) {
        $http.get(API + 'supplier/' + supplier.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateSupplier = function () {
        $http({
            method : 'PUT',
            url : API + 'supplier/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadSupplier();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteSupplier = function () {
        $http({
            method : 'DELETE',
            url : API + 'supplier/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadSupplier();
            } else
                toastr.error(response.data[0]);
        });
    };
});


$('#createSupplier').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readSupplier').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin nhà cung cấp');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#email').attr('readOnly', true);
    modal.find('#phone').attr('readOnly', true);
    modal.find('#address').attr('readOnly', true);
    modal.find('#person_contact').attr('readOnly', true);
    modal.find('#bank_account').attr('readOnly', true);
    modal.find('#bank').attr('readOnly', true);
    modal.find('#note').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateSupplier').show();
    modal.find('#updateSupplier').click(function () {
        modal.find('.modal-title').text('Sửa thông tin nhà cung cấp');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#email').removeAttr('readOnly', true);
        modal.find('#phone').removeAttr('readOnly', true);
        modal.find('#address').removeAttr('readOnly', true);
        modal.find('#person_contact').removeAttr('readOnly', true);
        modal.find('#bank_account').removeAttr('readOnly');
        modal.find('#bank').removeAttr('readOnly');
        modal.find('#note').removeAttr('readOnly');
        modal.find('#updateSupplier').hide();
        modal.find('#submit').show();
    });
});