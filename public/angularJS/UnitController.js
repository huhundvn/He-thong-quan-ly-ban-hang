/**
 * Created by Good on 3/28/2017.
 */
app.controller('UnitController', function($scope, $http, API) {

    /**
     * Load danh sách danh mục sản phẩm
     */
    $scope.loadUnit = function () {
        $http.get(API + 'unit').then(function (response) {
            $scope.units = response.data;
        });
    };
    $scope.loadUnit();

    /**
     * CRUD đơn vị tính
     */
    $scope.createUnit = function () {
        $http({
            method : 'POST',
            url : API + 'unit',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUnit();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readUnit = function (unit) {
        $http.get(API + 'unit/' + unit.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateUnit = function () {
        $http({
            method : 'PUT',
            url : API + 'unit/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUnit();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteUnit = function () {
        $http({
            method : 'DELETE',
            url : API + 'unit/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadUnit();
            } else
                toastr.error(response.data[0]);
        });
    };

});

$('#createUnit').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readUnit').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin đơn vị tính');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#description').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateUnit').show();
    modal.find('#updateUnit').click(function () {
        modal.find('.modal-title').text('Sửa thông tin đơn vị tính');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#description').removeAttr('readOnly', true);
        modal.find('#updateUnit').hide();
        modal.find('#submit').show();
    });
});
