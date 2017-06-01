/**
 * Created by Good on 3/28/2017.
 */
app.controller('CategoryController', function($scope, $http, API, $interval) {

    // DANH SÁCH NHÓM SẢN PHẨM
    $scope.loadCategory = function () {
        $http.get(API + 'category').then(function (response) {
            $scope.categorys = response.data;
        });
    };
    $scope.loadCategory();
    // $interval($scope.loadCategory, 5000);

    // TẠO NHÓM SẢN PHẨM 
    $scope.createCategory = function () {
        $http({
            method : 'POST',
            url : API + 'category',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCategory();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // XEM NHÓM SẢN PHẨM
    $scope.readCategory = function (category) {
        $http.get(API + 'category/' + category.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    // CHỈNH SỬA NHÓM SẢN PHẨM
    $scope.updateCategory = function () {
        $http({
            method : 'PUT',
            url : API + 'category/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCategory();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // XÓA NHÓM SẢN PHẨM
    $scope.deleteCategory = function () {
        $http({
            method : 'DELETE',
            url : API + 'category/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCategory();
            } else
                toastr.error(response.data[0]);
        });
    };

});


$('#createCategory').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

$('#readCategory').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin đơn vị tính');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#parent').attr('disabled', true);
    modal.find('#description').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateCategory').show();
    modal.find('#updateCategory').click(function () {
        modal.find('.modal-title').text('Sửa thông tin đơn vị tính');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#parent').removeAttr('disabled');
        modal.find('#description').removeAttr('readOnly', true);
        modal.find('#updateCategory').hide();
        modal.find('#submit').show();
    });
});