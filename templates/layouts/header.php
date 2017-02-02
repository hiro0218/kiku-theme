<header class="header-navigation">
  <div class="container">
    <a class="header-title" href="<?= BLOG_URL; ?>"><?php bloginfo('name'); ?></a>
  </div>
</header>

<?php if (App\display_sidebar()) : ?>
  <?php get_template_part('layouts/sidebar'); ?>
<?php endif; ?>
