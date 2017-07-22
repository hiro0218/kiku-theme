<?php while (have_posts()) : the_post(); ?>
<article class="entry card" data-page-id="<?= get_the_ID(); ?>">
<template v-if="loaded">
  <header>
    <h1 class="entry-title">{{title}}</h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <section class="entry-content" v-html="content"></section>
  <footer>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
  </footer>
</template>
<template v-else>
  <?php get_template_part('partials/placeholder/single'); ?>
</template>
</article>
<?php endwhile; ?>
