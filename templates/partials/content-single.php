<?php
global $Schema;
$Schema->make_blog_posting();
?>
<article class="entry" data-page-id="<?= get_the_ID(); ?>">
<template v-if="loaded">
  <header>
    <h1 class="entry-title">{{title}}</h1>
    <div class="entry-meta">
      <?php get_template_part('partials/entry/time'); ?>
      <?php get_template_part('partials/entry/category'); ?>
    </div>
  </header>
  <section class="entry-content">
    <?php the_content(); ?>
  </section>
  <?php get_template_part('partials/entry/amazon_product'); ?>
  <footer>
    <?php get_template_part('partials/entry/paginated'); ?>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
    <?php get_template_part('partials/entry/tag'); ?>
    <?php Kiku\Components\the_share(); ?>
  </footer>
</template>
<template v-else>
  <?php get_template_part('partials/placeholder/single'); ?>
</template>
</article>
<?php get_template_part('partials/entry/similar'); ?>
<?php get_template_part('partials/entry/pager'); ?>
