<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('partials/head'); ?>
  <body <?php body_class(); ?>>
    <?php
      do_action('get_header');
      get_template_part('partials/header');
    ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main">
          <?php include App\template_unwrap(); ?>
        </main><!-- /.main -->
        <?php if (App\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php get_template_part('partials/sidebar'); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      do_action('get_footer');
      get_template_part('partials/footer');
      wp_footer();
    ?>
  </body>
</html>
