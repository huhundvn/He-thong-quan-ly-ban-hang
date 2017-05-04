/**
 * Created by Good on 4/29/2017.
 */
app.controller('HomeController', function($scope, $http, API, $interval) {

    // lấy danh sách các đơn hàng
    $http.get(API + 'order').then(function (response) {
        $scope.orders = response.data;
    });

    // lấy danh sách các chức vụ
    $http.get(API + 'customer').then(function (response) {
        $scope.customers = response.data;
    });

    // lấy danh sách các chức vụ
    $http.get(API + 'user').then(function (response) {
        $scope.users = response.data;
    });

    $scope.loadRole = function() {
        $http.get(API + 'get-role').then(function (response) {
            $scope.roles = response.data;
        });
    };

    $interval($scope.loadRole, 3000);
});