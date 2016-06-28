<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('partials/head'); ?>
  <body <?php body_class(); ?>>
    <div class="mdl-layout mdl-js-layout"><!-- mdl-layout -->
      <?php
        do_action('get_header');
        get_template_part('partials/header');
      ?>
      <div class="wrap mdl-layout__content" role="document">
        <main>
          <?php get_template_part('partials/page-header'); ?>
          <div class="main-container mdl-grid">
            <?php include App\template_unwrap(); ?>
          </div>
          <nav class="pagination-container">
            <?php Kiku\Components\the_pagination(); ?>
          </nav>
        </main>
        <?php
          do_action('get_footer');
          get_template_part('partials/footer');
          wp_footer();
        ?>
      </div><!-- /.wrap -->
    </div><!-- mdl-layout -->
  </body>
</html>
