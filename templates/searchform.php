<form method="get" action="<?= BLOG_URL; ?>">
  <div class="search-container">
    <label for="widget_searchform"><?php _e('Search...', 'kiku'); ?></label>
    <div class="search-icon"><i class="material-icons">search</i></div>
    <input type="search" class="search-input" value="<?= get_search_query(); ?>" placeholder="<?php _e('Search', 'kiku'); ?>" name="s" id="widget_searchform" required>
  </div>
</form>
