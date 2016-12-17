<?php
namespace Kiku\Components;

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
        $tooltip_twitter = __('Share on Twitter.', 'kiku');
        $twitter = <<< EOM
<li>
    <a href="javascript:void(0)"
       class="btn-twitter"
       title="{$tooltip_twitter}"
       onclick="openWindow('//twitter.com/share?url={$meta['url']}&text={$meta['title']}',620,310); return false;">twitter
    </a>
</li>
EOM;
    }

    if ($is_facebook) {
        $tooltip_facebook = __('Share on Facebook.', 'kiku');
        $facebook = <<< EOM
<li>
    <a href="javascript:void(0)"
       class="btn-facebook"
       title="{$tooltip_facebook}"
       onclick="openWindow('//www.facebook.com/sharer/sharer.php?u={$meta['url']}', 560,550); return false;">facebook
    </a>
</li>
EOM;
    }

    if ($is_hatena) {
        $tooltip_hatena = __('Share on Hatena.', 'kiku');
        $hatena = <<< EOM
<li>
    <a href="//b.hatena.ne.jp/entry/{$meta['url']}"
       class="hatena-bookmark-button btn-hatena"
       data-hatena-bookmark-title="{$meta['title']}"
       data-hatena-bookmark-layout="simple"
       title="{$tooltip_hatena}">hatena
    </a>
</li>
EOM;
    }

    if ($is_line) {
        $tooltip_line = __('Share on LINE.', 'kiku');
        $line = <<< EOM
<li>
    <a href="javascript:void(0)"
       class="btn-line"
       title="{$tooltip_line}"
       onclick="openWindow('//lineit.line.me/share/ui?url={$meta['url']}', 565,500); return false;">LINE
    </a>
</li>
EOM;
    }

    if ($is_twitter || $is_facebook || $is_hatena || $is_line) {
        echo '<section>';
        echo '<ul class="entry-share">';
        echo $twitter;
        echo $facebook;
        echo $hatena;
        echo $line;
        echo '</ul>';
        echo '</section>';

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
