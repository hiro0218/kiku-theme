<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <div id="app" class="contents">
    <layout-header></layout-header>
    <main class="main-container">
      <?php include App\template()->main(); ?>
    </main>
    <layout-footer></layout-footer>
  </div>
  <?php get_template_part('layouts/sidebar'); ?>
  <?php wp_footer(); ?>
  </body>
</html>
