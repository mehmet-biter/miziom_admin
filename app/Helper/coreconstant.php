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

// user role
const ROLE_SUPER_ADMIN=1;
const ROLE_ADMIN=2;

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