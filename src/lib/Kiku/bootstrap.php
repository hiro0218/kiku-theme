<?php
define('KIKU_LIB_PATH', realpath(__DIR__) .DIRECTORY_SEPARATOR);

// constant
require KIKU_LIB_PATH. 'constant.php';

// class
require KIKU_LIB_PATH. 'Util.php';
require KIKU_LIB_PATH. 'Entry.php';
$Entry = new Kiku\Entry();

// module
require KIKU_LIB_PATH. 'modules/admin.php';
require KIKU_LIB_PATH. 'modules/clean.php';
require KIKU_LIB_PATH. 'modules/post.php';
require KIKU_LIB_PATH. 'modules/disable.php';
require KIKU_LIB_PATH. 'modules/seo.php';

// component
require KIKU_LIB_PATH. 'components/pagination.php';
