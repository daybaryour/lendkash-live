<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::post('send-otp', 'Api\UserController@sendOTP');
Route::post('verify-otp', 'Api\UserController@OTPVerify');

Route::get('forgot-password/{email}', 'Api\UserController@sendResetLinkEmailApi');
Route::post('reset-password', 'Api\UserController@resetPasswordApi');
Route::get('countries', 'Api\UserController@getCountryList');
Route::get('states/{id}', 'Api\UserController@getStateList');
Route::get('cities/{id}', 'Api\UserController@getCityList');

Route::group(['middleware' => ['jwt.auth', 'authorize']], function () {
    Route::get('logout', 'Api\UserController@logout');
    Route::get('settings', 'Api\UserController@userSetting');
    Route::post('change-password', 'Api\UserController@changePassword');
    Route::post('update-profile', 'Api\UserController@updateProfile');
    Route::get('view-kyc-details', 'Api\UserController@getKycDetail');
    Route::post('complete-kyc-details', 'Api\UserController@completeKycDetail');
    Route::post('calculate-EMI', 'Api\LoanController@calculateEMI');
    Route::post('request-loan', 'Api\LoanController@requestLoan');
    Route::post('cancel-loan-request/{id}', 'Api\LoanController@cancelLoanRequest');
    Route::get('my-loan-requests/{type}', 'Api\LoanController@myLoanRequests');
    Route::get('investments', 'Api\LoanController@myInvestments');
    Route::get('investment-details/{id}', 'Api\LoanController@investmentDetails');
    Route::get('loan-requests', 'Api\LoanController@getAllLoanRequests'); // home page API
    Route::get('request-detail/{id}', 'Api\LoanController@requestDetails');
    Route::post('accept-loan-request', 'Api\LoanController@acceptLoanRequest');
    Route::post('pay-loan-emi', 'Api\LoanController@payLoanEmi');
    Route::delete('reject-loan-request/{id}', 'Api\LoanController@rejectLoanRequest');
    Route::post('calculate-maturity', 'Api\InvestController@calculateMaturity');
    Route::post('request-invest', 'Api\InvestController@requestInvest');
    Route::get('my-invest-requests/{type}', 'Api\InvestController@myInvestRequests');
    Route::post('support-request', 'Api\SettingController@supportRequest');
    Route::get('get-rating-requests/{user_type}', 'Api\RatingController@ratingLoanRequests');
    Route::get('get-request-lenders/{request_id}', 'Api\RatingController@getRequestLenders');
    Route::post('submit-rating-review', 'Api\RatingController@submitReview');
    Route::get('get-rating-detail/{user_id}/{request_id}', 'Api\RatingController@getRatingDetail');

    Route::post('check-user-exist', 'Api\WalletController@checkUserExistByNumber');
    Route::post('send-money-request', 'Api\WalletController@sendRequest');
    Route::get('recent-money-transaction', 'Api\WalletController@recentMoneyTransaction');
    Route::post('pay-request-money', 'Api\WalletController@payRequestMoney');
    Route::get('wallet-transactions/{type}', 'Api\WalletController@getWalletTransactions');
    Route::post('pay-money', 'Api\WalletController@payMoney');
    Route::get('notifications', 'Api\NotificationController@getNotifications');

    Route::post('inbox-chat', 'Api\ChatController@getInboxChats');
    Route::get('get-chat/{inbox_id}', 'Api\ChatController@getSingleChat');

    // Payment Api's
    Route::post('create-payment', 'Api\PaymentController@createPayment');
    Route::post('save-payment', 'Api\PaymentController@savePayment');
    Route::get('get-saved-cards', 'Api\PaymentController@getSavedCards');
    Route::delete('delete-save-card/{card_id}', 'Api\PaymentController@deleteSaveCard');
    Route::post('check-transfer-commission', 'Api\PaymentController@checkTransferCommission');
    Route::post('create-bank-transfer', 'Api\PaymentController@createBankTransfer');


});
Route::post('save-notification', 'Api\ChatController@saveNotification');
Route::post('send-message', 'Api\ChatController@saveMessage');

Route::get('get-cms-detail/{type}', 'Api\SettingController@getCmsDetail');
Route::get('get-loan-term', 'Api\LoanController@getLoanTerms');
Route::get('get-invest-term', 'Api\InvestController@getInvestTerms');

Route::get('test-notification', 'Api\UserController@sendNotification');
