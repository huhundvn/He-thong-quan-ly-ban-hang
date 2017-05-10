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

    // LẤY DANH SÁCH 10 SẢN PHẨM BÁN CHẠY
    $http.get(API + 'top-product').then(function (response) {
        $scope.labels = [];
        $scope.data = [];
        $scope.series = ['Thu', 'Chi'];
        for (var i = 0; i < response.data.length; i++) {
            $http.get(API + 'product/' + response.data[i].product_id).then(function (response02) {
                $scope.labels.push(response02.data.name);
            });
            $scope.data.push(response.data[i].sum);
        }
        $scope.data.push(0);
    });

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