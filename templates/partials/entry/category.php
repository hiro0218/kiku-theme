<?php
  global $Entry;
  $categories = $Entry->get_category();
?>
<?php if (!empty($categories)): ?>
<ul class="entry-category">
<?php foreach($categories as $category): ?>
  <li><a href="<?= $category['link']; ?>"><?= $category["name"]; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
