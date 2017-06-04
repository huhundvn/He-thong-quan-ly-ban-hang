/**
 * Created by Good on 5/3/2017.
 */
app.controller('ReportController', function($scope, $http, API, $interval) {

    $http.get(API + 'storage').then(function (response) {
        $scope.stores = response.data;
    });

    $http.get(API + 'supplier').then(function (response) {
        $scope.suppliers = response.data;
    });

    $http.get(API + 'unit').then(function (response) {
        $scope.units = response.data;
    });

    $http.get(API + 'product').then(function (response) {
        $scope.products = response.data;
    });

    $http.get(API + 'category').then(function (response) {
        $scope.categorys = response.data;
    }); // Load nhóm sản phẩm

    $http.get(API + 'manufacturer').then(function (response) {
        $scope.manufacturers = response.data;
    }); // Load nhà sản xuất

    $http.get(API + 'attribute').then(function (response) {
        $scope.attributes = response.data;
    }); // Load thuộc tính sản phẩm

    // LẤY DANH SÁCH 10 SẢN PHẨM BÁN CHẠY
    $http.get(API + 'top-product').then(function (response) {
        $scope.labels = [];
        $scope.data = [];
        $scope.series = ['Thu', 'Chi'];
        $scope.topProducts = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $http.get(API + 'product/' + response.data[i].product_id).then(function (response02) {
                $scope.labels.push(response02.data.name);
            });
            $scope.data.push(response.data[i].sum);
        }
        $scope.data.push(0);
    });

    // XEM THÔNG TIN SẢN PHẨM
    $scope.readProduct = function (product) {
        $http.get(API + 'product/' + product.product_id).then(function (response) {
            $scope.selected = response.data;
            CKEDITOR.instances.description.setData($scope.selected.description);
            CKEDITOR.instances.user_guide.setData($scope.selected.user_guide);
        });
    };

    // LẤY DANH SÁCH 10 nhân viên BÁN CHẠY
    $http.get(API + 'top-user').then(function (response) {
        $scope.labels03 = [];
        $scope.data03 = [];
        $scope.series03 = ['Tổng tiền hóa đơn'];
        for (var i = 0; i < response.data.length; i++) {
            $http.get(API + 'user/' + response.data[i].created_by).then(function (response02) {
                $scope.labels03.push(response02.data.name);
            });
            $scope.data03.push(response.data[i].sum);
        }
        $scope.data03.push(0);
    });

    $scope.labels02 = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];

    $scope.data02 = [
        [65, 59, 80, 81, 56, 55, 40],
        [28, 48, 40, 19, 86, 27, 90]
    ];

    // LẤY DANH SÁCH XUẤT KHO
    $scope.loadStoreOutput = function () {
        $http({
            method : 'POST',
            url : API + 'report-revenue',
            data : $scope.info,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                $scope.storeOutputs = response.data.success;
            } else
                toastr.error(response.data[0]);
        });
    };

    // LẤY DANH SÁCH NHẬP KHO
    $scope.loadInputStore = function () {
        $http({
            method : 'POST',
            url : API + 'report-input-store',
            data : $scope.info,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                $scope.inputStores = response.data.success;
            } else
                toastr.error(response.data[0]);
        });
    };

    //LẤY DANH SÁCH TỒN KHO
    $scope.loadProductInStore = function () {
        $http({
            method : 'POST',
            url : API + 'report-product-in-store',
            data : $scope.info,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                $scope.productInStores = response.data.success;
            } else
                toastr.error(response.data[0]);
        });
    };

    // In biểu mẫu
    $scope.print = function () {
        window.print();
    }
});

$("#viewList").click(function () {
    $("#viewList").addClass('w3-blue-grey');
    $("#viewGrid").removeClass('w3-blue-grey');
    $("#grid").attr('hidden', true);
    $("#list").removeAttr('hidden');
});

$("#viewGrid").click(function () {
    $("#viewList").removeClass('w3-blue-grey');
    $("#viewGrid").addClass('w3-blue-grey');
    $("#list").attr('hidden', true);
    $("#grid").removeAttr('hidden');
});

$('#readProduct').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin sản phẩm');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#code').attr('readOnly', true);
    CKEDITOR.instances.description.setReadOnly(true);
    CKEDITOR.instances.user_guide.setReadOnly(true);
    var myDropzone = Dropzone.forElement(".dropzone");
    myDropzone.removeAllFiles();
    modal.find('#category').attr('disabled', true);
    modal.find('#manufacturer').attr('disabled', true);
    modal.find('#unit').attr('disabled', true);
    modal.find('#web_price').attr('readOnly', true);
    modal.find('#min_inventory').attr('readOnly', true);
    modal.find('#max_inventory').attr('readOnly', true);
    modal.find('#warranty_period').attr('readOnly', true);
    modal.find('#return_period').attr('readOnly', true);
    modal.find('#weight').attr('readOnly', true);
    modal.find('#size').attr('readOnly', true);
    modal.find('#volume').attr('readOnly', true);
    modal.find('#addAttribute').attr('disabled', true);
    modal.find('#addImage').attr('disabled', true);
    modal.find('#submit').hide();
    modal.find('#updateProduct').show();
    modal.find('#updateProduct').click(function () {
        modal.find('.modal-title').text('Sửa thông tin sản phẩm');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#code').removeAttr('readOnly');
        CKEDITOR.instances.description.setReadOnly(false);
        CKEDITOR.instances.user_guide.setReadOnly(false);
        modal.find('#user_guide').removeAttr('disabled');
        modal.find('#category').removeAttr('disabled');
        modal.find('#manufacturer').removeAttr('disabled');
        modal.find('#unit').removeAttr('disabled');
        modal.find('#web_price').removeAttr('readOnly');
        modal.find('#min_inventory').removeAttr('readOnly');
        modal.find('#max_inventory').removeAttr('readOnly');
        modal.find('#warranty_period').removeAttr('readOnly');
        modal.find('#return_period').removeAttr('readOnly');
        modal.find('#weight').removeAttr('readOnly');
        modal.find('#size').removeAttr('readOnly', true);
        modal.find('#volume').removeAttr('readOnly', true);
        modal.find('#addAttribute').removeAttr('disabled');
        modal.find('#addImage').removeAttr('disabled');
        modal.find('#updateProduct').hide();
        modal.find('#submit').show();
    });
});