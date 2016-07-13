<form method="get" action="<?= BLOG_URL; ?>">
  <div class="mdl-textfield mdl-js-textfield">
    <input class="mdl-textfield__input" type="search" value="<?= get_search_query(); ?>" name="s" id="widget_searchform" required>
    <label class="mdl-textfield__label" for="widget_searchform"><?php _e('Search...', 'kiku'); ?></label>
  </div>
</form>
