<article class="entry mdl-cell mdl-cell--12-col" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php get_template_part('partials/entry-meta'); ?>
  </header>
  <div class="entry-content" itemprop="articleBody">
    <?php the_content(); ?>
  </div>
  <footer>
    <nav>
      <?php wp_link_pages([
        'before'         => '<p>' .  __('Pages:', 'sage'),
        'after'          => '</p>',
        'link_before'    => '',
        'link_after'     => '',
        'next_or_number' => 'number',
        'separator'      => ', ',
        'pagelink'       => '%',
        'echo'           => 1
      ]); ?>
    </nav>
    <nav>
      <?php get_template_part('partials/entry/breadcrumb'); ?>
    </nav>
    <section>
      <?php Kiku\Components\the_share(); ?>
    </section>
  <?php global $Entry;
      $similars = $Entry->get_similar_posts();
      if( !empty($similars) ): ?>
    <section class="entry-similar">
      <h2><?php _e('Related Articles', 'kiku'); ?></h2>
      <ul>
      <?php foreach($similars as $similar): ?>
        <li><a href="<?= $similar['uri']; ?>"><?= $similar['title']; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>
  </footer>
</article>
<nav class="mdl-cell mdl-cell--12-col"><?php Kiku\Components\the_pager(); ?></nav>
