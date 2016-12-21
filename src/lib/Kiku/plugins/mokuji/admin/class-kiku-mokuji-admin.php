<?php
// inspired by Table of Contents Plus
define('MKJ_POSITION_BEFORE_FIRST_HEADING', 1);
define('MKJ_POSITION_CONTENTS_TOP', 2);
define('MKJ_POSITION_CONTENTS_BOTTOM', 3);
define('MKJ_POSITION_AFTER_FIRST_HEADING', 4);
define('MKJ_TAG', '<!--MOKUJI-->');

class Kiku_Mokuji_Admin {
    private $message;
    private $options;
    private $show_mokuji = true;
    private $exclude_post_types = ['attachment', 'revision', 'nav_menu_item', 'safecss'];
    private $collision_collector = [];

    public function __construct() {
        $defaultOptions = [
            'position' => MKJ_POSITION_BEFORE_FIRST_HEADING,
            'start' => 1,
            'heading_text' => 'Contents',
            'auto_insert_post_types' => [],
            'show_heirarchy' => true,  // 階層構造
            'ordered_list' => true,
            'include_homepage' => false,
            'exclude' => '',
            'heading_levels' => [1, 2, 3, 4, 5, 6],
            'restrict_path' => '',
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

    public function admin_options(){
        require_once KIKU_LIB_PATH . 'plugins/mokuji/admin/partials/kiku-mokuji-admin-display.php';
    }

    public function save_admin_options() {
        if ( !current_user_can('manage_options') ){
            return false;
        }

        if ( $restrict_path = trim( filter_input(INPUT_POST, 'restrict_path') ) ) {
            if ( strpos( $restrict_path, '/' ) !== 0 ) {
                $restrict_path = '';
            }
        }

        $this->options = array_merge($this->options, [
            'position'               => intval( filter_input(INPUT_POST, 'position') ),
            'start'                  => intval( filter_input(INPUT_POST, 'start') ),
            'auto_insert_post_types' => (array) filter_input(INPUT_POST, 'auto_insert_post_types', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
            'heading_levels'         => (array) filter_input(INPUT_POST, 'heading_levels', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
            'show_heirarchy'         => (boolean) filter_input(INPUT_POST, 'show_heirarchy') ? true : false,
            'ordered_list'           => (boolean) filter_input(INPUT_POST, 'ordered_list') ? true : false,
            'heading_text'           => stripslashes( trim( filter_input(INPUT_POST, 'heading_text') ) ),
            'exclude'                => stripslashes( trim( filter_input(INPUT_POST, 'exclude') ) ),
            'restrict_path'          => $restrict_path,
        ]);

        return update_option( 'mokuji-options', $this->options );
    }

    /**
     * url_encode_wikipedia_taste
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    private function url_encode_wikipedia_taste($str) {
        return rawurlencode($str);
    }

    /**
     * replace_percent_to_dot
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    private function replace_percent_to_dot($str) {
        return str_replace('%', '.', $str);
    }

    /**
     * Returns a clean url to be used as the destination anchor target
     * @param  [type] $title [description]
     * @return [type]        [description]
     */
    private function url_anchor_target($title) {
        $return = '';

        $return = trim(strip_tags($title));

        // replace newlines with spaces (eg when headings are split over multiple lines)
        $return = str_replace(["\r", "\n", "\n\r", "\r\n"], ' ', $return);

        // remove &amp;
        $return = str_replace('&amp;', '', $return);

        // convert spaces to _
        $return = str_replace(['  ', ' '], '_', $return);

        // url encode for malutibyte
        $return = $this->url_encode_wikipedia_taste($return);
        $return = $this->replace_percent_to_dot($return);

        // remove trailing - and _
        $return = rtrim($return, '-_');

        if (array_key_exists($return, $this->collision_collector)) {
            $this->collision_collector[$return]++;
            $return .= '-' . $this->collision_collector[$return];
        } else {
            $this->collision_collector[$return] = 1;
        }

        return $return;
    }

    private function build_hierarchy($matches) {
        $current_depth = 20;
        $html = '';
        $numbered_items = [];
        $numbered_items_min = 0;
        $matches_cnt = count($matches);

        // reset the internal collision collection
        $this->collision_collector = [];

        // find the minimum heading to establish our baseline
        for ($i = 0; $i < $matches_cnt; $i++) {
            if ($current_depth > (int) $matches[$i][2]) {
                $current_depth = (int) $matches[$i][2];
            }
        }

        $numbered_items[$current_depth] = 0;
        $numbered_items_min = $current_depth;

        for ($i = 0; $i < $matches_cnt; $i++) {
            if ($current_depth == (int) $matches[$i][2]) {
                $html .= '<li>';
            }

            // start lists
            if ($current_depth != (int) $matches[$i][2]) {
                for ($current_depth; $current_depth < (int) $matches[$i][2]; $current_depth++) {
                    $numbered_items[$current_depth + 1] = 0;
                    $html .= '<ol>';
                    $html .= '<li>';
                }
            }

            // list item
            if (in_array($matches[$i][2], $this->options['heading_levels'])) {
                $html .= '<a href="#' . $this->url_anchor_target($matches[$i][0]) . '">';
                if ($this->options['ordered_list']) {
                    // attach leading numbers when lower in hierarchy
                    $html .= '<span class="mokuji_number mokuji_depth_' . ($current_depth - $numbered_items_min + 1) . '">';
                    for ($j = $numbered_items_min; $j < $current_depth; $j++) {
                        $number = ($numbered_items[$j]) ? $numbered_items[$j] : 0;
                        $html .= $number . '.';
                    }

                    $html .= ($numbered_items[$current_depth] + 1) . '</span> ';
                    $numbered_items[$current_depth] ++;
                }
                $html .= strip_tags($matches[$i][0]) . '</a>';
            }


            // end lists
            if ($i != ($matches_cnt - 1)) {
                if ($current_depth > (int) $matches[$i + 1][2]) {
                    for ($current_depth; $current_depth > (int) $matches[$i + 1][2]; $current_depth--) {
                        $html .= '</li></ol>';
                        $numbered_items[$current_depth] = 0;
                    }
                }

                if ($current_depth == (int) $matches[$i + 1][2]) {
                    $html .= '</li>';
                }
            } else {
                // this is the last item, make sure we close off all tags
                for ($current_depth; $current_depth >= $numbered_items_min; $current_depth--) {
                    $html .= '</li>';
                    if ($current_depth != $numbered_items_min) {
                        $html .= '</ol>';
                    }
                }
            }
        }

        return $html;
    }

    private function mb_find_replace($find = false, $replace = false, $string = '') {
        if (is_array($find) && is_array($replace) && $string) {
            $find_cnt = count($find);
            for ($i = 0; $i < $find_cnt; $i++) {
                $string = mb_substr($string, 0, mb_strpos($string, $find[$i])) . // everything befor $find
                $replace[$i] . // its replacement
                mb_substr($string, mb_strpos($string, $find[$i]) + mb_strlen($find[$i])); // everything after $find;
            }
        }

        return $string;
    }

    private function extract_headings($content = '') {
        $find = [];
        $replace = [];
        $matches = [];
        $anchor = '';
        $items = '';

        $this->collision_collector = [];

        if ($content) {
            // get all headings
            if (preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER)) {
                if (count($this->options['heading_levels']) != 6) {
                    $new_matches = [];
                    for ($i = 0; $i < count($matches); $i++) {
                        if (in_array($matches[$i][2], $this->options['heading_levels']))
                            $new_matches[] = $matches[$i];
                    }
                    $matches = $new_matches;
                }

                // remove specific headings if provided via the 'exclude' property
                if ($this->options['exclude']) {
                    $excluded_headings = explode('|', $this->options['exclude']);
                    if (count($excluded_headings) > 0) {
                        for ($j = 0; $j < count($excluded_headings); $j++) {
                            // escape some regular expression characters
                            // others: http://www.php.net/manual/en/regexp.reference.meta.php
                            $excluded_headings[$j] = str_replace(['*'], ['.*'], trim($excluded_headings[$j])
                            );
                        }

                        $new_matches = [];
                        for ($i = 0; $i < count($matches); $i++) {
                            $found = false;
                            for ($j = 0; $j < count($excluded_headings); $j++) {
                                if (preg_match('/^' . $excluded_headings[$j] . '$/imU', strip_tags($matches[$i][0]))) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $new_matches[] = $matches[$i];
                            }
                        }
                        if (count($matches) != count($new_matches)) {
                            $matches = $new_matches;
                        }
                    }
                }

                // remove empty headings
                $new_matches = [];
                for ($i = 0; $i < count($matches); $i++) {
                    if (trim(strip_tags($matches[$i][0])) != false) {
                        $new_matches[] = $matches[$i];
                    }
                }
                if (count($matches) != count($new_matches)) {
                    $matches = $new_matches;
                }

                // check minimum number of headings
                if (count($matches) >= $this->options['start']) {

                    for ($i = 0; $i < count($matches); $i++) {
                        // get anchor and add to find and replace arrays
                        $anchor = $this->url_anchor_target($matches[$i][0]);
                        $find[] = $matches[$i][0];

                        $replace[] = '<h' . $matches[$i][2] . ' id="' . $anchor . '">' . strip_tags($matches[$i][0]) . '</h' . $matches[$i][2] . '>';

                        // assemble flat list
                        if (!$this->options['show_heirarchy']) {
                            $items .= '<li><a href="#' . $anchor . '">';
                            if ($this->options['ordered_list']) {
                                $items .= count($replace) . ' ';
                            }
                            $items .= strip_tags($matches[$i][0]) . '</a></li>';
                        }
                    }

                    if ($this->options['show_heirarchy']) {
                        $items = $this->build_hierarchy($matches);
                    }
                }
            }
        }

        return [$items, $find, $replace];
    }

    private function is_show_page() {
        global $post;
        return in_array(get_post_type($post), $this->options['auto_insert_post_types']) && ($this->show_mokuji && is_singular());
    }

    // Returns true if the table of contents is eligible to be printed, false otherwise.
    private function is_eligible($shortcode_used = false) {
        // if the shortcode was used, this bypasses many of the global options
        if ($shortcode_used !== false) {
            return is_singular() ? true : false;
        } else {
            if ( !$this->is_show_page() ) {
                return false;
            }

            if ($this->options['restrict_path']) {
                return (strpos(filter_input(INPUT_SERVER, 'REQUEST_URI'), $this->options['restrict_path']) === 0);
            } else {
                return true;
            }

        }
    }

    public function get_table_of_content($items) {
        $html = '<nav>';
        $html .= '<div id="mokuji-container">';

        $mokuji_title = $this->options['heading_text'];
        if ($mokuji_title) {
            if (strpos($mokuji_title, '%PAGE_TITLE%') !== false) {
                $mokuji_title = str_replace('%PAGE_TITLE%', get_the_title(), $mokuji_title);
            }
            if (strpos($mokuji_title, '%PAGE_NAME%') !== false) {
                $mokuji_title = str_replace('%PAGE_NAME%', get_the_title(), $mokuji_title);
            }
            $html .= '<h2 class="mokuji-title">';
            $html .= esc_html($mokuji_title, ENT_COMPAT, 'UTF-8');
            $html .= '</h2>';
        }


        $html .= '<section class="mokuji-content">';
        $html .= '<ol class="mokuji-list">';
        $html .= $items;
        $html .= '</ol>';
        $html .= '</section>';

        $html .= '</div>';
        $html .= '</nav>';

        return $html;
    }

    public function the_content($content) {
        if ( is_feed() ) {
            return false;
        }

        $find = [];
        $replace = [];
        $custom_mokuji_pos = strpos($content, MKJ_TAG);

        if ( !$this->is_eligible($custom_mokuji_pos) ) {
            // remove MKJ_TAG from content
            return str_replace(MKJ_TAG, '', $content);
        }

        list($items, $find, $replace) = $this->extract_headings($content);
        if ($items) {
            $html = $this->get_table_of_content($items);

            // タグがない場合は指定の位置に埋め込む
            if ($custom_mokuji_pos !== false) {
                $find[] = MKJ_TAG;
                $replace[] = $html;
                $content = $this->mb_find_replace($find, $replace, $content);
            } else {
                if (count($find) > 0) {
                    switch ($this->options['position']) {
                        case MKJ_POSITION_CONTENTS_TOP:
                        $content = $html . $this->mb_find_replace($find, $replace, $content);
                        break;

                        case MKJ_POSITION_CONTENTS_BOTTOM:
                        $content = $this->mb_find_replace($find, $replace, $content) . $html;
                        break;

                        case MKJ_POSITION_AFTER_FIRST_HEADING:
                        $replace[0] = $replace[0] . $html;
                        $content = $this->mb_find_replace($find, $replace, $content);
                        break;

                        case MKJ_POSITION_BEFORE_FIRST_HEADING:
                        default:
                        $replace[0] = $html . $replace[0];
                        $content = $this->mb_find_replace($find, $replace, $content);
                        break;
                    }
                }
            }
        }

        return $content;
    }

}
