<?php
  global $Entry;
  $similars = $Entry->get_similar_posts();
?>
<?php if( !empty($similars) ): ?>
<section class="entry-similar">
  <h2><?php _e('Related Articles', 'kiku'); ?></h2>
  <ul class='mdl-list'>
  <?php foreach($similars as $similar): ?>
    <li class="mdl-list__item"><a href="<?= $similar['uri']; ?>"><?= $similar['title']; ?></a></li>
  <?php endforeach; ?>
  </ul>
</section>
<?php endif; ?>
