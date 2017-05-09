/**
 * Created by Good on 4/16/2017.
 */
app.controller('PriceOutputController', function($scope, $http, API, $interval) {

    //Load danh sách bảng giá
    $scope.loadPriceOutput = function () {
        // Lấy danh sách sản phẩm
        $http.get(API + 'product').then(function (response) {
            $scope.products = response.data;
        });

        // Lấy danh sách đơn vị tính
        $http.get(API + 'unit').then(function (response) {
            $scope.units = response.data;
        });

        // Lấy danh sách nhóm khách hàng
        $http.get(API + 'customerGroup').then(function (response) {
            $scope.customerGroups = response.data;
        });

        $http.get(API + 'price-output').then(function (response) {
            $scope.priceOutputs = response.data;
        });
    };
    $scope.loadPriceOutput();
    $interval($scope.loadPriceOutput, 3000);

    // Tạo bảng giá mới
    $scope.data = [];

    // THÊM SẢN PHẨM VÀO BẢNG GIÁ
    $scope.add = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            $scope.data.push(selected);
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // XÓA SẢN PHẨM KHỎI BẢNG GIÁ
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
    };

    // THÊM CHI TIẾT BẢNG GIÁ
    $scope.createDetailPriceOutput = function (item) {
        $http({
            method : 'POST',
            url : API + 'detail-price-output',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                console.log('1');
            }
        });
    };

    // TẠO BẢNG GIÁ MỚI
    $scope.createPriceOutput = function () {
        if($scope.data.length <= 0)
            toastr.info('Vui lòng thêm sản phẩm');
        else {
            var check = true;
            for (var i=0; i<$scope.data.length; i++) {
                if($scope.data[i].price_output == null) {
                    check = false; break;
                }
            };
            if (!check)
                toastr.info('Vui lòng điền giá sản phẩm');
            else {
                $http({
                    method : 'POST',
                    url : API + 'price-output',
                    data : $scope.info,
                    cache : false,
                    header : {'Content-Type':'application/x-www-form-urlencoded'}
                }).then(function (response) {
                    if(response.data.success) {
                        for (var i=0; i<$scope.data.length; i++) {
                            $scope.data[i].price_output_id = response.data.success;
                            $scope.createDetailPriceOutput($scope.data[i]);
                        }
                        toastr.success('Đã thêm thành công.');
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };

    // XEM BẢNG GIÁ
    $scope.readPriceOutput = function (priceOutput) {
        $http.get(API + 'price-output/' + priceOutput.id).then(function (response) {
            $scope.selected = response.data;
        });
        $http.get(API + 'get-detail-price-output/' + priceOutput.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    // DUYỆT BẢNG GIÁ
    $scope.changeStatus = function () {
        console.log($scope.newStatus, $scope.selected.id);
        $http.get(API + 'confirm-price-output/' + $scope.selected.id + '/' + $scope.newStatus).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPriceOutput();
            } else
                toastr.error(response.data[0]);
        });
    }

    // XÓA BẢNG GIÁ
    $scope.deletePriceOutput = function () {
        $http({
            method : 'DELETE',
            url : API + 'price-output/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPriceOutput();
            } else
                toastr.error(response.data[0]);
        });
    };

    // IN
    $scope.print = function () {
        window.print();
    }

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
