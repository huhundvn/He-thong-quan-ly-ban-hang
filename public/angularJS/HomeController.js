/**
 * Created by Good on 4/29/2017.
 */
app.controller('HomeController', function($scope, $http, API, $interval) {

    // lấy danh sách các đơn hàng
    $http.get(API + 'get-today-order').then(function (response) {
        $scope.today_order = response.data;
    });

    // lấy danh sách khách hàng
    $http.get(API + 'get-sum-customer').then(function (response) {
        $scope.sum_customer = response.data;
    });

    // lấy danh sách các nhân viên
    $http.get(API + 'get-sum-user').then(function (response) {
        $scope.sum_user = response.data;
    });

    $scope.loadRole = function() {
        $http.get(API + 'get-role').then(function (response) {
            $scope.roles = response.data;
        });
    };
    $interval($scope.loadRole, 3000);

    $scope.changePassword = function () {
        $http({
            method : 'POST',
            url : API + 'changePassword',
            data : $scope.password,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadCustomer();
            }
            else
                toastr.error(response.data[0]);
        });
    };
});