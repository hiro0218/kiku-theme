<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('layouts/head'); ?>
  <body <?php body_class(); ?>>
  <div id="app" class="contents" v-bind:class="{ 'open-drawer': isOpenSidebar }">
    <layout-header></layout-header>
    <main class="main-container">
      <?php include App\template()->main(); ?>
    </main>
    <layout-footer></layout-footer>
    <layout-sidebar/>
  </div>
  <?php wp_footer(); ?>
  </body>
</html>
