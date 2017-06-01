<?php

use App\Http\Middleware\CheckOrderRole;
use App\Http\Middleware\CheckPriceOutputRole;
use App\Http\Middleware\CheckProductRole;
use App\Http\Middleware\CheckSupplierRole;
use App\Http\Middleware\CheckManufacturerRole;
use App\Http\Middleware\CheckStoreRole;
use App\Http\Middleware\CheckProductInStoreRole;
use App\Http\Middleware\CheckInputStoreRole;
use App\Http\Middleware\CheckPriceInputRole;
use App\Http\Middleware\CheckStoreTranferRole;
use App\Http\Middleware\CheckVoucherRole;
use App\Http\Middleware\CheckCustomerInvoiceRole;
use App\Http\Middleware\CheckSupplierInvoiceRole;
use App\Http\Middleware\CheckAccountRole;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckPositionRole;
use App\Http\Middleware\CheckCustomerRole;
use App\Http\Middleware\CheckStoreOutputRole;
use App\Http\Middleware\CheckReturnRole;

// XÁC THỰC NGƯỜI DÙNG
Auth::routes();

// TRANG CHỦ
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index') -> name('home');

// WEB SERVICE - API LẤY DỮ LIỆU SERVER TRẢ VỀ KIỂU JSON
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    
    // NHÂN VIÊN
	Route::resource('user', 'UserController'); //CRUD nhân viên
	Route::get('/get-sum-user', 'UserController@getSumUser'); // Lấy số lượng nhân viên
    Route::resource('position', 'PositionController'); //CRUD chức vụ
	Route::get('/get-role', 'RoleController@getRole');
	Route::post('/changePassword', 'UserController@changePassword');

	// KHÁCH HÀNG
    Route::resource('customer', 'CustomerController'); //CRUD khách hàng
	Route::get('/get-sum-customer', 'CustomerController@getSumCustomer'); // Lấy số lượng khách hàng
    Route::resource('customerGroup', 'CustomerGroupController'); //CRUD nhóm khách hàng

	// KHO
	Route::resource('store', 'StoreController'); //CRUD cửa hàng, kho hàng
	Route::get('/storage', 'StoreController@getStorage'); // CRUD kho hàng

	// SẢN PHẨM
	Route::resource('manufacturer', 'ManufacturerController'); //CRUD nhà sản xuất
	Route::resource('supplier', 'SupplierController'); //CRUD nhà cung cấp

	Route::resource('product', 'ProductController'); //CRUD sản phẩm
	Route::resource('product-in-store', 'ProductInStoreController'); //CRUD sản phẩm trong kho
	Route::resource('category', 'CategoryController'); //CRUD nhóm sản phẩm
	Route::resource('unit', 'UnitController'); //CRUD đơn vị tính
	Route::resource('attribute', 'AttributeController'); //CRUD thuộc tính
	Route::get('/get-detail-product-attribute/{product_id}', 'ProductAttributeController@getDetail');
	Route::resource('product-attribute', 'ProductAttributeController'); //CRUD chi tiết thuộc tính
	Route::resource('product-image', 'ProductImageController'); //CRUD hình ảnh sản phẩm

	// KẾ TOÁN
	Route::resource('account', 'AccountController'); //CRUD tài khoản thanh toán
	Route::resource('voucher', 'VoucherController'); //CRUD phiếu chi, phiếu thu
	Route::get('/get-detail-voucher/{voucher_id}', 'VoucherController@getDetail');
	Route::get('/get-today-voucher', 'VoucherController@getTodayVoucher');
	Route::post('/search-voucher', 'VoucherController@search'); //Tìm kiếm phiếu thu/chi

	// NHẬP KHO
	Route::resource('input-store', 'InputStoreController'); //CRUD nhập kho
	Route::get('/confirm-input-store/{input_store_id}/{status}', 'InputStoreController@confirm'); //duyệt nhập kho
	Route::get('/get-paid-input-store', 'InputStoreController@getPaidInputStore'); // Lấy hóa đơn nhập kho đã thanh toán
	Route::resource('detail-input-store', 'DetailInputStoreController'); //CRUD chi tiết nhập kho
	Route::get('/get-detail-input-store/{input_store_id}', 'DetailInputStoreController@getDetail');
	Route::post('/search-input-store', 'InputStoreController@search'); //Tìm kiếm lịch sử nhập kho

	// BẢNG GIÁ BÁN
	Route::resource('price-output', 'PriceOutputController'); //CRUD bảng giá bán
	Route::get('/confirm-price-output/{price_output_id}/{status}', 'PriceOutputController@confirm'); //duyệt bảng giá
	Route::resource('detail-price-output', 'DetailPriceOutputController'); //CRUD chi tiết bảng giá
	Route::get('/get-detail-price-output/{price_output_id}', 'DetailPriceOutputController@getDetail');
	Route::get('/get-active-price-output', 'PriceOutputController@getActivePriceOutput');

	// BẢNG GIÁ MUA
	Route::resource('price-input', 'PriceInputController'); //CRUD bảng giá bán nhà cung cấp
	Route::get('/confirm-price-input/{price_input_id}/{status}', 'PriceInputController@confirm'); //duyệt bảng giá
	Route::resource('detail-price-input', 'DetailPriceInputController'); //CRUD chi tiết bảng giá
	Route::get('/get-detail-price-input/{price_input_id}', 'DetailPriceInputController@getDetail');
	Route::get('/get-active-price-input', 'PriceInputController@getActivePriceInput');

	// XUẤT KHO
	Route::resource('store-output', 'StoreOutputController'); //CRUD xuất kho
	Route::resource('detail-store-output', 'DetailStoreOutputController'); //CRUD chi tiết chuyển kho
	Route::get('/get-detail-store-output/{store_output_id}', 'DetailStoreOutputController@getDetail');

	// CHUYỂN KHO
	Route::resource('store-tranfer', 'StoreTranferController'); //CRUD chuyển kho
	Route::get('/confirm-store-tranfer/{store_tranfer_id}/{status}', 'StoreTranferController@confirm'); //duyệt chuyển kho
	Route::resource('detail-store-tranfer', 'DetailStoreTranferController'); //CRUD chi tiết chuyển kho
	Route::get('/get-detail-store-tranfer/{store_tranfer_id}', 'DetailStoreTranferController@getDetail');

	// ĐƠN HÀNG
	Route::resource('order', 'OrderController'); //CRUD đơn đặt hàng
	Route::get('/confirm-order/{order_id}/{status}', 'OrderController@confirm'); //duyệt đơn hàng
	Route::resource('order-detail', 'OrderDetailController'); //CRUD chi tiết đơn hàng
	Route::get('/get-order-detail/{order_id}', 'OrderDetailController@getDetail');
	Route::get('/get-ship-order', 'OrderController@getShipOrder'); // Lấy đơn hàng đã thanh toán
	Route::get('/get-paid-order', 'OrderController@getPaidOrder'); // Lấy đơn hàng đã thanh toán
	Route::get('/get-today-order', 'OrderController@getTodayOrder'); // Lấy số lượng đơn hàng hôm nay
	Route::post('/search-order', 'OrderController@search'); //Tìm kiếm đơn hàng

	// TRẢ VỀ
	Route::resource('return', 'ReturnController'); //CRUD trả về 

	// THANH TOÁN KHÁCH HÀNG
	Route::resource('customer-invoice', 'CustomerInvoiceController'); //CRUD hóa đơn khách hàng
	Route::resource('district', 'DistrictController'); //CRUD địa chỉ huyện
	Route::resource('province', 'ProvinceController'); //CRUD địa chỉ tỉnh
	Route::resource('return-product', 'ReturnProductController'); //CRUD trả về

	// API BÁO CÁO
	Route::get('/top-product', 'ReportController@getTopProduct');
	Route::get('/top-user', 'ReportController@getTopUser');
	Route::get('/report-revenue', 'ReportController@getReportRevenue');
	Route::post('/report-input-store', 'ReportController@getReportInputStore');
	Route::post('/report-product-in-store', 'ReportController@getReportProductInStore');
});

// FRONT-END GIAO ĐIỆN WEB ADMIN
Route::group(['middleware' => 'auth'], function (){

   	// NHÂN VIÊN
    Route::get('/list-user', 'UserController@listUser') -> name('list-user') -> middleware(CheckUserRole::class);
    Route::post('/user/importFromFile', 'UserController@importFromFile') -> name('importUserFromFile') -> middleware(CheckUserRole::class);
	Route::get('/download-user-template', 'UserController@downloadTemplate') -> name('downloadUserTemplate') -> middleware(CheckUserRole::class);
	Route::post('/user/changePassword', 'UserController@changePassword');

    //CHỨC VỤ
    Route::get('/list-position', 'PositionController@listPosition') -> name('list-position') -> middleware(CheckPositionRole::class);

    //KHÁCH HÀNG
    Route::get('/list-customer', 'CustomerController@listCustomer') -> name('list-customer') -> middleware(CheckCustomerRole::class);
    Route::post('/customer/importFromFile', 'CustomerController@importFromFile') -> name('importCustomerFromFile') -> middleware(CheckCustomerRole::class);
	Route::get('/download-customer-template', 'CustomerController@downloadTemplate') -> name('downloadCustomerTemplate') -> middleware(CheckCustomerRole::class);

    //NHÓM KHÁCH HÀNG
    Route::get('/list-customer-group', 'CustomerGroupController@listGroupCustomer') -> name('list-customer-group') -> middleware(CheckCustomerRole::class);
    Route::post('/customer-group/importFromFile', 'CustomerGroupController@importFromFile') -> name('importCustomerGroupFromFile') -> middleware(CheckCustomerRole::class);
	Route::get('/download-customergroup-template', 'CustomerGroupController@downloadTemplate') -> name('downloadCustomerGroupTemplate') -> middleware(CheckCustomerRole::class);

	//CỬA HÀNG, KHO HÀNG
	Route::get('/list-store', 'StoreController@listStore') -> name('list-store') -> middleware(CheckStoreRole::class);
	Route::post('/store/importFromFile', 'StoreController@importFromFile') -> name('importStoreFromFile') -> middleware(CheckStoreRole::class);
	Route::get('/download-store-template', 'StoreController@downloadTemplate') -> name('downloadStoreTemplate') -> middleware(CheckStoreRole::class);

	//NHÀ SẢN XUẤT
	Route::get('/list-manufacturer', 'ManufacturerController@listManufacturer') -> name('list-manufacturer') -> middleware(CheckManufacturerRole::class);
	Route::post('/manufacturer/importFromFile', 'ManufacturerController@importFromFile') -> name('importManufacturerFromFile') -> middleware(CheckManufacturerRole::class);
	Route::get('/download-manufacturer-template', 'ManufacturerController@downloadTemplate') -> name('downloadManufacturerTemplate') -> middleware(CheckManufacturerRole::class);

	//NHÀ CUNG CẤP
	Route::get('/list-supplier', 'SupplierController@listSupplier') -> name('list-supplier') -> middleware(CheckSupplierRole::class);
	Route::post('/supplier/importFromFile', 'SupplierController@importFromFile') -> name('importSupplierFromFile') -> middleware(CheckSupplierRole::class);
	Route::get('/download-supplier-template', 'SupplierController@downloadTemplate') -> name('downloadSupplierTemplate') -> middleware(CheckSupplierRole::class);

	//THUỘC TÍNH SẢN PHẨM
	Route::get('/list-attribute', 'AttributeController@listAttribute') -> name('list-attribute') -> middleware(CheckProductRole::class);
	Route::post('/attribute/importFromFile', 'AttributeController@importFromFile') -> name('importAttributeFromFile') -> middleware(CheckProductRole::class);
	Route::get('/download-attribute-template', 'AttributeController@downloadTemplate') -> name('downloadAttributeTemplate') -> middleware(CheckProductRole::class);

	//SẢN PHẨM
	Route::get('/list-product', 'ProductController@listProduct') -> name('list-product') -> middleware(CheckProductRole::class);
	Route::post('/product/importFromFile', 'ProductController@importFromFile') -> name('importProductFromFile') -> middleware(CheckProductRole::class);
	Route::post('/upload-image', 'ProductController@uploadImage') -> name('uploadImage') -> middleware(CheckProductRole::class);
	Route::get('/download-product-template', 'ProductController@downloadTemplate') -> name('downloadProductTemplate') -> middleware(CheckProductRole::class);

	//ĐƠN VỊ TÍNH
	Route::get('/list-unit', 'UnitController@listUnit') -> name('list-unit') -> middleware(CheckProductRole::class);
	Route::post('/unit/importFromFile', 'UnitController@importFromFile') -> name('importUnitFromFile') -> middleware(CheckProductRole::class);
	Route::get('/download-unit-template', 'UnitController@downloadTemplate') -> name('downloadUnitTemplate') -> middleware(CheckProductRole::class);

	//SẢN PHẨM TRONG KHO
	Route::get('/list-product-in-store', 'ProductInStoreController@listProductInStore') -> name('list-product-in-store') -> middleware(CheckProductInStoreRole::class);

	//NHÓM SẢN PHẨM
	Route::post('/category/importFromFile', 'CategoryController@importFromFile') -> name('importCategoryFromFile') -> middleware(CheckProductRole::class);
	Route::get('/list-category', 'CategoryController@listCategory') -> name('list-category') -> middleware(CheckProductRole::class);
	Route::get('/download-category-template', 'CategoryController@downloadTemplate') -> name('downloadCategoryTemplate') -> middleware(CheckProductRole::class);

	//TÀI KHOẢN THANH TOÁN
	Route::get('/list-account', 'AccountController@listAccount') -> name('list-account') -> middleware(CheckAccountRole::class);
	Route::get('/download-account-template', 'AccountController@downloadTemplate') -> name('downloadAccountTemplate') -> middleware(CheckAccountRole::class);

	//NHẬP KHO
	Route::post('/input-store/importFromFile', 'InputStoreController@importFromFile') -> name('importInputStoreFromFile') -> middleware(CheckInputStoreRole::class);
	Route::get('/list-input-store', 'InputStoreController@listInputStore') -> name('list-input-store') -> middleware(CheckInputStoreRole::class);
	Route::get('/create-input-store', 'InputStoreController@createInputStore') -> name('createInputStore') -> middleware(CheckInputStoreRole::class);
	Route::get('/download-input-template', 'InputController@downloadTemplate') -> name('downloadInputStoreTemplate') -> middleware(CheckInputStoreRole::class);

	//BẢNG GIÁ BÁN
	Route::get('/list-price-output', 'PriceOutputController@listPriceOutput') -> name('list-price-output') -> middleware(CheckPriceOutputRole::class);
	Route::get('/create-price-output', 'PriceOutputController@createPriceOutput') -> name('createPriceOutput') -> middleware(CheckPriceOutputRole::class);

	//BẢNG GIÁ MUA NHÀ CUNG CẤP
	Route::get('/list-price-input', 'PriceInputController@listPriceInput') -> name('list-price-input') -> middleware(CheckPriceInputRole::class);
	Route::get('/create-price-input', 'PriceInputController@createPriceInput') -> name('createPriceInput') -> middleware(CheckPriceInputRole::class);

	//CHUYỂN KHO
	Route::get('/list-store-tranfer', 'StoreTranferController@listStoreTranfer') -> name('list-store-tranfer') -> middleware(CheckStoreTranferRole::class);
	Route::get('/create-store-tranfer', 'StoreTranferController@createStoreTranfer') -> name('createStoreTranfer') -> middleware(CheckStoreTranferRole::class);

	//XUẤT KHO
	Route::get('/list-store-output', 'StoreOutputController@listStoreOutput') -> name('list-store-output') -> middleware(CheckStoreOutputRole::class);
	Route::get('/create-store-output', 'StoreOutputController@createStoreOutput') -> name('createStoreOutput') -> middleware(CheckStoreOutputRole::class);

	//PHIẾU THU, CHI
	Route::get('/list-voucher', 'VoucherController@listVoucher') -> name('list-voucher') -> middleware(CheckVoucherRole::class);

	//ĐƠN HÀNG
	Route::get('/list-order', 'OrderController@listOrder') -> name('list-order') -> middleware(CheckOrderRole::class);
	Route::get('/create-order', 'OrderController@createOrder') -> name('createOrder') -> middleware(CheckOrderRole::class);

	//HÓA ĐƠN KHÁCH HÀNG
	Route::get('/list-customer-invoice', 'CustomerInvoiceController@listCustomerInvoice') -> name('list-customer-invoice') -> middleware(CheckCustomerInvoiceRole::class);

	// HÓA ĐƠN NHÀ CUNG CẤP
	Route::get('/list-input-store-invoice', 'InputStoreController@listInputStoreInvoice') -> name('list-input-store-invoice') -> middleware(CheckSupplierInvoiceRole::class);

	//TRẢ VỀ
	Route::get('/list-return-product', 'ReturnProductController@listReturnProduct') -> name('list-return-product') -> middleware(CheckReturnRole::class);
	Route::get('/create-return-product', 'ReturnProductController@createReturnProduct') -> name('createReturnProduct') -> middleware(CheckReturnRole::class);

	// BÁO CÁO
	Route::get('/top-product', 'ReportController@productReport') -> name('top-product');
	Route::get('/top-user', 'ReportController@userReport') -> name('top-user');
	Route::get('/report-revenue', 'ReportController@revenueReport') -> name('report-revenue');
	Route::get('/report-input-store', 'ReportController@inputStoreReport') -> name('report-input-store');
	Route::get('/report-product-in-store', 'ReportController@productInStoreReport') -> name('report-product-in-store');

	Route::get('/no-permission', 'HomeController@checkPermission') -> name('no-permission');
});

//Route::resource('orders', 'OrderController');
//Route::get('/orders/{customer_id}/customers', 'OrderController@orderByCustomerId')->name('orderByCustomerId');
//Route::get('/orders/{status}/status', 'OrderController@listOrderByStatus');
//Route::get('/orders/{status}/{customer_id}', 'OrderController@listOrderByStatusAndCustomerId');
//Route::put('/orders/{id}/{customer_id}', 'OrderController@updateStatus')->name('updateStatus');
//
///**
// * CRUD order details
// */
//Route::resource('order-details', 'OrderDetailController');
//Route::get('/order-details/{order_id}/order', 'OrderDetailController@listOrderDetailByOrderId');
//Route::put('/order-details/{order_id}/{product_id}', 'OrderDetailController@updateOrderDetailByProductId');
//
///**
// * CRUD Price detail output
// */
//Route::resource("price-detail-output", 'PriceDetailOutputController');
//Route::get("price-detail-output/{id}/price-output", "PriceDetailOutputController@listPriceDetailOutputByOutputId");
//
///**
// * CRUD Price output
// */
//Route::resource("price-output", 'PriceOutputController');
//Route::get('price-output/{id}/customer-group', 'PriceOutputController@listPriceDetailOutput');
//
///**
// * CRUD address
// */
//Route::resource('address', 'AddressController');
//Route::get('address/{customer_id}/customer', 'AddressController@listAddressByCustomerId');
//
///**
// * CRUD cart
// */
//Route::resource('carts', 'CartController');
//Route::get('/carts/{customer_id}/customers', 'CartController@listCartByCustomerId')->name('listCartByCustomerId');
//Route::put('/carts/{customer_id}/{product_id}', 'CartController@updateCartByCustomerId');
//Route::delete('/carts/{customer_id}/customer', 'CartController@deleteCartByCustomerId');
//Route::delete('/carts/{customer_id}/{product_id}', 'CartController@deleteProductInCart');
//
//
//