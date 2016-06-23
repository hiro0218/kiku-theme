<footer class="mdl-mini-footer">
  <div class="mdl-mini-footer__left-section">
    <div class="copyright">&copy; <?php echo Util::get_copyright_year(); ?> <a href="<?= BLOG_URL; ?>"><?= BLOG_NAME; ?></a>.</div>
    <?php if (has_nav_menu('primary_navigation')): ?>
      <nav><?php wp_nav_menu([
        'container' => '',
        'theme_location' => 'primary_navigation',
        'menu_class' => 'mdl-mini-footer__link-list'
      ]);?></nav>
    <?php endif; ?>
  </div>
</footer>
