/**
 * Created by Good on 4/16/2017.
 */
app.controller('InputStoreController', function($scope, $http, API, $interval) {

    $http.get(API + 'user').then(function (response) {
        $scope.users = response.data;
    });

    $http.get(API + 'storage').then(function (response) {
        $scope.stores = response.data;
    });

    $http.get(API + 'supplier').then(function (response) {
        $scope.suppliers = response.data;
    });

    $http.get(API + 'account').then(function (response) {
        $scope.accounts = response.data;
    });

    $http.get(API + 'product').then(function (response) {
        $scope.products = response.data;
    });

    $http.get(API + 'unit').then(function (response) {
        $scope.units = response.data;
    });

    $http.get(API + 'price-input').then(function (response) {
        $scope.priceInputs = response.data;
    });

    //Load danh sách nhập kho
    $scope.loadInputStore = function () {
        $http.get(API + 'input-store').then(function (response) {
            $scope.inputStores = response.data;
        });
    };
    $scope.loadInputStore();
    $interval($scope.loadInputStore, 3000);


    /**
     * CRUD nhập kho
     */

    // Tạo nhập kho mới
    $scope.data = [];
    $scope.info = {};

    // Tạo sản phẩm mới
    $scope.createProduct = function () {
        if( CKEDITOR.instances.newDescription.getData() )
            $scope.newProduct.description = CKEDITOR.instances.newDescription.getData();
        if ( CKEDITOR.instances.newUserGuide.getData() )
            $scope.newProduct.user_guide = CKEDITOR.instances.newUserGuide.getData();
        $http({
            method : 'POST',
            url : API + 'product',
            data : $scope.newProduct,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // Thêm sản phẩm vào danh sách
    $scope.add = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            for(var i=0; i<selected.detail_price_inputs.length; i++) {
                if(selected.detail_price_inputs[i].price_input_id == $scope.info.price_input_id) {
                    selected.price_input = selected.detail_price_inputs[i].price_input; break;
                }
            }
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
        $scope.info.total = 0;
        for (var i=0; i<$scope.data.length; i++) {
            $scope.info.total = $scope.info.total + parseInt($scope.data[i].quantity) * parseInt($scope.data[i].price_input);
        }
        return $scope.info.total;
    };

    // Thêm chi tiết đơn hàng
    $scope.createDetailInputStore = function (item) {
        $http({
            method : 'POST',
            url : API + 'detail-input-store',
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
    $scope.createInputStore = function () {
        if($scope.data.length <= 0)
            toastr.info('Vui lòng thêm sản phẩm');
        else {
            var check = true;
            for (var i=0; i<$scope.data.length; i++) {
                if($scope.data[i].price_input == null || $scope.data[i].expried_date == null) {
                    check = false; break;
                }
            };
            if (!check)
                toastr.info('Vui lòng điền đủ giá nhập hoặc hạn sử dụng');
            else {
                $http({
                    method : 'POST',
                    url : API + 'input-store',
                    data : $scope.info,
                    cache : false,
                    header : {'Content-Type':'application/x-www-form-urlencoded'}
                }).then(function (response) {
                    if(response.data.success) {
                        for (var i=0; i<$scope.data.length; i++) {
                            $scope.data[i].input_store_id = response.data.success;
                            $scope.createDetailInputStore($scope.data[i]);
                        }
                        toastr.success('Đã thêm thành công.');
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };


    // Xem danh sách nhập kho
    $scope.readInputStore = function (inputStore) {
        $http.get(API + 'input-store/' + inputStore.id).then(function (response) {
            $scope.selected = response.data;
        });
        $http.get(API + 'get-detail-input-store/' + inputStore.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    // Thanh toán nhập kho
    $scope.updateInputStore = function () {
        $scope.selected.total_paid += parseInt($scope.selected.more_paid);
        $http({
            method : 'PUT',
            url : API + 'input-store/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadInputStore();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    // In biểu mẫu
    $scope.print = function () {
        window.print();
    }

    // Duyệt yêu cầu nhập hàng
    $scope.changeStatus = function () {
        $http.get(API + 'confirm-input-store/' + $scope.selected.id + '/' + $scope.newStatus).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadInputStore();
            } else
                toastr.error(response.data[0]);
        });
    }

    // Xóa bảng giá
    $scope.deleteInputStore = function () {
        $http({
            method : 'DELETE',
            url : API + 'input-store/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadInputStore();
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
