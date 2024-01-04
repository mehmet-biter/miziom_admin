<?php

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

function checkRolePermission($role_task, $my_role)
{
    if(Auth::user()->role_module == ROLE_SUPER_ADMIN)
    return 1;
    $role = Role::findOrFail($my_role);
    if (isset($role) && !empty($role->permissions)) {
        $tasks = $role->permissions;
        if (isset($tasks[0])) {
            if (in_array($role_task, $tasks)) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    return 0;
}


// role action list
const USER_LIST = 1;
const USER_CREATE = 2;
const USER_EDIT = 3;
const USER_DESTROY = 4;
const USER_PREVIEW = 5;
const USER_STORE = 6;

const ADMIN_LIST = 11;
const ADMIN_CREATE = 12;
const ADMIN_EDIT = 13;
const ADMIN_DESTROY = 14;
const ADMIN_PREVIEW = 15;
const ADMIN_STORE = 16;

const ROLE_LIST = 21;
const ROLE_CREATE = 22;
const ROLE_EDIT = 23;
const ROLE_DESTROY = 24;
const ROLE_PREVIEW = 25;
const ROLE_STORE = 26;

const COIN_LIST = 31;
const COIN_CREATE = 32;
const COIN_EDIT = 33;
const COIN_DESTROY = 34;
const COIN_PREVIEW = 35;
const COIN_STORE = 36;
const COIN_UPDATE = 37;
const COIN_STATUS_UPDATE = 38;
const COIN_SETTING = 41;
const COIN_SETTING_UPDATE = 42;
const COIN_API_SETTING = 43;
const BITGO_WEBHOOK = 44;
const BITGO_ADJUST = 45;
const BITGO_SETTING = 46;
const BITGO_SETTING_UPDATE = 46;
const COIN_PAYMENT_SETTING = 47;
const COIN_PAYMENT_UPDATE = 48;

const CURRENCY_LIST = 51;
const CURRENCY_CREATE = 52;
const CURRENCY_EDIT = 53;
const CURRENCY_DESTROY = 54;
const CURRENCY_PREVIEW = 55;
const CURRENCY_STORE = 56;
const CURRENCY_ALL = 57;
const CURRENCY_STATUS_UPDATE = 58;

const WITHDRAWAL_ACTIVE_LIST = 61;
const WITHDRAWAL_PENDING_LIST = 62;
const WITHDRAWAL_REJECT_LIST = 63;
const WITHDRAWAL_REJECT_PROCESS = 64;
const WITHDRAWAL_ACCEPT_PROCESS = 65;

// const DEPOSIT_PENDING_LIST = 71;
const DEPOSIT_ACTIVE_LIST = 72;

const FAQ_LIST = 81;
const FAQ_CREATE = 82;
const FAQ_EDIT = 83;
const FAQ_DESTROY = 84;
const FAQ_PREVIEW = 85;
const FAQ_STORE = 86;

const ADMIN_LOGS = 100;
const GENERAL_SETTING = 101;
const UPDATE_SETTING = 105;
const LANDING_SETTING = 102;
const EMAIL_SETTING = 103;
const LOGO_SETTING = 104;


function roleActionArray($input = null){
    $list = array(
        array("name"=>"Admin List View","code"=>ADMIN_LIST,"group" =>"Admin","route" => "adminList","url" =>"admin/list"),
        array("name"=>"Admin Create View","code"=>ADMIN_CREATE,"group" =>"Admin","route" => "adminAdd","url" =>"admin/add"),
        array("name"=>"Admin Update","code"=>ADMIN_EDIT,"group" =>"Admin","route" => "adminEdit","url" =>"admin/edit"),
        array("name"=>"Admin Delete","code"=>ADMIN_DESTROY,"group" =>"Admin","route" => "adminDelete","url" =>"admin/delete"),
        array("name"=>"Admin Preview","code"=>ADMIN_PREVIEW,"group" =>"Admin","route" => "adminPreview","url" =>"admin/preview"),
        array("name"=>"Admin Store","code"=>ADMIN_STORE,"group" =>"Admin","route" => "adminStoreProcess","url" =>"admin/store"),

        array("name"=>"User List View","code"=>USER_LIST,"group" =>"User","route" => "userList","url" =>"admin/user/list"),
        array("name"=>"User Create View","code"=>USER_CREATE,"group" =>"User","route" => "userAdd","url" =>"admin/user/add"),
        array("name"=>"User Update","code"=>USER_EDIT,"group" =>"User","route" => "userEdit","url" =>"admin/user/edit"),
        array("name"=>"User Delete","code"=>USER_DESTROY,"group" =>"User","route" => "userDelete","url" =>"admin/user/delete"),
        array("name"=>"User Preview","code"=>USER_PREVIEW,"group" =>"User","route" => "userPreview","url" =>"admin/user/preview"),
        array("name"=>"User Store","code"=>USER_STORE,"group" =>"User","route" => "userStoreProcess","url" =>"admin/user/store"),

        array("name"=>"Role List View","code"=>ROLE_LIST,"group" =>"Role","route" => "roleList","url" =>"admin/role"),
        array("name"=>"Role Create View","code"=>ROLE_CREATE,"group" =>"Role","route" => "roleAdd","url" =>"admin/role/add"),
        array("name"=>"Role Update","code"=>ROLE_EDIT,"group" =>"Role","route" => "roleEdit","url" =>"admin/role/edit"),
        array("name"=>"Role Delete","code"=>ROLE_DESTROY,"group" =>"Role","route" => "roleDelete","url" =>"admin/role/delete"),
        array("name"=>"Role Preview","code"=>ROLE_PREVIEW,"group" =>"Role","route" => "rolePreview","url" =>"admin/role/preview"),
        array("name"=>"Role Store","code"=>ROLE_STORE,"group" =>"Role","route" => "roleStoreProcess","url" =>"admin/role/store"),

        array("name"=>"Coin List View","code"=>COIN_LIST,"group" =>"Coin","route" => "adminCoinList","url" =>"admin/coin-list"),
        array("name"=>"Coin Create View","code"=>COIN_CREATE,"group" =>"Coin","route" => "adminAddCoin","url" =>"admin/add-new-coin"),
        array("name"=>"Coin Edit","code"=>COIN_EDIT,"group" =>"Coin","route" => "adminCoinEdit","url" =>"admin/coin-edit"),
        array("name"=>"Coin Delete","code"=>COIN_DESTROY,"group" =>"Coin","route" => "adminCoinDelete","url" =>"admin/coin-delete"),
        array("name"=>"Coin Store","code"=>COIN_STORE,"group" =>"Coin","route" => "adminCoinSaveProcess","url" =>"admin/coin-save-process"),
        array("name"=>"Coin Status Update","code"=>COIN_STATUS_UPDATE,"group" =>"Coin","route" => "adminCoinStatus","url" =>"admin/change-coin-status"),
        array("name"=>"Coin Setting","code"=>COIN_SETTING,"group" =>"Coin Setting","route" => "adminCoinSettings","url" =>"admin/coin-settings"),
        array("name"=>"Coin Setting Update","code"=>COIN_SETTING_UPDATE,"group" =>"Coin Setting","route" => "adminSaveCoinSetting","url" =>"admin/save-coin-settings"),
        array("name"=>"Coin Api Setting","code"=>COIN_API_SETTING,"group" =>"Coin Setting","route" => "adminCoinApiSettings","url" =>"admin/api-settings"),
        array("name"=>"Bitgo Webhook","code"=>BITGO_WEBHOOK,"group" =>"Coin Setting","route" => "webhookSave","url" =>"admin/bitgo-webhook-save"),
        array("name"=>"Adjust Bitgo Wallet","code"=>BITGO_WEBHOOK,"group" =>"Coin Setting","route" => "adminAdjustBitgoWallet","url" =>"admin/adjust-bitgo-wallet"),
        
        array("name"=>"Currency List View","code"=>CURRENCY_LIST,"group" =>"Currency","route" => "adminCurrencyList","url" =>"admin/currency-list"),
        array("name"=>"Currency Create View","code"=>CURRENCY_CREATE,"group" =>"Currency","route" => "adminCurrencyAdd","url" =>"admin/currency-add"),
        array("name"=>"Currency Update","code"=>CURRENCY_EDIT,"group" =>"Currency","route" => "adminCurrencyEdit","url" =>"admin/currency-edit"),
        array("name"=>"Currency All","code"=>CURRENCY_ALL,"group" =>"Currency","route" => "adminAllCurrency","url" =>"admin/currency-all"),
        array("name"=>"Currency Status Update","code"=>CURRENCY_STATUS_UPDATE,"group" =>"Currency","route" => "adminCurrencyStatus","url" =>"admin/currency-status-change"),
        array("name"=>"Currency Store","code"=>CURRENCY_STORE,"group" =>"Currency","route" => "adminCurrencyStore","url" =>"admin/currency-save-process"),

        array("name"=>"Active Withdrawal","code"=>WITHDRAWAL_ACTIVE_LIST,"group" =>"Withdrawal","route" => "adminActiveWithdrawal","url" =>"admin/active-withdrawal"),
        array("name"=>"Pending Withdrawal","code"=>WITHDRAWAL_PENDING_LIST,"group" =>"Withdrawal","route" => "adminPendingWithdrawal","url" =>"admin/pending-withdrawal"),
        array("name"=>"Reject Withdrawal","code"=>WITHDRAWAL_REJECT_LIST,"group" =>"Withdrawal","route" => "adminRejectedWithdrawal","url" =>"admin/rejected-withdrawal"),
        array("name"=>"Withdrawal Reject Process","code"=>WITHDRAWAL_REJECT_PROCESS,"group" =>"Withdrawal","route" => "teamDelete","url" =>"admin/team/delete"),
        array("name"=>"Withdrawal Accept Process","code"=>WITHDRAWAL_ACCEPT_PROCESS,"group" =>"Withdrawal","route" => "teamPreview","url" =>"admin/team/preview"),
        
        array("name"=>"Deposit List","code"=>DEPOSIT_ACTIVE_LIST,"group" =>"Deposit","route" => "adminActiveDeposit","url" =>"admin/active-deposit"),

        array("name"=>"Faq List View","code"=>FAQ_LIST,"group" =>"Faq","route" => "faqList","url" =>"admin/faq"),
        array("name"=>"Faq Create View","code"=>FAQ_CREATE,"group" =>"Faq","route" => "faqAdd","url" =>"admin/faq/add"),
        array("name"=>"Faq Update","code"=>FAQ_EDIT,"group" =>"Faq","route" => "faqEdit","url" =>"admin/faq/edit"),
        array("name"=>"Faq Delete","code"=>FAQ_DESTROY,"group" =>"Faq","route" => "faqDelete","url" =>"admin/faq/delete"),
        array("name"=>"Faq Preview","code"=>FAQ_PREVIEW,"group" =>"Faq","route" => "faqPreview","url" =>"admin/faq/preview"),
        array("name"=>"Faq Store","code"=>FAQ_STORE,"group" =>"Faq","route" => "faqStoreProcess","url" =>"admin/faq/store"),

        array("name"=>"Admin Setting","code"=>GENERAL_SETTING,"group" =>"Setting","route" => "adminSetting","url" =>"admin/settings"),
        array("name"=>"Admin Setting Update","code"=>UPDATE_SETTING,"group" =>"Setting","route" => "updateGeneralSetting","url" =>"admin/update-generel-settings"),
        array("name"=>"Email Setting","code"=>EMAIL_SETTING,"group" =>"Setting","route" => "adminSaveEmailSettings","url" =>"admin/email-save-settings"),
        array("name"=>"Bitgo Setting","code"=>BITGO_SETTING,"group" =>"Setting","route" => "bitgoSetting","url" =>"admin/bitgo-setting"),
        array("name"=>"Bitgo Setting Update","code"=>BITGO_SETTING_UPDATE,"group" =>"Setting","route" => "adminSaveBitgoSettings","url" =>"admin/save-bitgo-settings"),
        array("name"=>"Coin Payment Setting","code"=>COIN_PAYMENT_SETTING,"group" =>"Setting","route" => "coinPaymentSetting","url" =>"admin/coin-payment-setting"),
        array("name"=>"Coin Payment Update","code"=>COIN_PAYMENT_UPDATE,"group" =>"Setting","route" => "adminSavePaymentSettings","url" =>"admin/save-payment-settings"),
        
        array("name"=>"Admin Logs","code"=>ADMIN_LOGS,"group" =>"Setting","route" => "adminLogs","url" =>"admin/logs"),

    );
    if($input != null){
        foreach($list as $item){
            if($item['code'] == $input){
                return $item;
            }
        }
    }
    return $list;
}