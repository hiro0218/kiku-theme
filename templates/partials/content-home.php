<?php
  global $Image;
  $image_src = $Image->get_entry_image();
?>
<article class="entry-wrap" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
  <a class="" href="<?php the_permalink(); ?>" itemprop="url">
    <div class="entry-image">
      <div class="entry-image-frame">
        <div class="entry-image-sheet"<?php if (!empty($image_src)): ?> style="background-image: url('<?= $image_src ?>')"<?php endif; ?>>
          <?php if ( empty($image_src) ): ?>
            <div class="entry-image-none"><i class="material-icons">photo_camera</i></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="entry-body">
      <header class="entry-header">
        <h2 class="entry-title"><?php the_title(); ?></h2>
      </header>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div>
      <footer class="entry-footer">
        <?php get_template_part('partials/entry/meta'); ?>
      </footer>
    </div>
  </a>
  <?php get_template_part('partials/entry/schema'); ?>
</article>
