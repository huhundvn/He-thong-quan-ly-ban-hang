/**
 * Created by Good on 4/29/2017.
 */
app.controller('HomeController', function($scope, $http, API, $interval) {

    $scope.today_voucher = 0;
    $scope.today_order = 0;
    $scope.sum_customer = 0;
    $scope.sum_user = 0;
     
    // SỐ LƯỢNG CÁC ĐƠN HÀNG HÔM NAY
        $http.get(API + 'get-today-voucher').then(function (response) {
            $scope.today_voucher = response.data;
        });

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
    $scope.series = ['Tổng tiền thu', 'Tổng tiền chi'];
    $scope.data = [
        [650000, 590000, 800000, 810000, 860000, 550000, 400000],
        [280000, 480000, 400000, 190000, 560000, 270000, 900000],
        // [37, 11, 40, 62, 30, 28, -50]
    ];
    // $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
    // $scope.options = {
    //     scales: {
    //     yAxes: [
    //         {
    //             id: 'y-axis-1',
    //             type: 'linear',
    //             display: true,
    //             position: 'left'
    //         },
    //         {
    //             id: 'y-axis-2',
    //             type: 'linear',
    //             display: true,
    //             position: 'right'
    //         }
    //     ]
    //     }
    // };
});