/**
 * Created by Good on 4/16/2017.
 */
app.controller('PriceInputController', function($scope, $http, API, $interval) {

    //DANH SÁCH BẢNG GIÁ
    $scope.loadPriceInput = function () {
        $http.get(API + 'get-role').then(function (response) {
            $scope.roles = response.data;
        });
        
        // Lấy danh sách sản phẩm
        $http.get(API + 'product').then(function (response) {
            $scope.products = response.data;
        });

        // Lấy danh sách đơn vị tính
        $http.get(API + 'unit').then(function (response) {
            $scope.units = response.data;
        });

        // Lấy danh sách nhà cung cấp
        $http.get(API + 'supplier').then(function (response) {
            $scope.suppliers = response.data;
        });

        $http.get(API + 'price-input').then(function (response) {
            $scope.priceInputs = response.data;
        });
    };
    $scope.loadPriceInput();
    // $interval($scope.loadPriceInput, 5000);

    // Tìm kiếm bảng giá theo khoảng thời gian
    $scope.searchPriceInput = function() {
        if($scope.search.start_date != null && $scope.search.end_date != null) {
            $http({
                method : 'POST',
                url : API + 'search-price-input',
                data : $scope.search,
                cache : false,
                header : {'Content-Type':'application/x-www-form-urlencoded'}
            }).then(function (response) {
                $scope.priceInputs = response.data;
            });
        } else {
            $http.get(API + 'price-input').then(function (response) {
                $scope.priceInputs = response.data;
            });
        }
    };

    $scope.data = [];

    // THÊM SẢN PHẨM VÀO DANH SÁCH
    $scope.add = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            $scope.data.push(selected);
            toastr.info('Đã thêm một sản phẩm vào danh sách.');
        } else
            toastr.info('Sản phẩm đã có trong danh sách.');
    };

    // XÓA SẢN PHẢM KHỎI DANH SÁCH
    $scope.delete = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 sản phẩm khỏi danh sách.');
    };

    // THÊM CHI TIẾT BẢNG GIÁ
    $scope.createDetailPriceInput = function (item) {
        $http({
            method : 'POST',
            url : API + 'detail-price-input',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                console.log('1');
            }
        });
    };

    // TẠO BẢNG GIÁ MƠI
    $scope.createPriceInput = function () {
        if($scope.data.length <= 0)
            toastr.info('Vui lòng thêm sản phẩm');
        else {
            var check = true;
            for (var i=0; i<$scope.data.length; i++) {
                if($scope.data[i].price_input == null) {
                    check = false; break;
                }
            };
            if (!check)
                toastr.info('Vui lòng điền giá sản phẩm');
            else {
                $http({
                    method : 'POST',
                    url : API + 'price-input',
                    data : $scope.info,
                    cache : false,
                    header : {'Content-Type':'application/x-www-form-urlencoded'}
                }).then(function (response) {
                    if(response.data.success) {
                        for (var i=0; i<$scope.data.length; i++) {
                            $scope.data[i].price_input_id = response.data.success;
                            $scope.createDetailPriceInput($scope.data[i]);
                        }
                        toastr.success('Đã thêm thành công.');
                        $scope.data = [];
                    } else
                        toastr.error(response.data[0]);
                });
            }
        }
    };

    // XEM BẢNG GIÁ
    $scope.readPriceInput = function (priceInput) {
        $http.get(API + 'price-input/' + priceInput.id).then(function (response) {
            $scope.selected = response.data;
        });
        $http.get(API + 'get-detail-price-input/' + priceInput.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    // DUYỆT BẢNG GIÁ
    $scope.changeStatus = function () {
        console.log($scope.newStatus, $scope.selected.id);
        $http.get(API + 'confirm-price-input/' + $scope.selected.id + '/' + $scope.newStatus).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPriceInput();
            } else
                toastr.error(response.data[0]);
        });
    }

    // XÓA BẢNG GIÁ
    $scope.deletePriceInput = function () {
        $http({
            method : 'DELETE',
            url : API + 'price-input/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadPriceInput();
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