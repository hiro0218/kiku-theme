<div class="entry-home-container mdl-cell mdl-cell--top mdl-cell--12-col">
  <?php get_template_part('components/page-header'); ?>
  <?php while (have_posts()) : the_post(); ?>
  <article class="entry-home" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
    <a href="<?php the_permalink(); ?>" itemprop="url">
      <?php get_template_part('partials/entry/thumbnail'); ?>
      <div class="entry-home-body">
        <header>
          <h2 class="entry-home-title"><?php the_title(); ?></h2>
        </header>
        <div class="entry-home-summary"><?php the_excerpt(); ?></div>
        <footer class="entry-home-footer">
          <?php get_template_part('partials/entry/meta'); ?>
        </footer>
      </div>
    </a>
    <?php get_template_part('partials/entry/schema'); ?>
  </article>
  <?php endwhile; ?>
</div>
