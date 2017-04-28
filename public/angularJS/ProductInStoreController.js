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

    $http.get(API + 'storage').then(function (response) {
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
});

$("#viewList").click(function () {
    $("#viewList").addClass('w3-blue-grey');
    $("#viewGrid").removeClass('w3-blue-grey');
    $("#grid").attr('hidden', true);
    $("#list").removeAttr('hidden');
});

$("#viewGrid").click(function () {
    $("#viewList").removeClass('w3-blue-grey');
    $("#viewGrid").addClass('w3-blue-grey');
    $("#list").attr('hidden', true);
    $("#grid").removeAttr('hidden');
});