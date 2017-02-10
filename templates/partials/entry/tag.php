<?php
  global $Entry;
  $tags = $Entry->get_tag();
?>
<?php if ( !empty($tags) ): ?>
<div>
  <ul class="entry-tag">
  <?php foreach( $tags as $tag ): ?><li><a href="<?= $tag['link'] ?>" itemprop="keywords"><?= $tag['name'] ?></a></li><?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>
