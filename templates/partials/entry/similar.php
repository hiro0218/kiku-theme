<?php
  global $Entry;
  $similars = $Entry->get_similar_posts(4);
?>
<?php if( !empty($similars) ): ?>
<section class="entry-similar columns is-multiline">
<?php foreach($similars as $similar): ?>
  <div class="smilar-container column is-half">
    <a href="<?= $similar['uri']; ?>">
      <span class="similar-title"><?= $similar['title']; ?></span>
      <span class="similar-description"><?= $similar['description']; ?></span>
    </a>
  </div>
<?php endforeach; ?>
</section>
<?php endif; ?>
