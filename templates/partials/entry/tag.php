<?php
  global $Entry;
  $tags = $Entry->get_tag();
?>
<?php if ( !empty($tags) ): ?>
<ul class="entry-tag">
<?php foreach( $tags as $tag ): ?><li><a href="<?= $tag['link'] ?>" itemprop="keywords"><?= $tag['name'] ?></a></li><?php endforeach; ?>
</ul>
<?php endif; ?>
