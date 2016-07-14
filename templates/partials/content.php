<?php
  global $Image;
  $image_src = $Image->get_entry_image();
?>
<article class="card-container will-animation mdl-cell mdl-cell--4-col mdl-card mdl-color--white" title="<?php the_title(); ?>" style="visibility:hidden;" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
  <a class="entry-wrap" href="<?php the_permalink(); ?>" itemprop="url">
    <meta itemprop="author" content="<?= get_the_author(); ?>">
    <meta itemprop="datePublished" content="<?= get_the_time('c'); ?>"/>
    <meta itemprop="dateModified" content="<?= get_the_modified_time('c'); ?>"/>
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
</article>
