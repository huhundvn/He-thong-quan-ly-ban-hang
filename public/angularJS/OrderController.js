/**
 * Created by Good on 4/22/2017.
 */
app.controller('OrderController', function($scope, $http, API, $interval) {

    // TẠO KHÁCH HÀNG MỚI
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

    // DANH SÁCH ĐƠN HÀNG
    $scope.loadOrder = function () {
        $http.get(API + 'get-role').then(function (response) {
            $scope.roles = response.data;
        });
        
        $http.get(API + 'customer').then(function (response) {
            $scope.customers = response.data;
        });

        $http.get(API + 'customerGroup').then(function (response) {
            $scope.customerGroups = response.data;
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

        $http.get(API + 'user').then(function (response) {
            $scope.users = response.data;
        });

        $http.get(API + 'product').then(function (response) {
            $scope.products = response.data;
        });

        $http.get(API + 'account').then(function (response) {
            $scope.accounts = response.data;
        });    
        
        $http.get(API + 'order').then(function (response) {
            $scope.orders = response.data;
        });

        $http.get(API + 'get-paid-order').then(function (response) {
            $scope.paidOrders = response.data;
        });
    };
    $scope.loadOrder();
    $interval($scope.loadOrder, 3000);

    // TẠO ĐƠN HÀNG MỚI
    $scope.data = [];
    $scope.new = {};

    // THÊM SẢN PHẨM VÀO DANH SÁCH
    $scope.add = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            for(var i=0; i<selected.detail_price_outputs.length; i++) {
                if(selected.detail_price_outputs[i].price_output_id == $scope.new.price_output_id) {
                    selected.web_price = selected.detail_price_outputs[i].price_output; break;
                }
            }
            $scope.data.push(selected);
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // XÓA SẢN PHẨM KHỎI DANH SÁCH
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
    };

    // TÍNH TỔNG TIỀN
    $scope.getTotal = function () {
        $scope.total = 0;
        for (var i=0; i<$scope.data.length; i++) {
            $scope.total = $scope.total + parseInt($scope.data[i].quantity) * parseInt($scope.data[i].web_price);
        }
        return $scope.total;
    };

    // THÊM CHI TIẾT ĐƠN HÀNG
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

    // TẠO ĐƠN HÀNG MỚI
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
                $scope.new.total = $scope.getTotal() + parseInt($scope.getTotal()*($scope.new.tax/100)) - parseInt($scope.new.discount);
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
                        $scope.new = {};
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };

    // XEM THÔNG TIN ĐƠN HÀNG
    $scope.readOrder = function (order) {
        $http.get(API + 'order/' + order.id).then(function (response) {
            $scope.selected = response.data;
        });
        $http.get(API + 'get-order-detail/' + order.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    // THANH TOÁN ĐƠN HÀNG
    $scope.updateOrder = function () {
        $scope.selected.total_paid += parseInt($scope.selected.more_paid);
        $http({
            method : 'PUT',
            url : API + 'order/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadOrder();
                $scope.loadPaidOrder();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // IN
    $scope.print = function () {
        window.print();
    }

    // DUYỆT ĐƠN HÀNG
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

    // XÓA ĐƠN HÀNG
    $scope.deleteOrder = function () {
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