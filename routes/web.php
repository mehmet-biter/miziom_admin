<?php

use App\Http\Controllers\admin\IconController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\admin\CoinController;
use App\Http\Controllers\Setting\FaqController;
use App\Http\Controllers\admin\LandingController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\CoinSettingsController;
use App\Http\Controllers\Setting\AdminSettingController;

// Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/', [AuthController::class,'login'])->name('login');
Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login-process', [AuthController::class,'loginProcess'])->name('loginProcess');
Route::get('forgot-password', [AuthController::class,'forgotPassword'])->name('forgotPassword');
Route::get('verify-email', 'AuthController@verifyEmailPost')->name('verifyWeb');
Route::get('reset-password', [AuthController::class,'resetPasswordPage'])->name('resetPasswordPage');
Route::post('send-forgot-mail', [AuthController::class,'sendForgotMail'])->name('sendForgotMail');
Route::post('reset-password-save-process', [AuthController::class,'resetPasswordSave'])->name('resetPasswordSave');

Route::post('contact/store',[ContactController::class,'sendEmail'])->name('contactStoreProcess');


Route::group(['prefix' => 'admin', 'middleware' => ['auth','admins']], function () {
    Route::get('logout', [AuthController::class, 'logOut'])->name('logOut');
    Route::get('profile',[ProfileController::class,'index'])->name('profile');
    Route::get('update-profile',[ProfileController::class,'edit'])->name('updateProfile');
    Route::post('profile-update-process',[ProfileController::class,'update'])->name('updateProfileProcess');
    Route::post('change-password-process',[ProfileController::class,'changePassword'])->name('changePasswordProcess');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('adminDashboard');

    Route::group(['middleware' => ['roles']], function () {
    
    Route::get('faq',[FaqController::class,'index'])->name('faqList');
    Route::get('faq/add',[FaqController::class,'create'])->name('faqAdd');
    Route::get('faq/edit-{id}',[FaqController::class,'edit'])->name('faqEdit');
    Route::get('faq/delete-{id}',[FaqController::class,'destroy'])->name('faqDelete');
    Route::get('faq/preview-{id}',[FaqController::class,'preview'])->name('faqPreview');
    Route::post('faq/store',[FaqController::class,'store'])->name('faqStoreProcess');
    
    Route::get('contact-list',[ContactController::class,'index'])->name('contactList');
    Route::get('contact/delete-{id}',[ContactController::class,'destroy'])->name('contactDelete');
    Route::get('contact/preview-{id}',[ContactController::class,'preview'])->name('contactPreview');

    Route::get('role',[RoleController::class,'index'])->name('roleList');
    Route::get('role/add',[RoleController::class,'create'])->name('roleAdd');
    Route::get('role/edit-{id}',[RoleController::class,'edit'])->name('roleEdit');
    Route::get('role/delete-{id}',[RoleController::class,'destroy'])->name('roleDelete');
    Route::get('role/preview-{id}',[RoleController::class,'preview'])->name('rolePreview');
    Route::post('role/store',[RoleController::class,'store'])->name('roleStoreProcess');

    Route::get('list',[UserController::class,'adminList'])->name('adminList');
    Route::get('add',[UserController::class,'create'])->name('adminAdd');
    Route::get('edit-{id}',[UserController::class,'edit'])->name('adminEdit');
    Route::get('delete-{id}',[UserController::class,'destroy'])->name('adminDelete');
    Route::get('preview-{id}',[UserController::class,'preview'])->name('adminPreview');
    Route::post('store',[UserController::class,'store'])->name('adminStoreProcess');

    Route::get('user/list',[UserController::class,'index'])->name('userList');
    Route::get('user/add',[UserController::class,'createUser'])->name('userAdd');
    Route::get('user/edit-{id}',[UserController::class,'edit'])->name('userEdit');
    Route::get('user/delete-{id}',[UserController::class,'destroy'])->name('userDelete');
    Route::get('user/preview-{id}',[UserController::class,'preview'])->name('userPreview');
    Route::post('user/store',[UserController::class,'store'])->name('userStoreProcess');

    Route::get('settings',[AdminSettingController::class,'adminSetting'])->name('adminSetting');
    Route::post('update-generel-settings',[AdminSettingController::class,'updateGeneralSetting'])->name('updateGeneralSetting');
    Route::post('email-save-settings', [AdminSettingController::class,'adminSaveEmailSettings'])->name('adminSaveEmailSettings');
    Route::post('landing-save-settings', [AdminSettingController::class,'adminSaveLandingSettings'])->name('adminSaveLandingSettings');
    Route::post('logo-save-settings', [AdminSettingController::class,'adminSaveLogoSettings'])->name('adminSaveLogoSettings');
    Route::post('send_test_mail', [AdminSettingController::class,'testMail'])->name('testmailsend');

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('adminLogs');

    Route::get('coin-list',[CoinController::class,'adminCoinList'])->name('adminCoinList');
    Route::get('add-new-coin', [CoinController::class,'adminAddCoin'])->name('adminAddCoin');
    Route::get('coin-edit/{id}', [CoinController::class,'adminCoinEdit'])->name('adminCoinEdit');
    Route::get('coin-delete/{id?}', [CoinController::class,'adminCoinDelete'])->name('adminCoinDelete');
    Route::post('coin-save-process', [CoinController::class,'adminCoinSaveProcess'])->name('adminCoinSaveProcess');
    Route::post('save-new-coin', [CoinController::class,'adminSaveCoin'])->name('adminSaveCoin');
    Route::post('change-coin-status', [CoinController::class,'adminCoinStatus'])->name('adminCoinStatus');

    Route::get('currency-list', [CurrencyController::class,'adminCurrencyList'])->name('adminCurrencyList');
    Route::get('currency-add', [CurrencyController::class,'adminCurrencyAdd'])->name('adminCurrencyAdd');
    Route::get('currency-edit-{id}', [CurrencyController::class,'adminCurrencyEdit'])->name('adminCurrencyEdit');
    Route::get('currency-rate-change', [CurrencyController::class,'adminCurrencyRate'])->name('adminCurrencyRate');
    Route::post('currency-all', [CurrencyController::class,'adminAllCurrency'])->name('adminAllCurrency');
    Route::post('currency-status-change', [CurrencyController::class,'adminCurrencyStatus'])->name('adminCurrencyStatus');
    Route::post('currency-save-process', [CurrencyController::class,'adminCurrencyAddEdit'])->name('adminCurrencyStore');

    Route::get('coin-settings/{id}', [CoinController::class, 'adminCoinSettings'])->name('adminCoinSettings');
    Route::post('save-coin-settings', [CoinController::class, 'adminSaveCoinSetting'])->name('adminSaveCoinSetting');
    Route::get('api-settings', [CoinSettingsController::class, "adminCoinApiSettings"])->name('adminCoinApiSettings');
    Route::post('bitgo-webhook-save', [CoinController::class, "webhookSave"])->name('webhookSave');

    Route::get('adjust-bitgo-wallet/{id}', [CoinController::class, 'adminAdjustBitgoWallet'])->name('adminAdjustBitgoWallet');

    Route::get('bitgo-setting', [SettingController::class, 'bitgoSetting'])->name('bitgoSetting');
    Route::post('save-bitgo-settings', [SettingController::class, 'adminSaveBitgoSettings'])->name('adminSaveBitgoSettings');
    
    Route::get('coin-payment-setting', [SettingController::class, 'coinPaymentSetting'])->name('coinPaymentSetting');
    Route::post('save-payment-settings', [SettingController::class, 'adminSavePaymentSettings'])->name('adminSavePaymentSettings');

    Route::get('active-withdrawal', [TransactionController::class, 'adminActiveWithdrawal'])->name('adminActiveWithdrawal');
    Route::get('pending-withdrawal', [TransactionController::class, 'adminPendingWithdrawal'])->name('adminPendingWithdrawal');
    Route::get('rejected-withdrawal', [TransactionController::class, 'adminRejectedWithdrawal'])->name('adminRejectedWithdrawal');

    Route::get('pending-deposit', [TransactionController::class, 'adminPendingDeposit'])->name('adminPendingDeposit');
    Route::get('active-deposit', [TransactionController::class, 'adminActiveDeposit'])->name('adminActiveDeposit');

    Route::get('user-withdrawal-approve/{id}', [TransactionController::class, 'withdrawalApproveProccess'])->name('withdrawalApproveProccess');
    Route::get('user-withdrawal-reject/{id}', [TransactionController::class, 'withdrawalRejecteProccess'])->name('withdrawalRejecteProccess');

    Route::get('admin-config', [ConfigController::class, "configurationPage"])->name('adminConfiguration');
    Route::get('run-admin-command/{type}', [ConfigController::class, "adminRunCommand"])->name('adminRunCommand');
    Route::get('api-service-setting', [SettingController::class, "apiServicPage"])->name('apiServicPage');
    Route::post('api-service-setting', [SettingController::class, 'apiServicSave'])->name('apiServicSave');

    Route::get('custom-page', [LandingController::class, 'adminCustomPage'])->name('adminCustomPage');
    Route::get('custom-page-add', [LandingController::class, 'adminCustomPageAdd'])->name('adminCustomPageAdd');
    Route::get('custom-page-edit/{id}', [LandingController::class, 'adminCustomPageEdit'])->name('adminCustomPageEdit');
    Route::post('custom-page-status', [LandingController::class, 'adminPageStatus'])->name('customPagestatus');
    Route::get('custom-page-delete/{id?}', [LandingController::class, 'customPagesDelete'])->name('adminCustomPageDelete');
    Route::post('custom-page-save', [LandingController::class, 'adminCustomPageSave'])->name('adminCustomPageSave');
    
    Route::get('landing-hero-page-setting', [LandingController::class, 'landingHeroPageSetting'])->name('landingHeroPageSetting');
    Route::post('landing-hero-page-setting', [LandingController::class, 'landingHeroPageSettingSave'])->name('landingHeroPageSettingSave');
    Route::get('landing-body-page-setting', [LandingController::class, 'landingBodyPageSetting'])->name('landingBodyPageSetting');
    Route::post('landing-body-page-setting', [LandingController::class, 'landingBodyPageSettingSave'])->name('landingBodyPageSettingSave');

    Route::get('icon-category-page', [IconController::class, 'iconCategoryPage'])->name('iconCategoryPage');
    Route::get('icon-category/{id?}', [IconController::class, 'iconCategoryAddEdit'])->name('iconCategoryAddEdit');
    Route::post('icon-category', [IconController::class, 'iconCategoryAddEditProccess'])->name('iconCategoryAddEditProccess');
    Route::get('icon-category-delete/{id}', [IconController::class, 'iconCategoryDelete'])->name('iconCategoryDelete');
    Route::post('icon-category-status', [IconController::class, 'iconCategoryStatusUpdate'])->name('iconCategoryStatusUpdate');
});
});





