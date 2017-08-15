<?php
namespace Kiku;

$timezone_string = get_option('timezone_string');
if ($timezone_string) {
    date_default_timezone_set($timezone_string);
}

define('KIKU_LIB_PATH', realpath(__DIR__) .DIRECTORY_SEPARATOR);

// constant
require KIKU_LIB_PATH. 'constant.php';

// class
require KIKU_LIB_PATH. 'Util.php';
require KIKU_LIB_PATH. 'Entry.php';
require KIKU_LIB_PATH. 'Image.php';
require KIKU_LIB_PATH. 'DB.php';
require KIKU_LIB_PATH. 'Amazon.php';
require KIKU_LIB_PATH. 'papapi.php';
require KIKU_LIB_PATH. 'Opengraph.php';
require KIKU_LIB_PATH. 'Share.php';
require KIKU_LIB_PATH. 'structured-data/Schema.php';
$Entry = new Entry();
$Image = new Image();
$Schema = new \Schema();

// module
require KIKU_LIB_PATH. 'modules/admin.php';
require KIKU_LIB_PATH. 'modules/clean.php';
require KIKU_LIB_PATH. 'modules/post.php';
require KIKU_LIB_PATH. 'modules/disable.php';
require KIKU_LIB_PATH. 'modules/seo.php';
require KIKU_LIB_PATH. 'modules/search.php';
require KIKU_LIB_PATH. 'modules/widget.php';

// component
require KIKU_LIB_PATH. 'components/alert.php';

// api
require KIKU_LIB_PATH. 'api/posts.php';

// plugin
require KIKU_LIB_PATH . 'plugins/mokuji/Mokuji.php';
$Mokuji = new Mokuji();
require KIKU_LIB_PATH. 'plugins/setting/kiku-setting.php';

require KIKU_LIB_PATH. '../Sage/Soil/nice-search.php';
require KIKU_LIB_PATH. '../Sage/Soil/nav-walker.php';

$Aapapi = null;
if (is_admin()) {
    $access_key = get_option('kiku_amazon_api_key');
    $secret_key = get_option('kiku_amazon_secret_key');
    $associate_id = get_option('kiku_amazon_associate_tag');

    $Aapapi = new \Aapapi\Aapapi($access_key, $secret_key, $associate_id);
}
