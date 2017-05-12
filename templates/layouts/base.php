<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <?php // get_template_part('components/loader'); ?>
  <?php
    do_action('get_header');
    get_template_part('layouts/header');
  ?>
    <main class="main-container">
      <div class="container">
      <?php include App\template()->main(); ?>
      <?php Kiku\Components\the_pagination(); ?>
      </div>
    </main>
  <?php
    do_action('get_footer');
    get_template_part('layouts/footer');
    wp_footer();
  ?>
  </body>
</html>
