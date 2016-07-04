<?php
// Access denied Author page
// -> update options-permalink
add_filter( 'author_rewrite_rules', '__return_empty_array' );
