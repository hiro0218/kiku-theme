<?php
  global $Entry;
  $similars = $Entry->get_similar_posts(4);
?>
<?php if( !empty($similars) ): ?>
<section class="entry-similar columns is-multiline is-gapless">
  <?php foreach($similars as $similar): ?>
  <a href="<?= $similar['uri']; ?>" class="column is-half">
    <div class="similar-title"><?= $similar['title']; ?></div>
    <div class="similar-description"><?= $similar['description']; ?></div>
  </a>
  <?php endforeach; ?>
</section>
<?php endif; ?>
