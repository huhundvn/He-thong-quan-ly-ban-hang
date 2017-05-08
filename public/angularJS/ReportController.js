/**
 * Created by Good on 5/3/2017.
 */
app.controller('ReportController', function($scope, $http, API, $interval) {

    $http.get(API + 'top-product').then(function (response) {
        $scope.labels = [];
        $scope.data = [];
        $scope.series = ['Series A', 'Series B'];
        $scope.data.push(0);
        for (var i = 0; i < response.data.length; i++) {
            $http.get(API + 'product/' + response.data[i].product_id).then(function (response02) {
                $scope.labels.push(response02.data.name);
            });
            $scope.data.push(response.data[i].sum);
        }
    });

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

    //Load danh sách nhập kho
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

    //Load danh sách tồn kho
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