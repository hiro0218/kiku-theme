<footer class="footer footer-navigation">
  <div class="container">
    <div class="footer-menu">
      <?php if (has_nav_menu('primary_navigation')) : ?>
        <nav><?php wp_nav_menu([
          'container' => '',
          'theme_location' => 'primary_navigation',
          'menu_class' => ''
        ]);?></nav>
      <?php endif; ?>
    </div>
    <div class="footer-copytight">
      <span>&copy; <?php echo Kiku\Util::get_copyright_year(); ?> <a href="<?php echo BLOG_URL; ?>"><?php echo BLOG_NAME; ?></a>.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
