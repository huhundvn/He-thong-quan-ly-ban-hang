/**
 * Created by Good on 3/28/2017.
 */
app.controller('AttributeController', function($scope, $http, API) {

    /**
     * Load danh sách thuộc tính
     */
    $scope.loadAttribute = function () {
        $http.get(API + 'attribute').then(function (response) {
            $scope.attributes = response.data;
        });
    };
    $scope.loadAttribute();

    /**
     * CRUD thuộc tính
     */
    $scope.createAttribute = function () {
        $http({
            method : 'POST',
            url : API + 'attribute',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAttribute();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readAttribute = function (attribute) {
        $http.get(API + 'attribute/' + attribute.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.updateAttribute = function () {
        $http({
            method : 'PUT',
            url : API + 'attribute/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAttribute();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteAttribute = function () {
        $http({
            method : 'DELETE',
            url : API + 'attribute/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadAttribute();
            } else
                toastr.error(response.data[0]);
        });
    };

});

$('#createAttribute').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readAttribute').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin đơn vị tính');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#description').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateAttribute').show();
    modal.find('#updateAttribute').click(function () {
        modal.find('.modal-title').text('Sửa thông tin thuộc tính');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#description').removeAttr('readOnly', true);
        modal.find('#updateAttribute').hide();
        modal.find('#submit').show();
    });
});

