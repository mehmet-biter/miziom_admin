<?php

// Status

const STATUS_ACTIVE = 1;
const STATUS_DEACTIVE = 0;

const STATUS_PENDING = 0;
const STATUS_ACCEPTED = 1;
const STATUS_REJECTED = 2;
const STATUS_SUCCESS = 1;
const STATUS_SUSPENDED = 4;
const STATUS_DELETED = 5;
const STATUS_ALL = 6;
const STATUS_FORCE_DELETED = 7;
const STATUS_USER_DEACTIVATE = 8;

const IMG_PATH = 'uploaded_file/uploads/';
const IMG_VIEW_PATH = 'uploaded_file/uploads/';
const IMG_OTHER_PATH = 'uploaded_file/others/';
const IMG_USER_PATH = 'uploaded_file/users/';
const IMG_ICON_PATH = 'uploaded_file/uploads/coin/';
const IMG_SLEEP_PATH = 'uploaded_file/sleep/';
const IMG_USER_VIEW_PATH = 'uploaded_file/users/';
const IMG_SLEEP_VIEW_PATH = 'uploaded_file/sleep/';
const IMG_USER_VERIFICATION_PATH = 'users/verifications/';

const CURRENCY_TYPE_CRYPTO = 1;
const CURRENCY_TYPE_FIAT = 2;
const CURRENCY_TYPE_BOTH = 3;

// user role
const ROLE_SUPER_ADMIN=1;
const ROLE_ADMIN=2;
const ROLE_USER=3;

const COIN_PAYMENT = 1;
const BITGO_API = 2;

//wallet types
const PERSONAL_WALLET = 1;
const CO_WALLET = 2;

const DISCOUNT_TYPE_FIXED = 1;
const DISCOUNT_TYPE_PERCENTAGE = 2;

const MODULE_SUPER_ADMIN = 1;
const MODULE_ADMIN = 2;
const MODULE_USER = 3;

const IMAGE_PATH = 'general/';
const IMAGE_PATH_USER = 'user/';
const IMAGE_SETTING_PATH = 'settings/';

const VIEW_IMAGE_PATH = '/storage/general/';
const VIEW_IMAGE_PATH_USER = '/storage/user/';
const VIEW_IMAGE_SETTING_PATH = '/storage/settings/';

const CODE_TYPE_EMAIL = 1;
const CODE_TYPE_PHONE = 2;

//webhook type
const WEBHOOK_TYPE_TRANSFER = 'transfer';
const WEBHOOK_TYPE_TRANSACTION = 'transaction';
const WEBHOOK_TYPE_PENDING_APPROVAL = 'pendingapproval';
const WEBHOOK_TYPE_ADDRESS_CONFIRM = 'address_confirmation';
const WEBHOOK_TYPE_LOW_FEE = 'lowFee';

const WITHDRAWAL_CURRENCY_TYPE_CRYPTO = 1;
const WITHDRAWAL_CURRENCY_TYPE_FIAT = 2;

const ADDRESS_TYPE_EXTERNAL = 1;
const ADDRESS_TYPE_INTERNAL = 2;

const TRANSACTION_TYPE_DEPOSIT = 1;
const TRANSACTION_TYPE_WITHDRAW = 2;

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

const DEPOSIT_PENDING_LIST = 71;
const DEPOSIT_ACTIVE_LIST = 72;

const ADMIN_LOGS = 100;
const GENERAL_SETTING = 101;
const LANDING_SETTING = 102;
const EMAIL_SETTING = 103;
const LOGO_SETTING = 104;
