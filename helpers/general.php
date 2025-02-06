<?php

use App\Http\HelperResponse\ApiResponse;
use App\Models\Sale;
use App\Models\User_Information;
use App\Models\User_wallet;
use App\Models\User_wallet_log;
use App\Models\ez_auth;
use Carbon\Carbon;

use  App\Http\Controllers\sources\EZController;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PaymentPrices;
use App\Services\Logs\LogsService;
use App\Services\Wallet\WalletServices;
use PhpParser\Node\Expr\Cast\Double;

// function getStatusText($responseCode)
// {
//     $statusTexts = [
//         LOGIN_SUCCESS_CODE => trans('api_response.LOGIN_SUCCESSFULLUJY'),
//         REGISTER_SUCCESS_CODE => trans('api_response.REGISTER_SUCCESSFULLUJY'),
//         Model_Not_Found => trans('api_response.Model_Not_Found'),
//         GET_PROFILE_CODE =>  trans('api_response.GET_PROFILE'),
//         RESET_EMAIL_SEND_CODE => trans('api_response.RESET_EMAIL_SEND'),
//         RESET_PASSWORD_SUCCESS_CODE => trans('api_response.RESET_PASSWORD'),
//         RESET_PASSWORD_ERROR_CODE => trans('api_response.RESET_PASSWORD_ERROR'),
//         RESET_NEW_PASSWOED_CODE => trans('api_response.RESET_NEW_PASSWOED_SUCCESSFULLUJY'),
//         UPDATE_PROFILE_CODE => trans('api_response.UPDATE_PROFILE_SUCCESSFULLUJY'),
//         GET_USER_WALLET_CODE => trans('api_response.GET_USER_WALLET'),
//         USER_LOGOUT_CODE => trans('api_response.USER_LOGOUT'),
//         VERFIY_EMAIL_CODE => trans('api_response.VERFIY_EMAIL'),
//         EMAIL_REQUIRED => trans('api_response.EMAIL_REQUIRED'),
//         EMAIL_EMAIL => trans('api_response.EMAIL_EMAIL'),
//         EMAIL_EXISTS => trans('api_response.EMAIL_EXISTS'),
//         PASSWORD_REQUIRED => trans('api_response.PASSWORD_REQUIRED'),
//         EMAIL_VERIFIED_AT => trans('api_response.EMAIL_VERIFIED_AT'),
//         QUANTITY_FAILED => trans('api_response.QUANTITY_FAILED'),
//         NAME_REQUIRED => trans('api_response.NAME_REQUIRED'),
//         NAME_UNIQUE => trans('api_response.NAME_UNIQUE'),
//         NAME_REGEX => trans('api_response.NAME_REGEX'),
//         EMAIL_STRING => trans('api_response.EMAIL_STRING'),
//         EMAIL_MAX => trans('api_response.EMAIL_MAX'),
//         EMAIL_REGEX => trans('api_response.EMAIL_REGEX'),
//         PASSWORD_ALPHA_NUM => trans('api_response.PASSWORD_ALPHA_NUM'),
//         PASSWORD_STRING => trans('api_response.PASSWORD_STRING'),
//         PASSWORD_MIN => trans('api_response.PASSWORD_MIN'),
//         CONFIRM_PASSWORD_REQUIRED_WITH => trans('api_response.CONFIRM_PASSWORD_REQUIRED_WITH'),
//         CONFIRM_PASSWORD_SAME => trans('api_response.CONFIRM_PASSWORD_SAME'),
//         CONFIRM_PASSWORD_MIN => trans('api_response.CONFIRM_PASSWORD_MIN'),
//         TOKEN_REQUIRED => trans('api_response.TOKEN_REQUIRED'),
//         TOKEN_EXISTS => trans('api_response.TOKEN_EXISTS'),
//         DOB_REQUIRED => trans('api_response.DOB_REQUIRED'),
//         REMEMBER_TOKEN_REQUIRED => trans('api_response.REMEMBER_TOKEN_REQUIRED'),
//         REMEMBER_TOKEN_EXISTS => trans('api_response.REMEMBER_TOKEN_EXISTS'),
//         MESSAGE_CODE_ERROR_CODE => trans('api_response.MESSAGE_CODE_ERROR_CODE'),
//         MESSAGE_CODE_SUCCESS_CODE => trans('api_response.MESSAGE_CODE_SUCCESS_CODE'),
//         GET_CATEGORY_SUCCESS_CODE => trans('api_response.GET_CATEGORY_SUCCESS_CODE'),
//         GET_COUNTRY_SUCCESS_CODE => trans('api_response.GET_COUNTRY_SUCCESS_CODE'),
//         CATEGORYID_REQUIRED => trans('api_response.CATEGORYID_REQUIRED'),
//         CATEGORYID_EXISTS => trans('api_response.CATEGORYID_EXISTS'),
//         GET_SUB_COUNTRY_SUCCESS_CODE => trans('api_response.GET_SUB_COUNTRY_SUCCESS_CODE'),
//         SUB_CATEGORY_EMPTY => trans('api_response.SUB_CATEGORY_EMPTY'),
//         COUNTRY_EMPTY => trans('api_response.COUNTRY_EMPTY'),
//         CATEGORY_EMPTY => trans('api_response.CATEGORY_EMPTY'),
//         USER_WALLET_EMPTY => trans('api_response.USER_WALLET_EMPTY'),
//         GET_SLIDER_SUCCESS_CODE => trans('api_response.GET_SLIDER_SUCCESS_CODE'),
//         GET_REWARDS_SUCCESS_CODE => trans('api_response.GET_REWARDS_SUCCESS_CODE'),
//         REWARDS_EMPTY => trans('api_response.REWARDS_EMPTY'),
//         ITEM_ID_REQUIRED => trans('api_response.ITEM_ID_REQUIRED'),
//         ITEM_ID_EXISTS => trans('api_response.ITEM_ID_EXISTS'),
//         SILVER_NOT_ENOUGH_CODE => trans('api_response.SILVER_NOT_ENOUGH_CODE'),
//         SALE_ID_NULL_CODE => trans('api_response.SALE_ID_NULL_CODE'),
//         VOUCHER_ERROR_CODE => trans('api_response.VOUCHER_ERROR_CODE'),
//         VOUCHER_SUCCESS_CODE => trans('api_response.VOUCHER_SUCCESS_CODE'),
//         PHONE_ZAIN_CASH_NOT_FOUND => trans('api_response.PHONE_ZAIN_CASH_NOT_FOUND'),
//         PARAMETER_IS_NULL_CODE => trans('api_response.PARAMETER_IS_NULL_CODE'),
//         CODE_VALIDATION => trans('api_response.CODE_VALIDATION'),
//         REDEEM_VOUCHER_SUCCESS_CODE => trans('api_response.REDEEM_VOUCHER_SUCCESS_CODE'),
//         INCCORECT_DATA_ERROR_CODE => trans('api_response.INCCORECT_DATA_ERROR_CODE'),
//         PASSWORD_VALIDATION => trans('api_response.PASSWORD_VALIDATION'),
//         PHONE_EXISTS => trans('api_response.PHONE_EXISTS'),
//         REFRESH_TOKEN_CODE => trans('api_response.REFRESH_TOKEN_CODE'),
//         DELETE_ACCONT_CODE => trans('api_response.DELETE_ACCONT_CODE'),
//         TERMS_CONDITIONS_SUCCESS => trans('api_response.TERMS_CONDITIONS_SUCCESS'),
//         PRIVACY_POLICY_SUCCESS => trans('api_response.PRIVACY_POLICY_SUCCESS'),
//         ABOUT_US_SUCCESS   => trans('api_response.ABOUT_US_SUCCESS'),
//         FAQ_SUCCESS => trans('api_response.FAQ_SUCCESS'),
//         SUBJECT_REQUIRED => trans('api_response.SUBJECT_REQUIRED'),
//         MESSAGE_REQUIRED => trans('api_response.MESSAGE_REQUIRED'),
//         CONTACT_US_SUCCESS => trans('api_response.CONTACT_US_SUCCESS'),
//         USER_DELETED => trans('api_response.USER_DELETED'),
//         STATEMENTS_EMPTY => trans('api_response.STATEMENTS_EMPTY'),
//         GET_STATEMENTS_SUCCESS_CODE => trans('api_response.GET_STATEMENTS_SUCCESS_CODE'),
//         SEARCH_SUCCESS_CODE => trans('api_response.SEARCH_SUCCESS_CODE'),
//         SEARCH_NOT_FOUND  => trans('api_response.SEARCH_NOT_FOUND'),

//         GATEWAY_EMPTY => trans('api_response.GATEWAY_EMPTY'),
//         GET_GATEWAY_SUCCESS_CODE => trans('api_response.GET_GATEWAY_SUCCESS_CODE'),
//         SLIDER_EMPTY => trans('api_response.SLIDER_EMPTY'),
//         FUND_WALLET_ITEMS_EMPTY => trans('api_response.FUND_WALLET_ITEMS_EMPTY'),
//         FUND_WALLET_ITEMS_SUCCESS => trans('api_response.FUND_WALLET_ITEMS_SUCCESS'),
//         CHECKOUT_LIST_EMPTY => trans('api_response.CHECKOUT_LIST_EMPTY'),
//         GET_CHECKOUT_LIST_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_LIST_SUCCESS_CODE'),
//         CHECKOUT_SHOW_EMPTY => trans('api_response.CHECKOUT_SHOW_EMPTY'),
//         GET_CHECKOUT_SHOW_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_SHOW_SUCCESS_CODE'),
//         CHECKOUT_CARD_COUNTRIES_EMPTY => trans('api_response.CHECKOUT_CARD_COUNTRIES_EMPTY'),
//         GET_CHECKOUT_CARD_COUNTRIES_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_CARD_COUNTRIES_SUCCESS_CODE'),
//         GET_CHECKOUT_ITEMS_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_ITEMS_SUCCESS_CODE'),
//         CHECKOUT_ITEMS_EMPTY => trans('api_response.CHECKOUT_ITEMS_EMPTY'),
//         CHECKOUT_ITEM_WALLET_PRICE_EMPTY => trans('api_response.CHECKOUT_ITEM_WALLET_PRICE_EMPTY'),
//         GET_CHECKOUT_ITEM_WALLET_PRICE_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_ITEM_WALLET_PRICE_SUCCESS_CODE'),
//         CHECKOUT_ITEM_PAYMENT_CHANNEL_PRICE_EMPTY => trans('api_response.CHECKOUT_ITEM_PAYMENT_CHANNEL_PRICE_EMPTY'),
//         GET_CHECKOUT_ITEM_PAYMENT_CHANNEL_PRICE_SUCCESS_CODE => trans('api_response.GET_CHECKOUT_ITEM_PAYMENT_CHANNEL_PRICE_SUCCESS_CODE'),
//         CHECKOUT_ITEMS_STOCK_SOURCE_EMPTY => trans('api_response.CHECKOUT_ITEMS_STOCK_SOURCE_EMPTY'),
//         PHONE_REQUIRED => trans('api_response.PHONE_REQUIRED'),
//         GATEWAY_ID_EXISTS => trans('api_response.GATEWAY_ID_EXISTS'),
//         PHONE_SUCCESS_CODE => trans('api_response.PHONE_SUCCESS_CODE'),
//         PHONE_NOT_AVAILABLE => trans('api_response.PHONE_NOT_AVAILABLE'),
//         DAILY_LIMIT_REACHED => trans('api_response.DAILY_LIMIT_REACHED'),
//         OTP_REQUIRED => trans('api_response.OTP_REQUIRED'),
//         OTP_SUCCESS_CODE => trans('api_response.OTP_SUCCESS_CODE'),
//         VOUCHER_ERROR => trans('api_response.VOUCHER_ERROR'),
//         NOT_INCLUDED_IN_THE_ZAIN_SERVICE => trans('api_response.NOT_INCLUDED_IN_THE_ZAIN_SERVICE'),
//         CHARGE_RESP => trans('api_response.CHARGE_RESP'),
//         OTP_NOT_AVAILABLE => trans('api_response.OTP_NOT_AVAILABLE'),
//         ACCOUNT_ERROR => trans('api_response.ACCOUNT_ERROR'),
//         WALLET_SUCCESS_TOPUPED => trans('api_response.WALLET_SUCCESS_TOPUPED'),
//         WALLET_FAILED_TOPUPED => trans('api_response.WALLET_FAILED_TOPUPED'),
//         VOUCHER_SUCCESS => trans('api_response.VOUCHER_SUCCESS'),
//         SOME_ERROR_HAPPEN_IN_TOPUPED_ACCOUNT => trans('api_response.SOME_ERROR_HAPPEN_IN_TOPUPED_ACCOUNT'),
//         SOME_ERROR_HAPPEN_IN_VOUCHER => trans('api_response.SOME_ERROR_HAPPEN_IN_VOUCHER'),
//         BALANCE_ERROR_CODE => trans('api_response.BALANCE_ERROR_CODE'),
//         WALLET_NOT_ACTIVE_NOW_CODE => trans('api_response.WALLET_NOT_ACTIVE_NOW_CODE'),
//         ALREADY_REQUIRED => trans('api_response.ALREADY_REQUIRED'),
//         VOUCHER_PROCCESS => trans('api_response.VOUCHER_PROCCESS'),
//         GOLD_NOT_ENOUGH => trans('api_response.GOLD_NOT_ENOUGH'),
//         CHECKOUT_ID_SUCCESS => trans('api_response.CHECKOUT_ID_SUCCESS'),
//         USER_VISA_BLOCKED => trans('api_response.USER_VISA_BLOCKED'),
//         ERROR_VISA_CODE => trans('api_response.ERROR_VISA_CODE'),
//         VISA_VOUCHER_SUCCESS => trans('api_response.VISA_VOUCHER_SUCCESS'),
//         VISA_TOPUP_SUCCESS => trans('api_response.VISA_TOPUP_SUCCESS'),
//         ACCOUNT_TOPUP_FAILED => trans('api_response.ACCOUNT_TOPUP_FAILED'),
//         NOTIFICATION_SUCCESS_CODE => trans('api_response.NOTIFICATION_SUCCESS_CODE'),
//         NOTIFICATION_USER_EMPTY => trans('api_response.NOTIFICATION_USER_EMPTY'),

//         HOME_EMPTY => trans('api_response.HOME_EMPTY'),
//         GET_HOME_SUCCESS_CODE => trans('api_response.GET_HOME_SUCCESS_CODE'),
//         USER_NOT_FOUND => trans('api_response.USER_NOT_FOUND'),
//         UPDATE_ENABLE_NOTIFICATION_SUCCESS_CODE => trans('api_response.UPDATE_ENABLE_NOTIFICATION_SUCCESS_CODE'),
//         TRANSACTION_ZAIN_CACH_FAILED => trans('api_response.TRANSACTION_ZAIN_CACH_FAILED'),
//         CHECKED_TRANSACTION_ID_PANDEING => trans('api_response.CHECKED_TRANSACTION_ID_PANDEING'),
//         TRANSACTION_ID_NOT_FOUND => trans('api_response.TRANSACTION_ID_NOT_FOUND'),
//         PHONE_ZAIN_CASH_IS_FOUND => trans('api_response.PHONE_ZAIN_CASH_IS_FOUND'),
//         ZAIN_CASH_PROBLEM => trans('api_response.ZAIN_CASH_PROBLEM'),
//         LIST_NOTIFICATIONS_SUCCESS_CODE => trans('api_response.LIST_NOTIFICATIONS_SUCCESS_CODE'),
//         LAST_SALES_EMPTY => trans('api_response.LAST_SALES_EMPTY'),
//         LAST_SALES_SUCCESS_CODE => trans('api_response.LAST_SALES_SUCCESS_CODE'),

//         CART_SUCCESS_CODE => trans('api_response.CART_SUCCESS_CODE'),
//         CART_DELETED_SUCCESS_CODE => trans('api_response.CART_DELETED_SUCCESS_CODE'),


//         OTP_REQUIRED => trans('api_response.OTP_REQUIRED'),
//         OTP_INVALID_CODE => trans('api_response.OTP_INVALID_CODE'),
//         CHECK_OTP_CODE => trans('api_response.CHECK_OTP_CODE'),
//         ADD_CART_ERROR_CODE => trans('api_response.ADD_CART_ERROR_CODE'),
//         ADD_CART_SUCCESS_CODE => trans('api_response.ADD_CART_SUCCESS_CODE'),
//         UPDATE_CART_SUCCESS_CODE => trans('api_response.UPDATE_CART_SUCCESS_CODE'),
//         UPDATE_CART_ERROR_CODE =>  trans('api_response.UPDATE_CART_ERROR_CODE'),
//         REMOVE_CART_SUCCESS_CODE => trans('api_response.REMOVE_CART_SUCCESS_CODE'),
//         REMOVE_CART_ERROR_CODE =>  trans('api_response.REMOVE_CART_ERROR_CODE'),
//         VIEW_CART_SUCCESS_CODE =>  trans('api_response.VIEW_CART_SUCCESS_CODE'),
//         VIEW_CART_EMPTY_CODE =>   trans('api_response.VIEW_CART_EMPTY_CODE'),
//         PAYMENT_METHOD_CART_SUCCESS_CODE => trans('api_response.PAYMENT_METHOD_CART_SUCCESS_CODE'),
//         PAYMENT_METHOD_CART_ERROR_CODE   => trans('api_response.PAYMENT_METHOD_CART_ERROR_CODE'),
//         NO_CHANEL_GATEWAY_SUCCESS_CODE  =>  trans('api_response.NO_CHANEL_GATEWAY_SUCCESS_CODE'),
//         Validation_Fails_SUCCESS_CODE   =>  trans('api_response.Validation_Fails_SUCCESS_CODE'),
//         BLOCK_ACCOUNT_CODE => trans('api_response.BLOCK_ACCOUNT_CODE'),
//         GATEWAY_NOT_ACTIVE_CODE => trans('api_response.GATEWAY_NOT_ACTIVE_CODE'),
//         Check_Available_SUCCESS_CODE => trans('api_response.Check_Available_SUCCESS_CODE'),
//         WALLET_CART_SUCCESS_CODE => trans('api_response.WALLET_CART_SUCCESS_CODE'),
//         NO_BLALNCE_CODE => trans('api_response.NO_BLALNCE_CODE'),
//         CART_VOUCHER_ERROR_CODE => trans('api_response.CART_VOUCHER_ERROR_CODE'),
//         WALLET_NOT_ACTIVE_CODE => trans('api_response.WALLET_NOT_ACTIVE_CODE'),
//         DAILY_LIMIT_CODE => trans('api_response.DAILY_LIMIT_CODE'),
//         ITEM_NOT_FOUND_CODE => trans('api_response.ITEM_NOT_FOUND_CODE'),
//         ERROR_SUCCESS_CODE => trans('api_response.ERROR_SUCCESS_CODE'),
//         GATEWAY_NOT_FOUND_CODE => trans('api_response.GATEWAY_NOT_FOUND_CODE'),
//         INVALID_REQUEST_CODE => trans('api_response.INVALID_REQUEST_CODE'),


//         VOUCHER_CART_SUCCESS_CODE => trans('api_response.VOUCHER_CART_SUCCESS_CODE'),
//         OTP_NOT_AVAILABLE_CODE => trans('api_response.OTP_NOT_AVAILABLE_CODE'),
//         WALLET_FAILED_CODE => trans('api_response.WALLET_FAILED_CODE'),
//         INVALID_ACCOUNT_CODE => trans('api_response.INVALID_ACCOUNT_CODE'),
//         GET_CART_VOUCHER_SUCCESS_CODE => trans('api_response.GET_CART_VOUCHER_SUCCESS_CODE'),
//         GET_CART_VOUCHER_FAILED_CODE => trans('api_response.GET_CART_VOUCHER_FAILED_CODE'),



//         GROUP_ID_REQUIRED => trans('api_response.GROUP_ID_REQUIRED'),
//         GROUP_ID_EXISTS => trans('api_response.GROUP_ID_EXISTS'),
//         PAYMENT_CHANNEL_ID_REQUIRED => trans('api_response.PAYMENT_CHANNEL_ID_REQUIRED'),
//         PAYMENT_CHANNEL_ID_EXISTS => trans('api_response.PAYMENT_CHANNEL_ID_EXISTS'),
//         SERVER_ERROR_ADD_TO_CART_FAILED_CALCULAT => trans('api_response.SERVER_ERROR_ADD_TO_CART_FAILED_CALCULAT'),
//         CART_CHECKAVILBLE_SUCCESS_CODE => trans('api_response.CART_CHECKAVILBLE_SUCCESS_CODE'),
//         ITEM_ADDED_TO_CART_SUCCESS=> trans('api_response.ITEM_ADDED_TO_CART_SUCCESS'),
//         ITEM_ADDED_TO_CART_SUCCESS=> trans('api_response.ITEM_ADDED_TO_CART_SUCCESS'),
//         TRANSACTION_SUCCESS => trans('api_response.TRANSACTION_SUCCESS'),
//         ZAINCASH_TRANSACTION_SUCCESS=>trans('api_response.ZAINCASH_TRANSACTION_SUCCESS'),
//         VOUCHER_HISTORY_PROMPT=>trans('api_response.VOUCHER_HISTORY_PROMPT'),
//         SUCCESS_COMPLETED_PROCESS=>trans('api_response.SUCCESS_COMPLETED_PROCESS'),
//     ];
//     return ($responseCode == ALL_MESSAGE_CODE) ? $statusTexts : $statusTexts[$responseCode] ?? MESSAGE_NOT_FOUND_CODE;
// }


 

function responseGlobal($data, $statusCode)
{
    return (new ApiResponse())->responseGlobal($data, $statusCode);
}

function responseSuccess($data, $responseMessage, $responseCode)
{
    return (new ApiResponse())->responseSuccess($data, $responseMessage, $responseCode);
}

function responseError($message, $statusCode, $code)
{
    return (new ApiResponse())->responseError($message, $statusCode, $code);
}
function responseValidator($message, $statusCode, $code, $validate_errors)
{
    return (new ApiResponse())->responseValidator($message, $statusCode, $code, $validate_errors);
}

function respondUnauthorized($message)
{
    return (new ApiResponse())->respondUnauthorized($message);
}

function respondForbidden($message)
{
    return (new ApiResponse())->respondForbidden($message);
}

function respondNotFound($message)
{
    return (new ApiResponse())->respondNotFound($message);
}

function respondInternalError($message)
{
    return (new ApiResponse())->respondInternalError($message);
}

function respondUnprocessableEntity($message)
{
    return (new ApiResponse())->respondUnprocessableEntity($message);
}

function respondMethodAllowed($message)
{
    return (new ApiResponse())->respondMethodAllowed($message);
}

function respondModelNotFound($message)
{
    return (new ApiResponse())->respondModelNotFound($message);
}

function respondValidationFailed($message, $validate_errors, $codes)
{
    return (new ApiResponse())->respondValidationFailed($message, $validate_errors, $codes);
}

function respondPrivateKey($message)
{
    return (new ApiResponse())->respondPrivateKey($message);
}

function respondEmpty($message, $code)
{
    return (new ApiResponse())->respondEmpty($message, $code);
}
function respondTooManyRequest($message)
{
    return (new ApiResponse())->respondTooManyRequest($message);
}

function respondInvalidArgument($message)
{
    return (new ApiResponse())->respondInvalidArgument($message);
}

function respondInsufficientBalance($message)
{
    return (new ApiResponse())->respondInsufficientBalance($message);
}
 

if (!function_exists("logInfo")) {

    function logInfo($action, array $data = [], $logName = null)
    {           
        $action = is_string($action) ? $action : '';
 
        $confLog = ["data" => $data];

        LogsService::logsCart($action, $confLog, $logName);
    }
}
