/**
 * Created by Good on 4/29/2017.
 */
app.controller('HomeController', function($scope, $http, API) {

    // lấy danh sách các đơn hàng
    $http.get(API + 'order').then(function (response) {
        $scope.orders = response.data;
    });

    // lấy danh sách các chức vụ
    $http.get(API + 'position').then(function (response) {
        $scope.positions = response.data;
    });

    $scope.getTotalOrderNotConfirmed = function () {
        $scope.count = 0;
        for(var i=0; i < $scope.orders.length; i++) {
            if($scope.orders[i].status == 1)
                $scope.count ++;
        }
        return $scope.count / $scope.orders.length * 100;
    };

    $scope.getTotalOrderShipping = function () {
        $scope.count = 0;
        for(var i=0; i < $scope.orders.length; i++) {
            if($scope.orders[i].status == 2)
                $scope.count ++;
        }
        return $scope.count / $scope.orders.length * 100;
    };

    $scope.getTotalOrderShipped = function () {
        $scope.count = 0;
        for(var i=0; i < $scope.orders.length; i++) {
            if($scope.orders[i].status == 3)
                $scope.count ++;
        }
        return $scope.count / $scope.orders.length * 100;
    };

});