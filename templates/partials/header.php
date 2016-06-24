<header class="header-navigation mdl-layout__header mdl-layout__header--scroll">
  <div class="mdl-layout__header-row">
    <span class="mdl-layout-title"><!-- Title -->
      <a class="brand" href="<?= BLOG_URL; ?>">
        <?php bloginfo('name'); ?>
      </a>
    </span>
    <div class="mdl-layout-spacer"></div>
    <!-- Search -->
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
      <form method="get" class="header-search" action="<?= BLOG_URL; ?>">
        <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer">
          <i class="material-icons">search</i>
        </label>
        <div class="mdl-textfield__expandable-holder">
          <input class="mdl-textfield__input" type="search" value="<?= get_search_query(); ?>" name="s" id="fixed-header-drawer" required>
        </div>
      </form>
    </div>
  </div>
</header>
<div class="mdl-layout__drawer">
  <?php if (App\display_sidebar()) : ?>
    <?php get_template_part('partials/sidebar'); ?>
  <?php endif; ?>
</div>
