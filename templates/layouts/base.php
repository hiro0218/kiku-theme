<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <div id="app">
    <?php get_template_part('layouts/header');?>
    <?php get_template_part('layouts/main');?>
    <kiku-footer/>
  </div>
  <?php wp_footer(); ?>
  </body>
</html>
