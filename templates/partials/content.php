<?php
  global $Image;
  $image_src = $Image->get_entry_image();
?>
<article class="mdl-cell mdl-cell--4-col card-container mdl-card mdl-color--white" title="<?php the_title(); ?>">
  <div class="entry-image">
    <div class="entry-image-sheet" style="background-image: url('<?= $image_src ?>')">
      <?php if ( empty($image_src) ): ?>
      <div class="entry-image-none"><i class="material-icons">photo_camera</i></div>
      <?php endif; ?>
    </div>
  </div>
  <header class="mdl-card__title">
    <h2 class="entry-title mdl-card__title-text">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
  </header>
  <div class="entry-summary mdl-card__supporting-text mdl-card--expand">
    <?php the_excerpt(); ?>
  </div>
  <div class="mdl-card__supporting-text">
    <?php get_template_part('partials/entry-meta'); ?>
  </div>
</article>
