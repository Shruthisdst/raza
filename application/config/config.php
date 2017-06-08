<?php

define('BASE_URL', 'http://192.168.1.67/raza/');
define('PUBLIC_URL', BASE_URL . 'public/');
define('XML_SRC_URL', BASE_URL . 'md-src/xml/');
define('ARCHIVES_URL', PUBLIC_URL . 'Archives/');
define('LETTERS_URL', ARCHIVES_URL . 'Letters/');
define('ARTICLES_URL', ARCHIVES_URL . 'Articles/');
define('BOOKS_URL', ARCHIVES_URL . 'Books/');
define('PHOTO_URL', ARCHIVES_URL . 'Photographs/');
define('BROCHURES_URL', ARCHIVES_URL . 'Brochures/');
define('MISCELLANEOUS_URL', ARCHIVES_URL . 'Miscellaneous/');
define('UNSORTED_URL', ARCHIVES_URL . 'Unsorted/');
define('PHOTOGRAPHS_URL', ARCHIVES_URL . 'Photographs/');
define('DOWNLOAD_URL', PUBLIC_URL . 'Downloads/');
define('FLAT_URL', BASE_URL . 'application/views/flat/');
define('STOCK_IMAGE_URL', PUBLIC_URL . 'images/stock/');
define('RESOURCES_URL', PUBLIC_URL . 'Resources/');
define('JSON_PRECAST_URL', BASE_URL . 'json-precast/');

// Physical location of resources
define('PHY_BASE_URL', '/var/www/html/raza/');
define('PHY_PUBLIC_URL', PHY_BASE_URL . 'public/');
define('PHY_XML_SRC_URL', PHY_BASE_URL . 'md-src/xml/');
define('PHY_ARCHIVES_URL', PHY_PUBLIC_URL . 'Archives/');
define('PHY_LETTERS_URL', PHY_ARCHIVES_URL . 'Letters/');
define('PHY_ARTICLES_URL', PHY_ARCHIVES_URL . 'Articles/');
define('PHY_BOOKS_URL', PHY_ARCHIVES_URL . 'Books/');
define('PHY_PHOTO_URL', PHY_ARCHIVES_URL . 'Photographs/');
define('PHY_BROCHURES_URL', PHY_ARCHIVES_URL . 'Brochures/');
define('PHY_MISCELLANEOUS_URL', PHY_ARCHIVES_URL . 'Miscellaneous/');
define('PHY_UNSORTED_URL', PHY_ARCHIVES_URL . 'Unsorted/');
define('PHY_TXT_URL', PHY_ARCHIVES_URL . 'Text/');
define('PHY_DOWNLOAD_URL', PHY_PUBLIC_URL . 'Downloads/');
define('PHY_FLAT_URL', PHY_BASE_URL . 'application/views/flat/');
define('PHY_STOCK_IMAGE_URL', PHY_PUBLIC_URL . 'images/stock/');
define('PHY_RESOURCES_URL', PHY_PUBLIC_URL . 'Resources/');

define('DB_PREFIX', 'raza');
define('DB_HOST', 'localhost');

define('DB_NAME', 'archives');

define('razaARCHIVES_USER', 'root');
define('razaARCHIVES_PASSWORD', 'mysql');

// Git config
define('GIT_USER_NAME', 'shruthisdst');
define('GIT_PASSWORD', 'shruthitr14');
define('GIT_REPO', 'github.com/SrirangaDigital/raza.git');
define('GIT_REMOTE', 'https://' . GIT_USER_NAME . ':' . GIT_PASSWORD . '@' . GIT_REPO);
define('GIT_EMAIL', 'shruthitr.nayak@gmail.com');

?>
