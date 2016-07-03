<?php
  global $Entry;
  $tags = $Entry->get_tag();
  if ( !empty($tags) ): ?>
<ul class="entry-tag">
  <li class="head-icon"><i class="material-icons">&#xE54E;</i></li>
<?php foreach( $tags as $tag ): ?>
  <li><a href="<?= $tag['link'] ?>" itemprop="keywords"><?= $tag['name'] ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
