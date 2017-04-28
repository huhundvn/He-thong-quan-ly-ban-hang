/**
 * Created by Good on 4/22/2017.
 */
app.controller('OrderController', function($scope, $http, API) {

    $http.get(API + 'customer').then(function (response) {
        $scope.customers = response.data;
    });

    $http.get(API + 'customerGroup').then(function (response) {
        $scope.customerGroups = response.data;
    });

    $http.get(API + 'user').then(function (response) {
        $scope.users = response.data;
    });

    $http.get(API + 'price-output').then(function (response) {
        $scope.priceOutputs = response.data;
    });

    $http.get(API + 'storage').then(function (response) {
        $scope.stores = response.data;
    });

    $http.get(API + 'supplier').then(function (response) {
        $scope.suppliers = response.data;
    });

    $http.get(API + 'product').then(function (response) {
        $scope.products = response.data;
    });

    $http.get(API + 'unit').then(function (response) {
        $scope.units = response.data;
    });

    // Tạo khách hàng mới
    $scope.createCustomer = function () {
        $http({
            method : 'POST',
            url : API + 'customer',
            data : $scope.newCustomer,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $http.get(API + 'customer').then(function (response) {
                    $scope.customers = response.data;
                });
            }
            else
                toastr.error(response.data[0]);
        });
    };

    //Load danh sách đơn hàng
    $scope.loadOrder = function () {
        $http.get(API + 'order').then(function (response) {
            $scope.orders = response.data;
        });
    };
    $scope.loadOrder();


    /**
     * CRUD đơn hàng
     */
    // Tạo đơn hàng mới
    $scope.data = [];
    $scope.new = {};

    // Thêm sản phẩm vào danh sách
    $scope.add = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            $scope.data.push(selected);
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // Xóa sản phẩm khỏi danh sách
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
    };

    // Tính tổng tiền
    $scope.getTotal = function () {
        $scope.total = 0;
        for (var i=0; i<$scope.data.length; i++) {
            $scope.total = $scope.total + parseInt($scope.data[i].quantity) * parseInt($scope.data[i].web_price);
        }
        return $scope.total;
    };

    // Thêm chi tiết đơn hàng
    $scope.createOrderDetail = function (item) {
        $http({
            method : 'POST',
            url : API + 'order-detail',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                console.log('1');
            }
        });
    };

    // Tạo mới đơn đặt hàng
    $scope.createOrder = function () {
        if($scope.data.length <= 0)
            toastr.info('Vui lòng thêm sản phẩm');
        else {
            var check = true;
            for (var i=0; i<$scope.data.length; i++) {
                if($scope.data[i].quantity == null) {
                    check = false; break;
                }
            };
            if (!check)
                toastr.info('Vui lòng điền số lượng cần mua');
            else {
                $scope.new.customer_id = $scope.selectedCustomer.originalObject.id;
                $scope.new.total = $scope.getTotal() + parseInt($scope.getTotal() * 0.1);
                console.log($scope.new);
                $http({
                    method : 'POST',
                    url : API + 'order',
                    data : $scope.new,
                    cache : false,
                    header : {'Content-Type':'application/x-www-form-urlencoded'}
                }).then(function (response) {
                    if(response.data.success) {
                        for (var i=0; i<$scope.data.length; i++) {
                            $scope.data[i].order_id = response.data.success;
                            console.log($scope.data[i]);
                            $scope.createOrderDetail($scope.data[i]);
                        }
                        toastr.success('Đã thêm đơn hàng thành công.');
                        $scope.data = [];
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };

    // Xem danh sách đơn hàng
    $scope.readOrder = function (order) {
        $http.get(API + 'order/' + order.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    // In biểu mẫu
    $scope.print = function () {
        window.print();
    }

    // Duyệt yêu cầu nhập hàng
    $scope.changeStatus = function () {
        $http.get(API + 'confirm-order/' + $scope.selected.id + '/' + $scope.newStatus).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadOrder();
            } else
                toastr.error(response.data[0]);
        });
    }

    // Xóa bảng giá
    $scope.deleteOrder = function () {
        console.log($scope.selected);
        $http({
            method : 'DELETE',
            url : API + 'order/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadOrder();
            } else
                toastr.error(response.data[0]);
        });
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

$('#createCustomer').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});