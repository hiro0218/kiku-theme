<form method="get" action="<?php echo BLOG_URL; ?>">
  <div class="search-container">
    <label for="widget_searchform"><?php _e('Search...', 'kiku'); ?></label>
    <div class="search-icon"><span class="icon-search"></span></div>
    <input type="search" class="search-input" value="<?php echo get_search_query(); ?>" placeholder="<?php _e('Search', 'kiku'); ?>" name="s" id="widget_searchform" required>
  </div>
</form>
