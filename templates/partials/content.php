<?php
  global $Image;
  $image_src = $Image->get_entry_image();
  // mdl-cell mdl-cell--4-col 
?>
<article class="card-container mdl-card mdl-color--white" title="<?php the_title(); ?>" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
  <a class="entry-wrap" href="<?php the_permalink(); ?>" itemprop="url">
    <div class="entry-image">
      <div class="entry-image-sheet" style="background-image: url('<?= $image_src ?>')">
        <?php if ( empty($image_src) ): ?>
        <div class="entry-image-none"><i class="material-icons">photo_camera</i></div>
        <?php endif; ?>
      </div>
    </div>
    <header class="mdl-card__title">
      <h2 class="entry-title mdl-card__title-text"><?php the_title(); ?></h2>
    </header>
    <div class="entry-summary mdl-card__supporting-text mdl-card--expand">
      <?php the_excerpt(); ?>
    </div>
    <footer class="mdl-card__supporting-text">
      <?php get_template_part('partials/entry-meta'); ?>
    </footer>
  </a>
  <?php get_template_part('partials/entry/schema'); ?>
</article>
