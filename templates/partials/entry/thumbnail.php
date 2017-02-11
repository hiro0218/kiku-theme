<?php
  global $Image;
  $image_src = $Image->get_entry_image();
  $image_style_bg = $image_src ? "style='background-image: url($image_src)'" : "";
  $image_none_icon = $image_src ? "" : '<i class="material-icons">photo_camera</i>';
?>
<div class="entry-image">
  <div class="image-container">
    <div class="image-sheet" <?= $image_style_bg; ?>>
      <?= $image_none_icon; ?>
    </div>
  </div>
</div>
