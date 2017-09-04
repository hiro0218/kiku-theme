<?php

// checked output data: https://search.google.com/structured-data/testing-tool?hl=ja

class Schema {
    public function __construct() {
        add_action('wp_head', [$this, 'make_search_action'], 25);
        add_action('wp_head', [$this, 'make_blog_posting'], 25);
        add_action('wp_head', [$this, 'make_breadcrumb_list'], 25);
    }

    private function make_script_tag(string $json) {
        $script = '<script type="application/ld+json">'. PHP_EOL .'%s</script>'. PHP_EOL;
        return sprintf($script, $json);
    }

    private function array_to_json($array) {
        return json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ). PHP_EOL;
    }

    public function make_article() {
        if (!is_singular()) {
            return;
        }

        require_once(realpath(__DIR__) .DIRECTORY_SEPARATOR .'Article.php');
        $Article = new Article();
        $array = $Article->render();
        if ($array) {
            echo $this->make_script_tag($this->array_to_json($array));
        }
    }

    public function make_blog_posting() {
        if (!is_singular()) {
            return;
        }

        require_once(realpath(__DIR__) .DIRECTORY_SEPARATOR .'BlogPosting.php');
        $BlogPosting = new BlogPosting();
        $array = $BlogPosting->render();
        if ($array) {
            echo $this->make_script_tag($this->array_to_json($array));
        }
    }

    public function make_breadcrumb_list() {
        if (!is_singular()) {
            return;
        }

        require_once(realpath(__DIR__) .DIRECTORY_SEPARATOR .'BreadcrumbList.php');
        $BreadcrumbList = new BreadcrumbList();
        $array = $BreadcrumbList->render();
        if ($array) {
            echo $this->make_script_tag($this->array_to_json($array));
        }
    }

    public function make_search_action() {
        if (!is_home() && !is_front_page()) {
            return;
        }

        require_once(realpath(__DIR__) .DIRECTORY_SEPARATOR .'SearchAction.php');
        $SearchAction = new SearchAction();
        $array = $SearchAction->render();
        if ($array) {
            echo $this->make_script_tag($this->array_to_json($array));
        }
    }

}

$Schema = new Schema();
