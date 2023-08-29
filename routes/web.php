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
Route::group(['prefix' => 'admin', 'middleware' => 'guest'], function() {
    Route::get('/', function () {
        return view('auth.login');
    });
   // Auth::routes();
    Route::get('/login', function () {
        return view('auth.login');
    });
    Route::post('/login', 'Auth\LoginController@login');

    Route::get('logout', 'Auth\LoginController@logout');

    Route::get('/forgot-password', function () {
        return view('auth.passwords.email');
    });
    Route::post('/send-email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

    Route::get('/password/reset/{token}', function () {
        return view('auth.passwords.reset');
    });
    Route::post('reset-password', 'Auth\ForgotPasswordController@reset');
    Route::get('set-password/{token}', 'Auth\ForgotPasswordController@setPassword');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('users', 'UserController@loadUsers');
    Route::get('user-detail/{id}', 'UserController@userDetail');
    Route::get('update-kyc-status/{id}/{status}', 'UserController@updateKycStatus');
    Route::get('update-user-status/{id}/{status}', 'UserController@updateUserStatus');
    Route::get('load-loan-ajax-page/{status}', 'UserController@loadLoanAjaxPage');
    Route::get('load-loan-request', 'UserController@loadLoanRequest');
    Route::get('load-loan-ajax-lenders/{id}', 'UserController@loadLoanAjaxLenders');
    Route::get('loans', 'LoanRequestController@getLoansRequests');
    Route::get('approval-loans', 'LoanRequestController@approvalLoans');
    Route::get('un-paid-emi-list', 'LoanRequestController@unPaidEmiList');
    Route::get('update-loan-status/{id}/{status}', 'LoanRequestController@updateLoanStatus');
    Route::get('invest-request', 'InvestRequestController@investRequest');
    Route::get('update-invest-status/{id}/{status}', 'InvestRequestController@updateInvestStatus');

    Route::get('invest', 'InvestRequestController@getInvestRequests');
    Route::get('load-invest-ajax-page/{status}', 'InvestRequestController@loadInvestAjaxPage');
    Route::get('load-invest-request', 'InvestRequestController@loadInvestRequest');
    /** manage Commission */
    Route::get('commission-list', 'SettingController@loadAdminCommission');
    Route::get('wallet-commission-list', 'SettingController@loadWalletCommission');
    Route::get('emi-lender-hold-amount', 'SettingController@emiLenderHoldAmount');
    Route::get('set-commission', 'SettingController@index');
    Route::post('update-commission', 'SettingController@updateCommission');
    Route::post('update-invest-commission', 'SettingController@updateInvestCommission');
    Route::post('update-wallet-commission', 'SettingController@updateWalletCommission');
    /** manage Ratings & Reviews */
    Route::get('reviews-and-ratings', 'RatingController@loadRatings');
    Route::get('rating-detail/{id}', 'RatingController@ratingDetail');
    Route::get('change-rating-flag/{id}', 'RatingController@changeRatingFlag');
    /** manage CMS section */
    Route::get('manage-cms', 'CmsController@index');
    Route::get('edit-cms/{id}', 'CmsController@editCms');
    Route::post('update-cms', 'CmsController@updateCms');
    /** manage FAQ section */
    Route::get('manage-faqs', 'ManageFaqsController@index');
    Route::get('add-faqs', 'ManageFaqsController@addFaq');
    Route::post('save-faqs', 'ManageFaqsController@saveFaqs');
    Route::get('edit-faq/{id}', 'ManageFaqsController@editFaq');
    Route::post('update-faqs', 'ManageFaqsController@updateFaqs');
    /** manage Profile */
    Route::post('update-profile', 'UserController@updateProfile');
    Route::post('change-password', 'UserController@changePassword');
    Route::get('support', 'SupportController@index');
    /** manage Reports */
    Route::get('user-report', 'ReportController@userReport');
    Route::get('loan-report', 'ReportController@loanReport');
    Route::get('invest-report', 'ReportController@investReport');
    Route::get('manage-transfer', 'WalletController@index');
    /** Pay EMI */
    Route::get('check-loan-request-expiry', 'LoanRequestController@checkLoanRequestExpiry');
    Route::get('check-invest-maturity', 'LoanRequestController@checkInvestMaturity');
    Route::get('pay-missed-loan-emi/{id}', 'LoanRequestController@payMissedLoanEmi');

    /****** Load Notification ********/
    Route::get('load-notification', 'NotificationController@getNotification');
    Route::get('notifications', 'NotificationController@index');
    Route::get('get-all-notification-list', 'NotificationController@loadAllNotificationList');

    /****** Wallet and Bank transfer ********/
    Route::post('add-bank', 'WalletController@addBank');
    Route::get('load-bank-list', 'WalletController@loadBankList');
    Route::post('bank-transfer', 'WalletController@bankTransfer');

    Route::get('delete-bank/{id}', 'WalletController@deleteBank');
    Route::get('transaction', 'WalletController@getTransaction');

    Route::get('mail-send', 'DashboardController@mailSend');


});
/****** Export REport ********/
Route::get('export-user-report', 'ReportController@exportUserReport');
Route::get('export-loan-report', 'ReportController@exportLoanReport');
Route::get('export-invest-report', 'ReportController@exportInvestReport');

Route::get('cms-web-view/{type}', 'CmsController@cmsWebView');
