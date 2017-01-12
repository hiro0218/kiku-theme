<header class="header-navigation mdl-layout__header mdlext-layout__sticky-header mdlext-js-sticky-header">
  <div class="mdl-layout__header-row">
    <span class="mdl-layout-title">
      <a class="header-title" href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
    </span>
    <div class="mdl-layout-spacer"></div>
    <form class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                 mdl-textfield--floating-label mdl-textfield--align-right"
          method="get" action="<?= BLOG_URL; ?>">
      <label class="mdl-button mdl-js-button mdl-button--icon"
             for="fixed-header-drawer"><i class="material-icons">search</i>
      </label>
      <div class="mdl-textfield__expandable-holder">
        <input class="mdl-textfield__input" name="s" id="fixed-header-drawer"
               type="search" value="<?= get_search_query(); ?>" placeholder="<?php _e('Search', 'kiku'); ?> <?= bloginfo('name') ?>" required>
      </div>
    </form>
  </div>
</header>
<div class="mdl-layout__drawer">
<?php if (App\display_sidebar()) : ?>
  <?php get_template_part('layouts/sidebar'); ?>
<?php endif; ?>
</div>
