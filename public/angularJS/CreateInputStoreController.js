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

    $scope.data = [];
    $scope.total = 0;

    /**
     * Tìm kiếm sản phẩm
     */
    $scope.searchProduct = function(str) {
        var matches = [];
        $scope.products.forEach(function(product) {
            if ((product.name.toLowerCase().indexOf(str.toString().toLowerCase()) >= 0) ||
                (product.code.toLowerCase().indexOf(str.toString().toLowerCase()) >= 0)) {
                matches.push(product);
            }
        });
        return matches;
    };

    $scope.add = function(selected) {
        if (selected == null)
            toastr.warning('Vui lòng chọn 1 sản phẩm');
        else if($scope.data.indexOf(selected) !== -1)
            toastr.warning('Đã thêm');
        else
            $scope.data.push(selected);
    };

    $scope.delete = function(selected) {
        $scope.data.splice($scope.datas.indexOf(selected), 1);
        toastr.success('Đã xóa 1 sản phẩm');
    };

    $scope.createInputStore = function () {
        console.log($scope.datas);
    };


    $scope.options = {
        numeral: {
            numeral: true
        },
    };
});