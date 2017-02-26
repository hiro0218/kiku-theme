<?php
namespace Kiku\Components;

use AvpLab\PhpHtmlBuilder;

function the_share() {
    if ( !is_singular() ) {
        return;
    }

    global $Entry;
    $meta = $Entry->get_meta();

    $twitter = '';
    $facebook = '';
    $hatena = '';
    $line = '';

    list($is_twitter, $is_facebook, $is_hatena, $is_line) = is_display();

    if ($is_twitter) {
        $builder = new PhpHtmlBuilder();
        $twitter = $builder->a('twitter')
                                ->setHref('javascript:void(0)')
                                ->setClass('btn-twitter')
                                ->setTitle(__('Share on Twitter.', 'kiku'))
                                ->setOnclick("openWindow('//twitter.com/share?url={$meta['url']}&text={$meta['title']}',620,310); return false;")
                            ->end();
        $builder = null;
    }

    if ($is_facebook) {
        $builder = new PhpHtmlBuilder();
        $facebook = $builder->a('facebook')
                                ->setHref('javascript:void(0)')
                                ->setClass('btn-facebook')
                                ->setTitle(__('Share on Facebook.', 'kiku'))
                                ->setOnclick("openWindow('//www.facebook.com/sharer/sharer.php?u={$meta['url']}', 560,550); return false;")
                            ->end();
        $builder = null;
    }

    if ($is_hatena) {
        $builder = new PhpHtmlBuilder();
        $hatena = $builder->a('hatena')
                            ->setHref("//b.hatena.ne.jp/entry/{$meta['url']}")
                            ->setClass("hatena-bookmark-button btn-hatena")
                            ->setTitle(__('Share on Hatena.', 'kiku'))
                            ->setDataHatenaBookmarkTitle($meta['title'])
                            ->setDataHatenaBookmarkLayout("simple")
                        ->end();
        $builder = null;
    }

    if ($is_line) {
        $builder = new PhpHtmlBuilder();
        $line = $builder->a('facebook')
                            ->setHref('javascript:void(0)')
                            ->setClass('btn-line')
                            ->setTitle(__('Share on LINE.', 'kiku'))
                            ->setOnclick("openWindow('//lineit.line.me/share/ui?url={$meta['url']}', 565,500); return false;")
                        ->end();
        $builder = null;
    }

    if ($is_twitter || $is_facebook || $is_hatena || $is_line) {
        $builder = new PhpHtmlBuilder();
        $builder = $builder->section()
                                ->div()->setClass('entry-share')
                                    ->prepend($twitter)
                                    ->prepend($facebook)
                                    ->prepend($hatena)
                                    ->prepend($line)
                                ->end()
                            ->end();
        echo $builder->build();
        $builder = null;

        if ($is_hatena) {
            wp_enqueue_script('bookmark_button', "//b.st-hatena.com/js/bookmark_button.js", [], null, true);
        }

        if ($is_twitter || $is_facebook || $is_line) {
            add_action('wp_footer', __NAMESPACE__ . '\\add_share_script', 100);
        }
    }

}

function is_display() {
    return [
        (boolean) get_option('kiku_share_btn_twitter'),
        (boolean) get_option('kiku_share_btn_facebook'),
        (boolean) get_option('kiku_share_btn_hatena'),
        (boolean) get_option('kiku_share_btn_line'),
    ];
}

function add_share_script() {
    $script = <<< EOM
<script>
function openWindow(href, width, height) {
    var w = (width)  ? width  : 480,
        h = (height) ? height : 450,
        x = (screen.width/2)  - (w/2),
        y = (screen.height/2) - (h/2);
    var features = "width="+ w +",height="+ h +",top="+ y +",left="+ x +",menubar=0,toolbar=0,directories=0,toolbar=0,status=0,resizable=0";

    window.open(href, '', features);
    return false;
}
</script>
EOM;
    $script .= PHP_EOL;

    echo $script;
}
