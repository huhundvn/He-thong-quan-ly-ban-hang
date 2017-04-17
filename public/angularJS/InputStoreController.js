/**
 * Created by Good on 4/16/2017.
 */
app.controller('InputStoreController', function($scope, $http, API) {

    $http.get(API + 'store').then(function (response) {
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

    // Lấy danh sách nhóm sản phẩm
    $http.get(API + 'category').then(function (response) {
        $scope.categorys = response.data;
    });

    // Lấy danh sách nhà cung cấp
    $http.get(API + 'manufacturer').then(function (response) {
        $scope.manufacturers = response.data;
    });

    //Load danh sách nhập kho
    $scope.loadInputStore = function () {
        $http.get(API + 'input-store').then(function (response) {
            $scope.inputStores = response.data;
        });
    };
    $scope.loadInputStore();


    /**
     * CRUD nhập kho
     */

    // Tạo nhập kho mới
    $scope.data = [];
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
            $scope.data.push(selected);
            $("[data-dismiss=modal]").trigger({ type: "click" });
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // Xóa sản phẩm khỏi danh sách
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
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
                if($scope.data[i].price == null || $scope.data[i].expried_date == null) {
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
