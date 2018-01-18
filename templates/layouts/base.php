<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <div id="app">
    <kiku-header></kiku-header>
    <?php get_template_part('layouts/main');?>
    <kiku-footer></kiku-footer>
  </div>
  <?php get_template_part('layouts/sidebar'); ?>
  <?php wp_footer(); ?>
  </body>
</html>
