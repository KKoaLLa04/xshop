<?php

// SET time zone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// MODULE default & ACTION DEFAULT client
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'home';

// MODULE default & ACTION DEFAULT admin
const _MODULE_DEFAULT_ADMIN = 'products_category';
const _ACTION_DEFAULT_ADMIN = 'lists';

// thiet lap ROOT
define('_WEB_HOST_ROOT', 'http://localhost/kienndph39656_dam');
define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT . '/templates');

// Thiet lap Path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT . '/templates');

// Thiết lập số lượng bản ghi / 1 trang
const _PER_PAGE = 9;
