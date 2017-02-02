<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
    <?php get_template_part('components/loader'); ?>
    <div class="">
      <?php
        do_action('get_header');
        get_template_part('layouts/header');
      ?>
      <div class="wrap" role="document">
        <main class="container">
          <?php include App\template()->main(); ?>
        </main>
        <div class="container">
        <?php Kiku\Components\the_pager(); ?>
        <?php Kiku\Components\the_pagination(); ?>
        </div>
        <?php
          do_action('get_footer');
          get_template_part('layouts/footer');
          wp_footer();
        ?>
      </div>
    </div>
  </body>
</html>
