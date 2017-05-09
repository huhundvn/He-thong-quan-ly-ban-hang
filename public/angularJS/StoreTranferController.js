/**
 * Created by Good on 4/16/2017.
 */
app.controller('StoreTranferController', function($scope, $http, API, $interval) {

    //Load danh sách nhập kho
    $scope.loadStoreTranfer = function () {
        $http.get(API + 'storage').then(function (response) {
            $scope.stores = response.data;
        });

        $http.get(API + 'product').then(function (response) {
            $scope.products = response.data;
        });

        $http.get(API + 'unit').then(function (response) {
            $scope.units = response.data;
        });

        $http.get(API + 'product-in-store').then(function (response) {
            $scope.productInStores = response.data;
        });

        $http.get(API + 'store-tranfer').then(function (response) {
            $scope.storeTranfers = response.data;
        });
    };
    $scope.loadStoreTranfer();
    $interval($scope.loadStoreTranfer, 5000);

    $scope.data = [];

    // THÊM SẢN PHẨM VÀO DANH SÁCH
    $scope.add = function(selected) {
        if(($scope.data.indexOf(selected) == -1)) {
            $scope.data.push(selected);
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // XÓA SẢN PHẨM KHỎI DANH SÁCH
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa một sản phẩm khỏi danh sách.');
    };

    // THÊM CHI TIẾT CHUYỂN KHO
    $scope.createDetailStoreTranfer = function (item) {
        $http({
            method : 'POST',
            url : API + 'detail-store-tranfer',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                console.log('1');
            }
        });
    };

    // TẠO CHUYỂN KHO MỚI
    $scope.createStoreTranfer = function () {
        if($scope.data.length <= 0)
            toastr.info('Vui lòng thêm sản phẩm');
        else {
            var check = true;
            for (var i=0; i<$scope.data.length; i++) {
                if($scope.data[i].quantity_tranfer == null || ($scope.data[i].quantity_tranfer > $scope.data[i].quantity)) {
                    check = false; break;
                }
            };
            if (!check)
                toastr.info('Vui lòng điền số lượng chuyển, số lượng phải nhỏ hơn hoặc bằng trong kho chuyển');
            else {
                $http({
                    method : 'POST',
                    url : API + 'store-tranfer',
                    data : $scope.info,
                    cache : false,
                    header : {'Content-Type':'application/x-www-form-urlencoded'}
                }).then(function (response) {
                    if(response.data.success) {
                        for (var i=0; i<$scope.data.length; i++) {
                            $scope.data[i].store_tranfer_id = response.data.success;
                            $scope.createDetailStoreTranfer($scope.data[i]);
                        }
                        toastr.success('Đã thêm yêu cầu thành công.');
                        $scope.data = [];
                        $scope.info = {};
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };

    // XEM CHUYỂN KHO
    $scope.readStoreTranfer = function (storeTranfer) {
        $http.get(API + 'store-tranfer/' + storeTranfer.id).then(function (response) {
            $scope.selected = response.data;
        });
        $http.get(API + 'get-detail-store-tranfer/' + storeTranfer.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    // IN
    $scope.print = function () {
        window.print();
    }

    // DUYỆT YÊU CẦU CHUYỂN KHO
    $scope.changeStatus = function () {
        $http.get(API + 'confirm-store-tranfer/' + $scope.selected.id + '/' + $scope.newStatus).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadStoreTranfer();
            } else
                toastr.error(response.data[0]);
        });
    }

    // XÓA YÊU CẦU CHUYỂN KHO
    $scope.deleteStoreTranfer = function () {
        $http({
            method : 'DELETE',
            url : API + 'store-tranfer/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadStoreTranfer();
            } else
                toastr.error(response.data[0]);
        });
    };

    // KIỂM TRA SỐ LƯỢNG CHUYỂN
    $scope.checkQuantity = function (quantity_tranfer, quantity_remain) {
        if(quantity_tranfer > quantity_remain) {
            toastr.info('Không được chuyển quá số lượng sản phẩm đang có trong kho.');
        }
    };

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

