<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
    <?php get_template_part('components/loader'); ?>
    <div class="mdl-layout mdl-js-layout  mdl-layout--fixed-header">
      <?php
        do_action('get_header');
        get_template_part('layouts/header');
      ?>
      <div class="wrap mdl-layout__content" role="document">
        <main>
          <div class="main-container columns is-gapless">
            <?php include App\template()->main(); ?>
          </div>
          <?php Kiku\Components\the_pager(); ?>
          <?php Kiku\Components\the_pagination(); ?>
        </main>
        <?php
          do_action('get_footer');
          get_template_part('layouts/footer');
          wp_footer();
        ?>
      </div>
    </div>
  </body>
</html>
