/**
 * Created by Good on 4/29/2017.
 */
app.controller('HomeController', function($scope, $http, API, $interval) {
    // SỐ LƯỢNG CÁC ĐƠN HÀNG HÔM NAY
        $http.get(API + 'get-today-order').then(function (response) {
            $scope.today_order = response.data;
        });

        // SỐ LƯỢNG KHÁCH HÀNG
        $http.get(API + 'get-sum-customer').then(function (response) {
            $scope.sum_customer = response.data;
        });

        // SỐ LƯỢNG NHÂN VIÊN
        $http.get(API + 'get-sum-user').then(function (response) {
            $scope.sum_user = response.data;
        });

    $scope.loadRole = function() {

        // QUYỀN NGƯỜI DÙNG
        $http.get(API + 'get-role').then(function (response) {
            $scope.roles = response.data;
        });
    };
    $scope.loadRole();
    $interval($scope.loadRole, 5000);

    // ĐỔI MẬT KHẨU
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

    $scope.labels = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];

    $scope.data = [
        [65, 59, 80, 81, 56, 55, 40],
        [28, 48, 40, 19, 86, 27, 90],
        [28, 48, 40, 19, 86, 27, 90]
    ];
});