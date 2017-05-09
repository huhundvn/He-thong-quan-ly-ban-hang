/**
 * Created by Good on 3/28/2017.
 */
app.controller('StoreController', function($scope, $http, API, $interval) {

    // DANH SÁCH KHO
    $scope.loadStore = function () {
        $http.get(API + 'storage').then(function (response) {
            $scope.storages = response.data;
        });

        $http.get(API + 'store').then(function (response) {
            $scope.stores = response.data;
        });
    };
    $scope.loadStore();
    $interval($scope.loadStore, 3000);

    // TẠO KHO MỚI
    $scope.createStore = function () {
        $http({
            method : 'POST',
            url : API + 'store',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadStore();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // XEM THÔNG TIN KHO
    $scope.readStore = function (store) {
        $http.get(API + 'store/' + store.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    // CHỈNH SỬA THÔNG TIN KHO
    $scope.updateStore = function () {
        $http({
            method : 'PUT',
            url : API + 'store/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadStore();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // XÓA KHO
    $scope.deleteStore = function () {
        $http({
            method : 'DELETE',
            url : API + 'store/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadStore();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createStore').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readStore').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin kho hàng');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#email').attr('readOnly', true);
    modal.find('#phone').attr('readOnly', true);
    modal.find('#address').attr('readOnly', true);
    modal.find('#managed_by').attr('readOnly', true);
    modal.find('#type').attr('disabled', true);
    modal.find('#storage').attr('disabled', true);
    modal.find('#status').attr('disabled', true);
    modal.find('#submit').hide();
    modal.find('#updateStore').show();
    modal.find('#updateStore').click(function () {
        modal.find('.modal-title').text('Sửa thông tin kho hàng');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#email').removeAttr('readOnly', true);
        modal.find('#phone').removeAttr('readOnly', true);
        modal.find('#address').removeAttr('readOnly', true);
        modal.find('#managed_by').removeAttr('readOnly', true);
        modal.find('#storage').removeAttr('disabled');
        modal.find('#status').removeAttr('disabled');
        modal.find('#updateStore').hide();
        modal.find('#submit').show();
    });
});