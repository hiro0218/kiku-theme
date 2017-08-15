<?php

class Share {
    public $display = [
        'twitter' => false,
        'facebook' => false,
        'hatena' => false,
        'line' => false
    ];
    public $meta;

    function __construct() {
        global $Entry;
        $this->meta = $Entry->get_meta();

        $this->is_display();
        $this->render();
    }

    public function render() {
        if ($this->display['hatena']) {
            wp_enqueue_script('bookmark_button', "https://cdn-ak.b.st-hatena.com/js/bookmark_button.js", [], null, true);
        }

        if ($this->display['twitter'] || $this->display['facebook'] || $this->display['line']) {
            add_action('wp_footer', [$this, 'render_script_windowOpener'], 100);
        }
    }

    public function render_script_windowOpener() {
        echo <<< EOM
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
    }

    private function is_display() {
        $this->display = [
            'twitter' => (boolean) get_option('kiku_share_btn_twitter'),
            'facebook' => (boolean) get_option('kiku_share_btn_facebook'),
            'hatena' => (boolean) get_option('kiku_share_btn_hatena'),
            'line' => (boolean) get_option('kiku_share_btn_line'),
        ];
    }

}
