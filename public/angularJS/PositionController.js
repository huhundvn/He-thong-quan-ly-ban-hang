/**
 * Created by Good on 4/10/2017.
 */
app.controller('PositionController', function($scope, $http, API) {
    /**
     * Load danh sách danh mục sản phẩm
     */
    $scope.loadPosition = function () {
        $http.get(API + 'position').then(function (response) {
            $scope.positions = response.data;
        });
    };
    $scope.loadPosition();

    /**
     * CRUD chức vụ
     */
    $scope.createPosition = function () {
        $http({
            method : 'POST',
            url : API + 'position',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPosition();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readPosition = function (position) {
        $http.get(API + 'position/' + position.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updatePosition = function () {
        $http({
            method : 'PUT',
            url : API + 'position/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPosition();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deletePosition = function () {
        $http({
            method : 'DELETE',
            url : API + 'position/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPosition();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createPosition').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readPosition').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin chức vụ');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#description').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updatePosition').show();
    modal.find('#updatePosition').click(function () {
        modal.find('.modal-title').text('Sửa thông tin chức vụ');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#description').removeAttr('readOnly', true);
        modal.find('#updatePosition').hide();
        modal.find('#submit').show();
    });
});
