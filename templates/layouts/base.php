<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <div id="app">
    <kiku-header></kiku-header>
    <main class="main-container">
      <?php include App\template()->main(); ?>
    </main>
    <kiku-footer></kiku-footer>
  </div>
  <?php get_template_part('layouts/sidebar'); ?>
  <?php wp_footer(); ?>
  </body>
</html>
