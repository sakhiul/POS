<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\productController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\tokenVerificationMiddleware;

//Web Route
Route::post('/user-registration',[userController::class,'userRegistration']);
Route::post('/user-login',[userController::class,'userLogin']);
Route::post('/send-otp',[userController::class,'sendOTPCode']);
Route::post('/verify-otp',[userController::class,'verifyOtpCode']);
Route::post('/reset-password',[userController::class,'resetPassword'])->middleware([tokenVerificationMiddleware::class]);

//user profile
Route::get('/user-profile',[userController::class,'userProfile'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/user-update',[userController::class,'userProfileUpdate'])->middleware([tokenVerificationMiddleware::class]);

//logout
Route::get('/logout',[userController::class,'userLogout']);

//Page Route
Route::get('/',[HomeController::class,'HomePage']);
Route::get('/userRegistration',[userController::class,'userRegistrationPage']);
Route::get('/userLogin',[userController::class,'userLoginPage']);
Route::get('/sendOtp',[userController::class,'sendOtp']);
Route::get('/verifyOtp',[userController::class,'verifyOtp']);
Route::get('/resetPassword',[userController::class,'resetPass'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/userProfile',[userController::class,'profilePage'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/categoryPage',[categoryController::class,'categoryPage'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage',[productController::class,'productPage'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);


//category Api
Route::post('/create-category',[categoryController::class,'categoryCreate'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/list-category',[categoryController::class,'categoryList'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/delete-category',[categoryController::class,'categoryDelete'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/update-category',[categoryController::class,'categoryUpdate'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/category-by-id',[categoryController::class,'categoryByID'])->middleware([tokenVerificationMiddleware::class]);

// Customer API
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);


//product Api
Route::post('/create-product',[productController::class,'productCreate'])->middleware([tokenVerificationMiddleware::class]);
Route::get('/list-product',[productController::class,'productList'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/delete-product',[productController::class,'productDelete'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/update-product',[productController::class,'productUpdate'])->middleware([tokenVerificationMiddleware::class]);
Route::post('/product-by-id',[productController::class,'productByID'])->middleware([tokenVerificationMiddleware::class]);

// Invoice
Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select",[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);

// SUMMARY & Report
Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);


//Dashboard
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
