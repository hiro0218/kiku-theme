<?php
date_default_timezone_set(get_option('timezone_string'));

define('KIKU_LIB_PATH', realpath(__DIR__) .DIRECTORY_SEPARATOR);

// constant
require KIKU_LIB_PATH. 'constant.php';

// class
require KIKU_LIB_PATH. 'Util.php';
require KIKU_LIB_PATH. 'Entry.php';
require KIKU_LIB_PATH. 'Image.php';
$Entry = new Kiku\Entry();
$Image = new Kiku\Image();

// module
require KIKU_LIB_PATH. 'modules/admin.php';
require KIKU_LIB_PATH. 'modules/clean.php';
require KIKU_LIB_PATH. 'modules/post.php';
require KIKU_LIB_PATH. 'modules/disable.php';
require KIKU_LIB_PATH. 'modules/seo.php';
require KIKU_LIB_PATH. 'modules/widget.php';

// component
require KIKU_LIB_PATH. 'components/alert.php';
require KIKU_LIB_PATH. 'components/pager.php';
require KIKU_LIB_PATH. 'components/pagination.php';
require KIKU_LIB_PATH. 'components/share.php';

// plugin
require KIKU_LIB_PATH. 'plugins/mokuji/kiku-mokuji.php';
require KIKU_LIB_PATH. 'plugins/setting/kiku-setting.php';
require KIKU_LIB_PATH. 'plugins/soil/nice-search.php';

require KIKU_LIB_PATH. 'Amazon.php';
$Amazon = null;
if (is_admin()) {
    $accessKeyId = get_option('kiku_amazon_api_key');
    $secretKey = get_option('kiku_amazon_secret_key');
    $associateId = get_option('kiku_amazon_associate_tag');
    $Amazon = new Kiku_Amazon($accessKeyId, $secretKey, $associateId);
}
