<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 *
 */
Auth::routes();

/**
 * Day la noi ta co the truy cao vao trang chu
 */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index') -> name('home');
Route::get('/lang/{locale}', array(
    'Middleware' => 'LanguageSwitcher',
    'uses' => 'LanguageController@change'
));

//API ROUTES
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    
    Route::resource('user', 'UserController'); //CRUD nhân viên

    Route::resource('position', 'PositionController'); //CRUD chức vụ

    Route::resource('customer', 'CustomerController'); //CRUD khách hàng

    Route::resource('customerGroup', 'CustomerGroupController'); //CRUD nhóm khách hàng

	Route::resource('store', 'StoreController'); //CRUD cửa hàng, kho hàng
	Route::get('/storage', 'StoreController@getStorage');

	Route::resource('unit', 'UnitController'); //CRUD đơn vị tính

	Route::resource('manufacturer', 'ManufacturerController'); //CRUD nhà sản xuất

	Route::resource('supplier', 'SupplierController'); //CRUD nhà cung cấp

	Route::resource('attribute', 'AttributeController'); //CRUD thuộc tính

	Route::resource('product', 'ProductController'); //CRUD sản phẩm

	Route::resource('product-in-store', 'ProductInStoreController'); //CRUD sản phẩm trong kho

	Route::resource('product-attribute', 'ProductAttributeController'); //CRUD chi tiết thuộc tính
	Route::get('/get-detail-product-attribute/{product_id}', 'ProductAttributeController@getDetail');

	Route::resource('category', 'CategoryController'); //CRUD nhóm sản phẩm

	Route::resource('account', 'AccountController'); //CRUD tài khoản thanh toán

	Route::resource('input-store', 'InputStoreController'); //CRUD nhập kho
	Route::get('/confirm-input-store/{input_store_id}/{status}', 'InputStoreController@confirm');

	Route::resource('detail-input-store', 'DetailInputStoreController'); //CRUD chi tiết nhập kho
	Route::get('/get-detail-input-store/{input_store_id}', 'DetailInputStoreController@getDetail');

	Route::resource('price-output', 'PriceOutputController'); //CRUD bảng giá bán
	Route::get('/confirm-price-output/{price_output_id}/{status}', 'PriceOutputController@confirm');

	Route::resource('detail-price-output', 'DetailPriceOutputController'); //CRUD chi tiết bảng giá
	Route::get('/get-detail-price-output/{price_output_id}', 'DetailPriceOutputController@getDetail');

});

// FRONT-END
Route::group(['middleware' => 'auth'], function (){
    Route::get('/home-report', 'HomeController@report') -> name('home-report');

   	// NHÂN VIÊN
    Route::get('/list-user', 'UserController@listUser') -> name('list-user');
    Route::post('/user/importFromFile', 'UserController@importFromFile') -> name('importUserFromFile');
	Route::get('/download-user-template', 'UserController@downloadTemplate') -> name('downloadUserTemplate');

    //CHỨC VỤ
    Route::get('/list-position', 'PositionController@listPosition') -> name('list-position');
    

    //KHÁCH HÀNG
    Route::get('/list-customer', 'CustomerController@listCustomer') -> name('list-customer');
    Route::post('/customer/importFromFile', 'CustomerController@importFromFile') -> name('importCustomerFromFile');
	Route::get('/download-customer-template', 'CustomerController@downloadTemplate') -> name('downloadCustomerTemplate');

    //NHÓM KHÁCH HÀNG
    Route::get('/list-customer-group', 'CustomerGroupController@listGroupCustomer') -> name('list-customer-group');
    Route::post('/customer-group/importFromFile', 'CustomerGroupController@importFromFile') -> name('importCustomerGroupFromFile');
	Route::get('/download-customergroup-template', 'CustomerGroupController@downloadTemplate') -> name('downloadCustomerGroupTemplate');

	//CỬA HÀNG, KHO HÀNG
	Route::get('/list-store', 'StoreController@listStore') -> name('list-store');
	Route::post('/store/importFromFile', 'StoreController@importFromFile') -> name('importStoreFromFile');
	Route::get('/download-store-template', 'StoreController@downloadTemplate') -> name('downloadStoreTemplate');

	//ĐƠN VỊ TÍNH
	Route::get('/list-unit', 'UnitController@listUnit') -> name('list-unit');
	
	Route::post('/unit/importFromFile', 'UnitController@importFromFile') -> name('importUnitFromFile');
	Route::get('/download-unit-template', 'UnitController@downloadTemplate') -> name('downloadUnitTemplate');

	//NHÀ SẢN XUẤT
	Route::get('/list-manufacturer', 'ManufacturerController@listManufacturer') -> name('list-manufacturer');
	Route::post('/manufacturer/importFromFile', 'ManufacturerController@importFromFile') -> name('importManufacturerFromFile');
	Route::get('/download-manufacturer-template', 'ManufacturerController@downloadTemplate') -> name('downloadManufacturerTemplate');

	//NHÀ CUNG CẤP
	Route::get('/list-supplier', 'SupplierController@listSupplier') -> name('list-supplier');
	Route::post('/supplier/importFromFile', 'SupplierController@importFromFile') -> name('importSupplierFromFile');
	Route::get('/download-supplier-template', 'SupplierController@downloadTemplate') -> name('downloadSupplierTemplate');

	//THUỘC TÍNH SẢN PHẨM
	Route::get('/list-attribute', 'AttributeController@listAttribute') -> name('list-attribute');
	Route::post('/attribute/importFromFile', 'AttributeController@importFromFile') -> name('importAttributeFromFile');
	Route::get('/download-attribute-template', 'AttributeController@downloadTemplate') -> name('downloadAttributeTemplate');

	//SẢN PHẨM
	Route::get('/list-product', 'ProductController@listProduct') -> name('list-product');
	Route::post('/product/importFromFile', 'ProductController@importFromFile') -> name('importProductFromFile');
	Route::post('/upload-image', 'ProductController@uploadImage') -> name('uploadImage');
	Route::get('/download-product-template', 'ProductController@downloadTemplate') -> name('downloadProductTemplate');

	//SẢN PHẨM TRONG KHO
	Route::get('/list-product-in-store', 'ProductInStoreController@listProductInStore') -> name('list-product-in-store');

	//NHÓM SẢN PHẨM
	Route::post('/category/importFromFile', 'CategoryController@importFromFile') -> name('importCategoryFromFile');
	Route::get('/list-category', 'CategoryController@listCategory') -> name('list-category');
	Route::get('/download-category-template', 'CategoryController@downloadTemplate') -> name('downloadCategoryTemplate');


	//TÀI KHOẢN THANH TOÁN
	Route::get('/list-account', 'AccountController@listAccount') -> name('list-account');
	Route::get('/download-account-template', 'AccountController@downloadTemplate') -> name('downloadAccountTemplate');

	//NHẬP KHO
	Route::post('/input-store/importFromFile', 'InputStoreController@importFromFile') -> name('importInputStoreFromFile');
	Route::get('/list-input-store', 'InputStoreController@listInputStore') -> name('list-input-store');
	Route::get('/create-input-store', 'InputStoreController@createInputStore') -> name('createInputStore');
	Route::get('/download-input-template', 'InputController@downloadTemplate') -> name('downloadInputStoreTemplate');

	//BẢNG GIÁ BÁN
	Route::get('/list-price-output', 'PriceOutputController@listPriceOutput') -> name('list-price-output');
	Route::get('/create-price-output', 'PriceOutputController@createPriceOutput') -> name('createPriceOutput');

	//PHIẾU THU, CHI
	Route::get('/list-voucher', 'VoucherController@listVoucher') -> name('list-voucher');

});