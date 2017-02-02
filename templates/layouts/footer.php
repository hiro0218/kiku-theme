<footer class="footer footer-navigation">
  <div class="container columns">
    <div class="footer-menu column">
      <?php if (has_nav_menu('primary_navigation')): ?>
        <nav><?php wp_nav_menu([
          'container' => '',
          'theme_location' => 'primary_navigation',
          'menu_class' => ''
        ]);?></nav>
      <?php endif; ?>
    </div>
    <div class="footer-copytight column is-one-third">
      <span>&copy; <?php echo Kiku\Util::get_copyright_year(); ?> <a href="<?= BLOG_URL; ?>"><?= BLOG_NAME; ?></a>.</span>
    </div>
  </div>
</footer>
