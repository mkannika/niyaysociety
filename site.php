<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'hoodaakc_db');
define('DB_PASSWORD', 'mkannika13MKANwth');
define('DB_DATABASE', 'hoodaakc_db');

//White Labeling options
define('ENABLE_MARKETPLACE_SUPPORT', false);
define('ENABLE_INTELLIGENT_SEARCH_HELP', false);
define('ENABLE_INTELLIGENT_SEARCH_MARKETPLACE', false);
define('ENABLE_NEWSFLOW_OVERLAY', false);
define('ENABLE_AREA_LAYOUTS', false);
define('ENABLE_CUSTOM_DESIGN', false);
define('ENABLE_APP_NEWS', false);

//Disable Zend Cache Cleaning (may improve performance)
define('CACHE_FRONTEND_OPTIONS',serialize(array('automatic_cleaning_factor' => 0)));

//Change session time from default of 2 hours
define('SESSION_MAX_LIFETIME', 7200); //2 hours

// Email
define('EMAIL_DEFAULT_FROM_NAME', 'Niyaysociety อาณาจักรคนรักนิยาย');
define('EMAIL_DEFAULT_FROM_ADDRESS', 'webmaster@niyaysociety.com');
//Set registration email notification address
define('EMAIL_ADDRESS_REGISTER_NOTIFICATION', 'webmaster@niyaysociety.com');
//Set registration email notification from address
define('EMAIL_ADDRESS_REGISTER_NOTIFICATION_FROM', 'webmaster@niyaysociety.com');

//Set URL
define('BASE_URL', 'https://niyaysociety.com');