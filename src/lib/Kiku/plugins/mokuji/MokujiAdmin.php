<?php

namespace Kiku;

require_once KIKU_LIB_PATH . 'plugins/mokuji/MokujiBuilder.php';

class Mokuji_Admin {
    private $options;

    public function __construct() {
        $defaultOptions = [
            'position' => MKJ_POSITION_BEFORE_FIRST_HEADING,
            'start' => 1,
            'heading_text' => 'Contents',
            'auto_insert_post_types' => [],
        ];
        $this->options = $this->get_mokuji_option($defaultOptions);
    }

    private function get_mokuji_option($defaults) {
         $options = get_option('mokuji-options', $defaults);
         $options = wp_parse_args($options, $defaults);

         return $options;
    }

    public function add_admin_page() {
        add_theme_page(
            __('Mokuji', 'kiku'),  // page_title
            __('Mokuji', 'kiku'),  // menu_title
            'manage_options',      // capability
            'mokuji',              // menu_slug
            [$this, 'admin_options']
        );
    }

    public function admin_options() {
        require_once KIKU_LIB_PATH . 'plugins/mokuji/kiku-mokuji-admin-display.php';
    }

    public function save_admin_options() {
        if ( !current_user_can('manage_options') ){
            return false;
        }

        $this->options = array_merge($this->options, [
            'position'               => intval( filter_input(INPUT_POST, 'position') ),
            'heading_text'           => stripslashes( trim( filter_input(INPUT_POST, 'heading_text') ) ),
            'auto_insert_post_types' => (array) filter_input(INPUT_POST, 'auto_insert_post_types', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
        ]);

        return update_option('mokuji-options', $this->options);
    }

    public function the_content($content) {
        global $post;
        $post_type = get_post_type($post);

        if (!is_singular() || !in_array($post_type, $this->options['auto_insert_post_types'])) {
            return $content;
        }

        $heading_list = [];
        $Builder = new Mokuji_Builder($this->options);

        // headingタグを抽出
        $heading_list = $Builder->extract_headings($content);
        // headingタグが存在しない場合は非表示
        if (empty($heading_list)) {
            return $content;
        }

        // 目次のDOMを作成
        $mokuji_dom = $Builder->table_of_content($this->options['heading_text']);

        // 目次を埋め込む
        $content = $Builder->insert_mokuji_to_content($mokuji_dom, $heading_list, $heading_list, $content);

        return $content;
    }


}
