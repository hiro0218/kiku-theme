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

    list($twitter_display, $facebook_display, $hatena_display, $line_display) = is_display();

    if ($twitter_display) {
        $tooltip_twitter = __('Share on Twitter.', 'kiku');
        $twitter = <<< EOM
<li>
    <a href="//twitter.com/share?url={$meta['url']}&text={$meta['title']}"
       class="btn-twitter"
       title="{$tooltip_twitter}"
       rel="nofollow"
       onclick="openWindow(this.href,640,300); return false;">twitter
    </a>
</li>
EOM;
    }

    if ($facebook_display) {
        $tooltip_facebook = __('Share on Facebook.', 'kiku');
        $facebook = <<< EOM
<li>
    <a href="//www.facebook.com/sharer/sharer.php?u={$meta['url']}"
       class="btn-facebook"
       title="{$tooltip_facebook}"
       rel="nofollow"
       onclick="openWindow(this.href); return false;">facebook
    </a>
</li>
EOM;
    }

    if ($hatena_display) {
        $tooltip_hatena = __('Share on Hatena.', 'kiku');
        $hatena = <<< EOM
<li>
    <a href="//b.hatena.ne.jp/entry/{$meta['url']}"
       class="hatena-bookmark-button btn-hatena"
       data-hatena-bookmark-title="{$meta['title']}"
       data-hatena-bookmark-layout="simple"
       title="{$tooltip_hatena}"
       rel="nofollow">hatena
    </a>
</li>
EOM;
    }

    if ($line_display) {
        $lang = get_locale();
        $line = <<< EOM
<li>
    <div class="line-it-button" style="display: none;" data-type="share-d" data-lang="{$lang}"></div>
</li>
EOM;
    }

    if ($twitter_display || $facebook_display || $hatena_display || $line_display) {
        echo '<ul class="entry-share">';
        echo $twitter;
        echo $facebook;
        echo $hatena;
        echo $line;
        echo '</ul>';

        echo get_share_script($twitter_display, $facebook_display, $hatena_display ,$line_display);
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

function get_share_script($twitter_display, $facebook_display, $hatena_display ,$line_display) {
    $hatena = '';
    $line = '';
    $script = '';

    if ($hatena_display) {
        $hatena = <<< EOM
<script src="//b.st-hatena.com/js/bookmark_button.js" defer="defer" async="async"></script>
EOM;
    }

    if ($line_display) {
        $line = <<< EOM
<script src="//scdn.line-apps.com/n/line_it/thirdparty/loader.min.js" async="async" defer="defer"></script>
EOM;
    }

    if ($twitter_display || $facebook_display) {
        $script = <<< EOM
<script>
function openWindow(href, w, h) {
    var w = (w) ? w : 480,
    h = (h) ? h : 450,
    x = (screen.width/2) - (w/2),
    y = (screen.height/2) - (h/2);
    var features = "width="+ w +",height="+ h +",top="+ y +",left="+ x +",menubar=0,toolbar=0,directories=0,toolbar=0,status=0,resizable=0";

    window.open(href, '', features);
    return false;
}
</script>
EOM;
    }

    return $hatena . $line . $script;
}
