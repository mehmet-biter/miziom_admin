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


// network const
const POLYGON_NETWORK = 1;
const SOLANA_NETWORK = 2;
const BINANCE_MAINNET_NETWORK = 3;
const TRON_MAINNET_NETWORK = 4;
const ETHEREUM_MAINNET_NETWORK = 5;

// Artisan Type
const COMMAND_TYPE_CACHE = 1;
const COMMAND_TYPE_CONFIG = 2;
const COMMAND_TYPE_ROUTE = 3;
const COMMAND_TYPE_VIEW = 4;
const COMMAND_TYPE_MIGRATE = 5;
const COMMAND_TYPE_SCHEDULE_START = 6;

