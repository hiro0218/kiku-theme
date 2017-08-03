<?php

namespace Kiku;

class Mokuji_Builder {
    private $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function extract_headings($content) {
        $find = [];
        $matches = [];

        // コンテンツ内のすべてのheadingタグを取得
        preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER);

        // $matches
        // array (size=3)
        // 0 => string '<h2>見出し</h2>' (length=18)
        // 1 => string '<h2>' (length=4)
        // 2 => string '2' (length=1)

        if (empty($matches)) {
            return [];
        }

        // check minimum number of headings
        $matches_cnt = count($matches);
        // get anchor and add to find and replace arrays
        for ($i = 0; $i < $matches_cnt; $i++) {
            $heading = $matches[$i][0];
            $find[] = $heading;
        }

        return $find;
    }

    public function table_of_content($mokuji_title) {
        $html = '';

        $html .= '<nav class="mokuji-container">';
        $html .= '<span class="mokuji-title">';
        $html .= esc_html($mokuji_title, ENT_COMPAT, 'UTF-8');
        $html .= '</span>';
        $html .= '<section class="mokuji-content"></section>';
        $html .= '</nav>';

        return $html;
    }

    public function insert_mokuji_to_content($html, $find, $replace, $content) {

        switch ($this->options['position']) {
            case MKJ_POSITION_CONTENTS_TOP:
                $content = $html . $content;
                break;

            case MKJ_POSITION_CONTENTS_BOTTOM:
                $content = $content . $html;
                break;

            case MKJ_POSITION_AFTER_FIRST_HEADING:
                // add after first heading
                $replace[0] = $replace[0] . $html;
                $content = $this->mb_find_replace($find, $replace, $content);
                break;

            case MKJ_POSITION_BEFORE_FIRST_HEADING:
            default:
                // add before first heading
                $replace[0] = $html . $replace[0];
                $content = $this->mb_find_replace($find, $replace, $content);
                break;
        }

        return $content;
    }

    public function mb_find_replace($find, $replace, $content) {
        if (!is_array($find) || !is_array($replace)) {
            return $content;
        }

        $find_cnt = count($find);
        for ($i = 0; $i < $find_cnt; $i++) {
            $content = mb_substr($content, 0, mb_strpos($content, $find[$i])) . // everything befor $find
            $replace[$i] . // its replacement
            mb_substr($content, mb_strpos($content, $find[$i]) + mb_strlen($find[$i])); // everything after $find;
        }

        return $content;
    }
}
