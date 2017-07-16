<?php while (have_posts()) : the_post(); ?>
<article class="entry card" data-page-id="<?= get_the_ID(); ?>">
  <header v-cloak>
    <h1 class="entry-title">{{title}}</h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <div class="entry-content"></div>
  <footer v-cloak>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
  </footer>
</article>
<?php endwhile; ?>
