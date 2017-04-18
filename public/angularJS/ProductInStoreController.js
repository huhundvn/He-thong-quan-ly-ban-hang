/**
 * Created by Good on 3/28/2017.
 */

app.controller('ProductInStoreController', function($scope, $http, API) {

    $http.get(API + 'category').then(function (response) {
        $scope.categorys = response.data;
    });

    $http.get(API + 'unit').then(function (response) {
        $scope.units = response.data;
    });

    $http.get(API + 'manufacturer').then(function (response) {
        $scope.manufacturers = response.data;
    });

    $http.get(API + 'supplier').then(function (response) {
        $scope.suppliers = response.data;
    });

    $http.get(API + 'attribute').then(function (response) {
        $scope.attributes = response.data;
    });

    $http.get(API + 'product').then(function (response) {
        $scope.products = response.data;
    });

    $http.get(API + 'store').then(function (response) {
        $scope.stores = response.data;
    });

    /**
     * Load danh sách sản phẩm trong kho
     */
    $scope.loadProductInStore = function () {
        $http.get(API + 'product-in-store').then(function (response) {
            $scope.productInStores = response.data;
        });
    };
    $scope.loadProductInStore();

    /**
     * CRUD sản phẩm
     */
    $scope.data = [];
    // Thêm thuộc tính vào danh sách
    $scope.addAttribute = function(selected) {
        if($scope.data.indexOf(selected) == -1) {
            $scope.data.push(selected);
            toastr.info('Đã thêm một thuộc tính vào danh sách.');
        } else
            toastr.info('Thuộc tính đã có trong danh sách.');
    };
    // Xóa thuộc tính khỏi danh sách
    $scope.deleteAttribute = function(selected) {
        $scope.data.splice($scope.data.indexOf(selected), 1);
        toastr.info('Đã xóa 1 thuộc tính khỏi danh sách.');
    };

    // Thêm thuộc tính cho sản phẩm
    $scope.createAttributeForProduct = function (item) {
        $http({
            method : 'POST',
            url : API + 'product-attribute',
            data : item,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                console.log('1');
            }
        });
    };

    $scope.createProduct = function () {
        if( CKEDITOR.instances.newDescription.getData() )
            $scope.new.description = CKEDITOR.instances.newDescription.getData();
        if ( CKEDITOR.instances.newUserGuide.getData() )
            $scope.new.user_guide = CKEDITOR.instances.newUserGuide.getData();
        $http({
            method : 'POST',
            url : API + 'product',
            data : $scope.new,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                for (var i=0; i<$scope.data.length; i++) {
                    $scope.data[i].product_id = response.data.success;
                    $scope.createAttributeForProduct($scope.data[i]);
                }
                toastr.success('Đã thêm thành công.');
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadProduct();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.readProduct = function (product) {
        $http.get(API + 'product/' + product.id).then(function (response) {
            $scope.selected = response.data;
            CKEDITOR.instances.description.setData($scope.selected.description);
            CKEDITOR.instances.user_guide.setData($scope.selected.user_guide);
        });
        $http.get(API + 'get-detail-product-attribute/' + product.id).then(function (response) {
            $scope.detail = response.data;
        });
    };

    $scope.updateProduct = function () {
        if( CKEDITOR.instances.description.getData() )
            $scope.selected.description = CKEDITOR.instances.description.getData();
        if ( CKEDITOR.instances.user_guide.getData() )
            $scope.selected.user_guide = CKEDITOR.instances.user_guide.getData();
        $http({
            method : 'PUT',
            url : API + 'product/' + $scope.selected.id,
            data : $scope.selected,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadProduct();
            }
            else
                toastr.error(response.data[0]);
        });
    };

    $scope.deleteProduct = function () {
        $http({
            method : 'DELETE',
            url : API + 'product/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadProduct();
            } else
                toastr.error(response.data[0]);
        });
    };

    $('#createProduct').on('hidden.bs.modal', function(){
        $scope.data = [];
        $(this).find('form')[0].reset();
    });

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

$('#readProduct').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-title').text('Xem thông tin sản phẩm');
    modal.find('.modal-title').removeClass('w3-text-green');
    modal.find('.modal-title').addClass('w3-text-blue');
    modal.find('#name').attr('readOnly', true);
    modal.find('#code').attr('readOnly', true);
    CKEDITOR.instances.description.setReadOnly(true);
    CKEDITOR.instances.user_guide.setReadOnly(true);
    modal.find('#category').attr('disabled', true);
    modal.find('#manufacturer').attr('disabled', true);
    modal.find('#unit').attr('disabled', true);
    modal.find('#min_inventory').attr('readOnly', true);
    modal.find('#max_inventory').attr('readOnly', true);
    modal.find('#warranty_period').attr('readOnly', true);
    modal.find('#return_period').attr('readOnly', true);
    modal.find('#weight').attr('readOnly', true);
    modal.find('#size').attr('readOnly', true);
    modal.find('#volume').attr('readOnly', true);
    modal.find('#submit').hide();
    modal.find('#updateProduct').show();
    modal.find('#updateProduct').click(function () {
        modal.find('.modal-title').text('Sửa thông tin sản phẩm');
        modal.find('.modal-title').removeClass('w3-text-blue');
        modal.find('.modal-title').addClass('w3-text-green');
        modal.find('#name').removeAttr('readOnly');
        modal.find('#code').removeAttr('readOnly');
        CKEDITOR.instances.description.setReadOnly(false);
        CKEDITOR.instances.user_guide.setReadOnly(false);
        modal.find('#user_guide').removeAttr('disabled');
        modal.find('#category').removeAttr('disabled');
        modal.find('#manufacturer').removeAttr('disabled');
        modal.find('#unit').removeAttr('disabled');
        modal.find('#min_inventory').removeAttr('readOnly');
        modal.find('#max_inventory').removeAttr('readOnly');
        modal.find('#warranty_period').removeAttr('readOnly');
        modal.find('#return_period').removeAttr('readOnly');
        modal.find('#weight').removeAttr('readOnly');
        modal.find('#size').removeAttr('readOnly', true);
        modal.find('#volume').removeAttr('readOnly', true);
        modal.find('#updateProduct').hide();
        modal.find('#submit').show();
    });
});

$("#my-dropzone").dropzone({
    maxFileSize: 2,
    addRemoveLinks: true,
    paramName: 'upload[image]',
});
