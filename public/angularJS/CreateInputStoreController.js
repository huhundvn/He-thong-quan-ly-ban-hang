/**
 * Created by Good on 4/15/2017.
 */
app.controller('CreateInputStoreController', function($scope, $http, API) {

    /**
     * Lấy danh sách kho
     */
    $http.get(API + 'storage').then(function (response) {
        $scope.stores = response.data;
    });

    /**
     * Lấy danh sách nhà cung cấp
     */
    $http.get(API + 'supplier').then(function (response) {
        $scope.suppliers = response.data;
    });

    /**
     * Lấy danh sách tài khoản thanh toán
     */
    $http.get(API + 'account').then(function (response) {
        $scope.accounts = response.data;
    });

    /**
     * Lấy danh sách sản phẩm
     */
    $http.get(API + 'product').then(function (response) {
        $scope.products = response.data;
    });

    /**
     * Lấy danh sách đơn vị tính
     */
    $http.get(API + 'unit').then(function (response) {
        $scope.units = response.data;
    });

    // Lấy danh sách nhóm sản phẩm
    $http.get(API + 'category').then(function (response) {
        $scope.categorys = response.data;
    });

    // Lấy danh sách nhà cung cấp
    $http.get(API + 'manufacturer').then(function (response) {
        $scope.manufacturers = response.data;
    });

    $scope.data = [];

    // Tạo sản phẩm mới
    $scope.createProduct = function () {
        if( CKEDITOR.instances.newDescription.getData() )
            $scope.newProduct.description = CKEDITOR.instances.newDescription.getData();
        if ( CKEDITOR.instances.newUserGuide.getData() )
            $scope.newProduct.user_guide = CKEDITOR.instances.newUserGuide.getData();
        $http({
            method : 'POST',
            url : API + 'product',
            data : $scope.newProduct,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // Thêm sản phẩm vào danh sách
    $scope.add = function(selected) {
        $scope.data.push(selected);
        $("[data-dismiss=modal]").trigger({ type: "click" });
        toastr.info('Đã thêm một sản phẩm vào danh sách.');
    };

    // Xóa sản phẩm khỏi danh sách
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
    };

    // Thêm mới chi tiết đơn hàng
    $scope.createDetailInputStore = function (item) {
        $http({
            method : 'POST',
            url : API + 'detail-input-store',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {

            }
            else
                toastr.error(response.data[0]);
        });
    };

    // Tạo mới đơn đặt hàng
    $scope.createInputStore = function () {
        console.log($scope.info);
        $http({
            method : 'POST',
            url : API + 'input-store',
            data : $scope.info,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.getTotal = function () {
        var total = 0;
        for(var item in $scope.data)
            total += item.quantity * item.price;
        return total;
    };

    $scope.total = $scope.getTotal();

    $scope.options = {
        numeral: {
            numeral: true
        },
        code: {
            blocks: [1, 3, 3, 3, 3],
            delimiters: ['-']
        }
    };
});