<?php
  global $Image;
  $image_src = $Image->get_entry_image();
?>
<div class="entry-image" data-thumbnail-image="<?= $image_src; ?>">
  <div class="image-container">
    <div class="image-sheet">
      <i class="icon material-icons">photo_camera</i>
    </div>
  </div>
</div>
