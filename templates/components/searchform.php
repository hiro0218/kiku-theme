<form method="get" action="<?= BLOG_URL; ?>">
  <div class="">
    <input class="" type="search" value="<?= get_search_query(); ?>" placeholder="<?php _e('Search', 'kiku'); ?> <?= bloginfo('name') ?>" name="s" id="widget_searchform" required>
    <label class="" for="widget_searchform"><?php _e('Search...', 'kiku'); ?></label>
  </div>
</form>
