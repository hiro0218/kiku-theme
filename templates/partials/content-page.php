<article class="entry card" data-page-id="<?= get_the_ID(); ?>">
<template v-if="loaded">
  <header>
    <h1 class="entry-title">{{title}}</h1>
    <div class="entry-meta">
      <?php get_template_part('partials/entry/time'); ?>
      <?php get_template_part('partials/entry/category'); ?>
    </div>
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
