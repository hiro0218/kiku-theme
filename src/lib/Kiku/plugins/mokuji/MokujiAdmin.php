<?php

namespace Kiku;

require_once KIKU_LIB_PATH . 'plugins/mokuji/MokujiBuilder.php';

class Mokuji_Admin {
    private $options;
    private $exclude_post_types = ['attachment', 'revision', 'nav_menu_item', 'safecss', 'customize_changeset', 'custom_css', 'custom_js'];
    private $collision_collector = [];

    public function __construct() {
        $defaultOptions = [
            'position' => MKJ_POSITION_BEFORE_FIRST_HEADING,
            'start' => 1,
            'heading_text' => 'Contents',
            'auto_insert_post_types' => [],
            'show_heirarchy' => true,  // 階層構造
            'ordered_list' => true,
            'exclude' => '',
            'heading_levels' => [1, 2, 3, 4, 5, 6],
        ];
        $this->options = $this->get_mokuji_option($defaultOptions);
    }

    private function get_mokuji_option($defaults) {
         $options = get_option('mokuji-options', $defaults);
         $options = wp_parse_args( $options, $defaults );
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
            'start'                  => intval( filter_input(INPUT_POST, 'start') ),
            'heading_text'           => stripslashes( trim( filter_input(INPUT_POST, 'heading_text') ) ),
            'auto_insert_post_types' => (array) filter_input(INPUT_POST, 'auto_insert_post_types', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
            'show_heirarchy'         => (boolean) filter_input(INPUT_POST, 'show_heirarchy') ? true : false,
            'ordered_list'           => (boolean) filter_input(INPUT_POST, 'ordered_list') ? true : false,
            'exclude'                => stripslashes( trim( filter_input(INPUT_POST, 'exclude') ) ),
            'heading_levels'         => (array) filter_input(INPUT_POST, 'heading_levels', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
        ]);

        return update_option('mokuji-options', $this->options);
    }

    public function the_content($content) {
        if (is_feed()) {
            return false;
        }

        $heading_list = [];
        $add_id_heading_list = [];
        $Builder = new Mokuji_Builder($this->options);

        // 不適格な場合は、タグを取り除いてコンテンツを返す
        $has_mokuji_tag = strpos($content, MKJ_TAG);
        if (!$Builder->is_display_eligible($has_mokuji_tag)) {
            return $Builder->remove_tag_from_content($content);
        }

        // headingタグを抽出
        list($items, $heading_list, $add_id_heading_list) = $Builder->extract_headings($content);
        if (empty($items)) {
            return $content;
        }

        // 目次のDOMを作成
        $mokuji_dom = $Builder->table_of_content($this->options['heading_text'], $items);

        // 目次を埋め込む
        $content = $Builder->insert_mokuji_to_content($mokuji_dom, $heading_list, $add_id_heading_list, $content);

        return $content;
    }


}
