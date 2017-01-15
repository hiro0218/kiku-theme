<article class="entry mdl-cell mdl-cell--12-col"
         itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php get_template_part('partials/entry/meta'); ?>
  </header>
  <section class="entry-content" itemprop="articleBody">
    <?= get_the_post_thumbnail(null, 'full', ['class' => 'eyecatch']); ?>
    <?php the_content(); ?>
  </section>
  <footer>
    <?php get_template_part('partials/entry/paginated'); ?>
    <?php get_template_part('partials/entry/breadcrumb'); ?>
    <?php get_template_part('partials/entry/tag'); ?>
    <?php Kiku\Components\the_share(); ?>
    <?php get_template_part('partials/entry/similar'); ?>
  </footer>
  <?php get_template_part('partials/entry/schema'); ?>
</article>
