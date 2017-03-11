<?php

namespace Kiku;

class Mokuji_Builder {
    private $options;
    private $collision_collector = [];

    public function __construct($options) {
        $this->options = $options;
    }

    private function url_encode_wikipedia_like($str) {
        return rawurlencode($str);
    }

    private function replace_percent_to_dot($str) {
        return str_replace('%', '.', $str);
    }

    private function url_anchor_target($title) {
        $return = trim(strip_tags($title));

        // replace newlines with spaces (eg when headings are split over multiple lines)
        $return = str_replace(["\r", "\n", "\n\r", "\r\n"], ' ', $return);

        // remove &amp;
        $return = str_replace('&amp;', '', $return);

        // convert spaces to _
        $return = str_replace(['  ', ' '], '_', $return);

        // url encode for multi-byte character
        $return = $this->url_encode_wikipedia_like($return);
        $return = $this->replace_percent_to_dot($return);

        // remove trailing - and _
        $return = rtrim($return, '-_');

        //
        if ($this->is_collision_heading($return)) {
            $this->collision_collector[$return]++;
            $return .= '-' . $this->collision_collector[$return];
        } else {
            $this->collision_collector[$return] = 1;
        }

        return $return;
    }

    private function is_collision_heading($heading) {
        return array_key_exists($heading, $this->collision_collector);
    }

    private function build_heading_hierarchy($matches) {
        $current_depth = 20;
        $html = '';
        $numbered_items = [];
        $numbered_items_min = 0;
        $matches_count = count($matches);

        // reset the internal collision collection
        $this->collision_collector = [];

        // find the minimum heading to establish our baseline
        for ($i = 0; $i < $matches_count; $i++) {
            if ($current_depth > (int) $matches[$i][2]) {
                $current_depth = (int) $matches[$i][2];
            }
        }

        $numbered_items[$current_depth] = 0;
        $numbered_items_min = $current_depth;

        for ($i = 0; $i < $matches_count; $i++) {
            $heading_level = (int) $matches[$i][2];

            if ($current_depth == $heading_level) {
                $html .= '<li>';
            }

            // start lists
            if ($current_depth != $heading_level) {
                for ($current_depth; $current_depth < $heading_level; $current_depth++) {
                    $numbered_items[$current_depth + 1] = 0;
                    $html .= '<ol>';
                    $html .= '<li>';
                }
            }

            // list item
            if (in_array($heading_level, $this->options['heading_levels'])) {
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
            if ($i != ($matches_count - 1)) {
                if ($current_depth > (int) $matches[$i + 1][2]) {
                    for ($current_depth; $current_depth > (int) $matches[$i + 1][2]; $current_depth--) {
                        $html .= '</li>';
                        $html .= '</ol>';
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

    public function extract_headings($content) {
        $find = [];
        $replace = [];
        $matches = [];
        $items = '';

        // コンテンツ内のすべてのheadingタグを取得
        preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER);

        // $matches
        // array (size=3)
        // 0 => string '<h2>見出し</h2>' (length=18)
        // 1 => string '<h2>' (length=4)
        // 2 => string '2' (length=1)

        if (empty($matches)) {
            return [$items, $find, $replace];
        }

        // remove undefined headings
        $matches = $this->remove_undefined_headings($matches);

        // remove specific headings if provided via the 'exclude' property
        $matches = $this->remove_exclude_specified_heading($matches);

        // remove empty headings
        $matches = $this->remove_empty_headings($matches);

        // check minimum number of headings
        $matches_cnt = count($matches);
        if ($matches_cnt >= $this->options['start']) {
            $heading_anhor_template = '<a href="#%s" class="anchor">#</a>';
            $heading_tag_template = '<h%s id="%s">%s</h%s>';

            // get anchor and add to find and replace arrays
            for ($i = 0; $i < $matches_cnt; $i++) {
                $heading = $matches[$i][0];
                $heading_text = strip_tags($heading);
                $anchor = $this->url_anchor_target($heading);
                $find[] = $heading;
                $heading_level = $matches[$i][2];

                // make tag
                $heading_anchor = sprintf($heading_anhor_template, $anchor);
                $replace[] = sprintf($heading_tag_template, $heading_level, $anchor, $heading_anchor.$heading_text, $heading_level);

                // assemble flat list
                if (!$this->options['show_heirarchy']) {
                    $items .= '<li>';
                    $items .= '<a href="#' . $anchor . '">';

                    if ($this->options['ordered_list']) {
                        $number = count($replace);
                        $items .= '<span class="mokuji_number mokuji_depth_' . $number . '">';
                        $items .= $number .'. ';
                        $items .= '</span>';
                    }

                    $items .= $heading_text . '</a></li>';
                }
            }

            if ($this->options['show_heirarchy']) {
                $items = $this->build_heading_hierarchy($matches);
            }
        }

        return [$items, $find, $replace];
    }

    public function remove_undefined_headings($matches) {
        if (count($this->options['heading_levels']) != 6) {
            $new_matches = [];
            $matches_count = count($matches);
            for ($i = 0; $i < $matches_count; $i++) {
                if (in_array($matches[$i][2], $this->options['heading_levels'])) {
                    $new_matches[] = $matches[$i];
                }
            }
            $matches = $new_matches;
        }
        return $matches;
    }

    public function remove_exclude_specified_heading($matches) {
        if ($this->options['exclude']) {
            $excluded_headings = explode('|', $this->options['exclude']);
            $excluded_count = count($excluded_headings);

            if ($excluded_count > 0) {
                $new_matches = [];
                $matches_cnt = count($matches);
                for ($i = 0; $i < $matches_cnt; $i++) {
                    $found = false;
                    for ($j = 0; $j < $excluded_count; $j++) {
                        $excluded_headings[$j] = str_replace(['*'], ['.*'], trim($excluded_headings[$j]));
                        if (preg_match('/^' . $excluded_headings[$j] . '$/imu', strip_tags($matches[$i][0]))) {
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

        return $matches;
    }

    public function remove_empty_headings($matches) {
        $tmp = [];

        for ($i = 0; $i < count($matches); $i++) {
            if (trim(strip_tags($matches[$i][0])) != false) {
                $tmp[] = $matches[$i];
            }
        }

        if (count($matches) != count($tmp)) {
            $matches = $tmp;
        }

        return $matches;
    }

    public function is_display_eligible($has_mokuji_tag) {
        global $post;
        $post_type = get_post_type($post);

        if (!is_singular() || !in_array($post_type, $this->options['auto_insert_post_types'])) {
            return false;
        }

        if ($has_mokuji_tag === true) {
            return true;
        }

        return true;
    }

    public function remove_tag_from_content($content) {
        return str_replace(MKJ_TAG, '', $content);
    }

    public function table_of_content($mokuji_title, $heading_list) {
        if (empty($heading_list)) {
            return "";
        }

        $html = '<nav>';
        $html .= '<div id="mokuji-container">';
        $html .= '<h2 class="mokuji-title">';
        $html .= esc_html($mokuji_title, ENT_COMPAT, 'UTF-8');
        $html .= '</h2>';
        $html .= '<section class="mokuji-content">';
        $html .= '<ol class="mokuji-list">';
        $html .= $heading_list;
        $html .= '</ol>';
        $html .= '</section>';
        $html .= '</div>';
        $html .= '</nav>';

        return $html;
    }

    public function insert_mokuji_to_content($html, $find, $replace, $content) {
        // 埋め込みタグがある場合
        $mokuji_tag_pos = strpos($content, MKJ_TAG);
        if ($mokuji_tag_pos !== false) {
            $find[] = MKJ_TAG;
            $replace[] = $html;
            return $this->mb_find_replace($find, $replace, $content);
        }

        // 埋め込みタグがない場合
        if (count($find) <= 0) {
            return $content;
        }

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

        return $content;
    }

    public function mb_find_replace($find, $replace, $string) {
        if (!is_array($find) || !is_array($replace) || empty($string)) {
            return "";
        }

        $find_cnt = count($find);
        for ($i = 0; $i < $find_cnt; $i++) {
            $string = mb_substr($string, 0, mb_strpos($string, $find[$i])) . // everything befor $find
            $replace[$i] . // its replacement
            mb_substr($string, mb_strpos($string, $find[$i]) + mb_strlen($find[$i])); // everything after $find;
        }

        return $string;
    }
}
