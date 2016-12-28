<?php
  global $Image;
  $image_src = $Image->get_entry_image();
  $has_image = $image_src ? '' : 'none';
  $image_style_bg = $image_src ? "style='background-image: url($image_src)'" : "";
  $image_none_icon = $image_src ? "" : '<i class="material-icons">photo_camera</i>';
?>
<div class="entry-home-image">
  <div class="entry-home-image-frame <?= $has_image; ?>">
    <div class="entry-home-image-sheet" <?= $image_style_bg; ?>>
      <?= $image_none_icon; ?>
    </div>
  </div>
</div>
