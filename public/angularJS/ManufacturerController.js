/**
 * Created by Good on 3/28/2017.
 */
app.controller('ManufacturerController', function($scope, $http, API) {
    /**
     * Load danh sách nhà sản xuất
     */
    $scope.loadManufacturer = function () {
        $http.get(API + 'manufacturer').then(function (response) {
            $scope.manufacturers = response.data;
        });
    };
    $scope.loadManufacturer();

    /**
     * CRUD nhà sản xuất
     */
    $scope.createManufacturer = function () {
        $http({
            method : 'POST',
            url : API + 'manufacturer',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadManufacturer();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readManufacturer = function (manufacturer) {
        $http.get(API + 'manufacturer/' + manufacturer.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateManufacturer = function () {
        $http({
            method : 'PUT',
            url : API + 'manufacturer/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadManufacturer();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteManufacturer = function () {
        $http({
            method : 'DELETE',
            url : API + 'manufacturer/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadManufacturer();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createManufacturer').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readManufacturer').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin nhà sản xuất');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#country').attr('readOnly', true);
    modal.find('#description').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateManufacturer').show();
    modal.find('#updateManufacturer').click(function () {
        modal.find('.modal-title').text('Sửa thông tin nhà sản xuất');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#country').removeAttr('readOnly', true);
        modal.find('#description').removeAttr('readOnly', true);
        modal.find('#updateManufacturer').hide();
        modal.find('#submit').show();
    });
});
