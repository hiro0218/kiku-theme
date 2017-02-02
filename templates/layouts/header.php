<header class="header-navigation">
  <div class="">
    <span class="">
      <a class="header-title" href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
    </span>
    <div class=""></div>
    <form class=""
          method="get" action="<?= BLOG_URL; ?>">
      <label class=""
             for="fixed-header-drawer"><i class="material-icons">search</i>
      </label>
      <div class="">
        <input class="" name="s" id="fixed-header-drawer"
               type="search" value="<?= get_search_query(); ?>" placeholder="<?php _e('Search', 'kiku'); ?> <?= bloginfo('name') ?>" required>
      </div>
    </form>
  </div>
</header>
<div class="">
<?php if (App\display_sidebar()) : ?>
  <?php get_template_part('layouts/sidebar'); ?>
<?php endif; ?>
</div>
