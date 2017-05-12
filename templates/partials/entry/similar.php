<?php
  global $Entry;
  $similars = $Entry->get_similar_posts(3);
?>
<?php if( !empty($similars) ): ?>
<section class="entry-similar">
  <div class="columns">
<?php foreach($similars as $similar): ?>
    <div class="smilar-container column">
      <a href="<?= $similar['uri']; ?>" class="card">
        <div class="similar-title"><?= $similar['title']; ?></div>
        <div class="similar-description"><?= $similar['description']; ?></div>
      </a>
    </div>
<?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
