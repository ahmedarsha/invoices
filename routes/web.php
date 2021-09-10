<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
define('PAGINATION_COUNT',10);

Auth::routes(['register' => false]);
Route::group(["middleware"=>"auth"],function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/index', 'HomeController@index')->name('home');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    
    ############### Start Invoices Routes #####################
    Route::resource('invoices', 'InvoiceController');
    Route::get('category/{id}', 'InvoiceController@getproducts');
    Route::put('invoices/update/{id}', 'InvoiceController@update')->name('invoices.update');
    Route::put('invoices/changeStatus/{id}', 'InvoiceController@changeStatus')->name('invoices.changeStatus');
    Route::delete('invoiceArchiving/{id}', 'InvoiceController@invoiceArchiving')->name('invoices.invoicesArchiving');
    Route::delete('invoiceUnArchiving/{id}', 'InvoiceController@invoiceUnArchiving')->name('invoices.invoiceUnArchiving');
    Route::get('printInvoice/{id}', 'InvoiceController@printInvoice')->name('invoices.invoicePrint');
    Route::get('invoicesPaid', 'InvoiceController@invoicesPaid')->name('invoices.invoicesPaid');
    Route::get('invoicesUnpaid', 'InvoiceController@invoicesUnpaid')->name('invoices.invoicesUnpaid');
    Route::get('partialInvoices', 'InvoiceController@partialInvoices')->name('invoices.partialInvoices');
    Route::get('invoicesArchived', 'InvoiceController@invoicesArchived')->name('invoices.invoicesArchived');
    Route::get('export_invoices', 'InvoiceController@export')->name('invoices.export');
    Route::get('markAsReadAll', 'InvoiceController@markAsReadAll')->name('invoices.markAsRead');
    ############### End Invoices Routes #######################

    ############ show the details of special invoice ############
    Route::get('invoiceDetails/{id}', 'InvoiceDetailsController@show')->name("invoicesDetails");

    ############### Start Invoices Attachmen Routes #####################
    Route::resource('invoicesAttachment', 'InvoiceAttachmentController');
    Route::get('invoicesAttachment/{id}/download', 'InvoiceAttachmentController@getDownload')->name('invoicesAttachment.download');
    ############### End Invoices Attachmen Routes #######################

    ############### Start Categories Routes #####################
    Route::resource('categories', 'CategoryController');
    ############### End Categories Routes #######################

    ############### Start Products Routes #####################
    Route::resource('products', 'ProductController');
    ############### End Products Routes #######################

    
    ############### Start Reports Routes #####################
    ################# Start invoices reports ############
    Route::get('invoices_reports','InvoiceReportController@index')->name('invoices_reports');
    Route::post('resulte_invoices_reports','InvoiceReportController@resulte')->name('resulte_invoices_reports');
    ################# End invoices reports ############

    ################# Start customers reports ############
    Route::get('customer_reports','CustomerReportController@index')->name('customer_reports');
    Route::post('resulte_customer_reports','CustomerReportController@resulte')->name('resulte_customer_reports');
    ################# End customers reports ############
    ############### End Reports Routes #####################
    
    Route::get('/{page}', 'AdminController@index');
});

