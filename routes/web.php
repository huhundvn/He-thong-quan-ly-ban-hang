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

Route::group(['middleware' => 'auth'], function (){
    Route::get('/home-report', 'HomeController@report') -> name('home-report');

    /**
     * CRUD nhân viên
     */
    Route::resource('user', 'UserController');
    Route::get('/list-user', 'UserController@listUser') -> name('list-user');
    Route::get('/user/search/{term}', 'UserController@searchUser') -> name('search-user');
    Route::post('/user/importFromFile', 'UserController@importFromFile') -> name('importUserFromFile');
	Route::get('/download-user-template', 'UserController@downloadTemplate') -> name('downloadUserTemplate');

    /**
     * CRUD chức vụ
     */
    Route::resource('position', 'PositionController');
    Route::get('/list-position', 'PositionController@listPosition') -> name('list-position');
    Route::get('/position/search/{term}', 'PositionController@searchPosition') -> name('search-position');

    /**
     * CRUD khách hàng
     */
    Route::resource('customer', 'CustomerController');
    Route::get('/list-customer', 'CustomerController@listCustomer') -> name('list-customer');
    Route::get('/customer/search/{term}', 'CustomerController@searchCustomer') -> name('search-customer');
    Route::post('/customer/importFromFile', 'CustomerController@importFromFile') -> name('importCustomerFromFile');
	Route::get('/download-customer-template', 'CustomerController@downloadTemplate') -> name('downloadCustomerTemplate');

    /**
     * CRUD nhóm khách hàng
     */
    Route::resource('customerGroup', 'CustomerGroupController');
    Route::get('/list-customer-group', 'CustomerGroupController@listGroupCustomer') -> name('list-customer-group');
	Route::get('/customerGroup/search/{term}', 'CustomerGroupController@searchCustomerGroup');
	Route::get('/download-customergroup-template', 'CustomerGroupController@downloadTemplate') -> name('downloadCustomerGroupTemplate');

	/**
	 * CRUD cửa hàng, kho hàng
	 */
	Route::resource('store', 'StoreController');
	Route::get('/list-store', 'StoreController@listStore') -> name('list-store');
	Route::get('/store/search/{term}', 'StoreController@searchStore') -> name('search-store');
	Route::get('/storage', 'StoreController@getStorage');
	Route::post('/store/importFromFile', 'StoreController@importFromFile') -> name('importStoreFromFile');
	Route::get('/download-store-template', 'StoreController@downloadTemplate') -> name('downloadStoreTemplate');

	/**
	 * CRUD đơn vị tính
	 */
	Route::resource('unit', 'UnitController');
	Route::get('/list-unit', 'UnitController@listUnit') -> name('list-unit');
	Route::get('/unit/search/{term}', 'UnitController@searchUnit') -> name('search-unit');
	Route::post('/unit/importFromFile', 'UnitController@importFromFile') -> name('importUnitFromFile');
	Route::get('/download-unit-template', 'UnitController@downloadTemplate') -> name('downloadUnitTemplate');

	/**
	 * CRUD nhà sản xuất
	 */
	Route::resource('manufacturer', 'ManufacturerController');
	Route::get('/list-manufacturer', 'ManufacturerController@listManufacturer') -> name('list-manufacturer');
	Route::get('/manufacturer/search/{term}', 'ManufacturerController@searchManufacturer') -> name('search-manufacturer');
	Route::post('/manufacturer/importFromFile', 'ManufacturerController@importFromFile') -> name('importManufacturerFromFile');
	Route::get('/download-manufacturer-template', 'ManufacturerController@downloadTemplate') -> name('downloadManufacturerTemplate');

	/**
	 * CRUD nhà cung cấp
	 */
	Route::resource('supplier', 'SupplierController');
	Route::get('/list-supplier', 'SupplierController@listSupplier') -> name('list-supplier');
	Route::get('/supplier/search/{term}', 'SupplierController@searchSupplier') -> name('search-supplier');
	Route::post('/supplier/importFromFile', 'SupplierController@importFromFile') -> name('importSupplierFromFile');
	Route::get('/download-supplier-template', 'SupplierController@downloadTemplate') -> name('downloadSupplierTemplate');

	/**
	 * CRUD thuộc tính
	 */
	Route::resource('attribute', 'AttributeController');
	Route::get('/list-attribute', 'AttributeController@listAttribute') -> name('list-attribute');
	Route::get('/attribute/search/{term}', 'AttributeController@searchAttribute') -> name('search-attribute');

	/**
	 * CRUD sản phẩm
	 */
	Route::resource('product', 'ProductController');
	Route::get('/list-product', 'ProductController@listProduct') -> name('list-product');
	Route::get('/product/search/{term}', 'ProductController@searchProduct') -> name('search-product');
	Route::post('/product/importFromFile', 'ProductController@importFromFile') -> name('importProductFromFile');
	Route::post('/product/upload-image', 'ProductController@uploadImage') -> name('uploadImage');
	Route::get('/download-product-template', 'ProductController@downloadTemplate') -> name('downloadProductTemplate');

	/**
	 * CRUD nhóm sản phẩm
	 */
	Route::resource('category', 'CategoryController');
	Route::get('/category/search/{term}', 'CategoryController@searchCategory');
	Route::post('/category/importFromFile', 'CategoryController@importFromFile') -> name('importCategoryFromFile');
	Route::get('/list-category', 'CategoryController@listCategory') -> name('list-category');
	Route::get('/download-category-template', 'CategoryController@downloadTemplate') -> name('downloadCategoryTemplate');


	/**
	 * CRUD tài khoản thanh toán
	 */
	Route::resource('account', 'AccountController');
	Route::get('/list-account', 'AccountController@listAccount') -> name('list-account');
	Route::get('/account/search/{term}', 'AccountController@searchAccount') -> name('search-account');
	Route::get('/download-account-template', 'AccountController@downloadTemplate') -> name('downloadAccountTemplate');

	/**
	 * CRUD nhập kho
	 */
	Route::resource('input-store', 'InputStoreController');
	Route::get('/input-store/search/{term}', 'InputStoreController@searchInputStore');
	Route::post('/input-store/importFromFile', 'InputStoreController@importFromFile') -> name('importInputStoreFromFile');
	Route::get('/list-input-store', 'InputStoreController@listInputStore') -> name('list-input-store');
	Route::get('/create-input-store', 'InputStoreController@createInputStore') -> name('createInputStore');
	Route::get('/download-input-template', 'InputController@downloadTemplate') -> name('downloadInputStoreTemplate');


});