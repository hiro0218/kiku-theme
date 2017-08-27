<?php
namespace Kiku;

$timezone_string = get_option('timezone_string');
if ($timezone_string) {
    date_default_timezone_set($timezone_string);
}

define('KIKU_LIB_PATH', realpath(__DIR__) .DIRECTORY_SEPARATOR);

// constant
require KIKU_LIB_PATH. 'config/constant.php';

// class
require KIKU_LIB_PATH. 'Util.php';
require KIKU_LIB_PATH. 'Entry.php';
require KIKU_LIB_PATH. 'Image.php';
require KIKU_LIB_PATH. 'RestApi.php';
require KIKU_LIB_PATH. 'structured-data/Schema.php';
$Entry = new Entry();
$Image = new Image();

// module
require KIKU_LIB_PATH. 'modules/admin.php';
require KIKU_LIB_PATH. 'modules/clean.php';
require KIKU_LIB_PATH. 'modules/DB.php';
require KIKU_LIB_PATH. 'modules/OpenGraph.php';
require KIKU_LIB_PATH. 'modules/Posts.php';
require KIKU_LIB_PATH. 'modules/SEO.php';
require KIKU_LIB_PATH. 'modules/Share.php';
require KIKU_LIB_PATH. 'modules/Widget.php';

// plugin
require KIKU_LIB_PATH. 'plugins/amazon/Amazon.php';
require KIKU_LIB_PATH. 'plugins/mokuji/Mokuji.php';
require KIKU_LIB_PATH. 'plugins/setting/kiku-setting.php';

// vendor
require KIKU_LIB_PATH. '../Sage/Soil/nice-search.php';
require KIKU_LIB_PATH. '../Sage/Soil/nav-walker.php';
