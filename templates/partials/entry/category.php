<?php
  global $Entry;
  $categories = $Entry->get_category();
  if (!empty($categories)): ?>
<ul class="entry-category">
  <li><i class="material-icons">&#xE2C7;</i></li>
<?php foreach($categories as $category): ?>
  <li><a href="<?= $category['link']; ?>"><?= $category["name"]; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
