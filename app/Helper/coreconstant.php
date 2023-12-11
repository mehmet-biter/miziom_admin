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

// gender
const MALE=1;
const FEMALE=2;
const OTHER_GENDER=3;

const CODE_TYPE_EMAIL = 1;
const CODE_TYPE_PHONE = 2;

// route action list
const JOB_CATEGORY_LIST = 1;
const JOB_CATEGORY_CREATE = 2;
const JOB_CATEGORY_EDIT = 3;
const JOB_CATEGORY_DESTROY = 4;
const JOB_CATEGORY_PREVIEW = 5;
const JOB_CATEGORY_STORE = 6;

const JOB_POST_LIST = 11;
const JOB_POST_CREATE = 12;
const JOB_POST_EDIT = 13;
const JOB_POST_DESTROY = 14;
const JOB_POST_PREVIEW = 15;
const JOB_POST_STORE = 16;

const JOB_APPLICATION_LIST = 21;
const JOB_APPLICATION_EDIT = 23;
const JOB_APPLICATION_DESTROY = 24;
const JOB_APPLICATION_PREVIEW = 25;

const CONTACT_LIST = 31;
const CONTACT_DESTROY = 34;
const CONTACT_PREVIEW = 35;

const SERVICE_LIST = 41;
const SERVICE_CREATE = 42;
const SERVICE_EDIT = 43;
const SERVICE_DESTROY = 44;
const SERVICE_PREVIEW = 45;
const SERVICE_STORE = 46;

const TEAM_LIST = 51;
const TEAM_CREATE = 52;
const TEAM_EDIT = 53;
const TEAM_DESTROY = 54;
const TEAM_PREVIEW = 55;
const TEAM_STORE = 56;

const FAQ_LIST = 61;
const FAQ_CREATE = 62;
const FAQ_EDIT = 63;
const FAQ_DESTROY = 64;
const FAQ_PREVIEW = 65;
const FAQ_STORE = 66;

const USER_LIST = 71;
const USER_CREATE = 72;
const USER_EDIT = 73;
const USER_DESTROY = 74;
const USER_PREVIEW = 75;
const USER_STORE = 76;

const ROLE_LIST = 81;
const ROLE_CREATE = 82;
const ROLE_EDIT = 83;
const ROLE_DESTROY = 84;
const ROLE_PREVIEW = 85;
const ROLE_STORE = 86;

const SETTING_VIEW=100;
const SETTING_UPDATE=101;