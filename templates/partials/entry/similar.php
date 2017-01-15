<?php
  global $Entry;
  $similars = $Entry->get_similar_posts(4);
?>
<?php if( !empty($similars) ): ?>
<section class="entry-similar mdl-grid">
  <?php foreach($similars as $similar): ?>
  <a href="<?= $similar['uri']; ?>"
     class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
    <div class="similar-title"><?= $similar['title']; ?></div>
    <div class="similar-description"><?= $similar['description']; ?></div>
  </a>
  <?php endforeach; ?>
</section>
<?php endif; ?>
