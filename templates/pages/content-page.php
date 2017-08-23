<?php while (have_posts()) : the_post(); ?>
<div class="container">
  <article class="entry" v-cloak v-show="loaded">
    <header>
      <h1 class="entry-title"><?php echo esc_html(get_the_title()); ?></h1>
      <div class="entry-meta">
        <?php get_template_part('partials/entry/time'); ?>
        <?php get_template_part('partials/entry/category'); ?>
      </div>
    </header>
    <section class="entry-content">
      <?php the_content(); ?>
    </section>
    <?php get_template_part('partials/entry-paginated'); ?>
    <footer>
      <?php get_template_part('partials/entry/breadcrumb'); ?>
    </footer>
  </article>
</div>
<?php endwhile; ?>
