<?php
global $Schema;
$Schema->make_blog_posting();
?>
<article class="entry card" data-page-id="<?= get_the_ID(); ?>">
<template v-if="loaded">
  <header>
    <h1 class="entry-title">{{title}}</h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <section class="entry-content" v-html="content"></section>
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
