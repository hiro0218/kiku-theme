<?php
  global $Image;
  $image_src = $Image->get_entry_image();
  $site_icon = esc_url( get_site_icon_url() );
  $height = 512;
  $width = 512;
  if ( empty($image_src) ) {
    $image_src = $site_icon;
  }
?>
<meta itemprop="author" content="<?= get_the_author(); ?>">
<meta itemprop="headline" content="<?= get_the_title(); ?>">
<meta itemprop="datePublished" content="<?= get_the_time('c'); ?>"/>
<meta itemprop="dateModified" content="<?= get_the_modified_time('c'); ?>"/>
<meta itemprop="mainEntityOfPage" content="<?= get_the_permalink(); ?>">
<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
  <meta itemprop="url" content="<?= $image_src ?>">
</div>
<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
  <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
    <meta itemprop="url" content="<?= $site_icon; ?>">
    <meta itemprop="width" content="<?= $width; ?>">
    <meta itemprop="height" content="<?= $height; ?>">
  </div>
  <meta itemprop="name" content="<?= BLOG_NAME; ?>">
</div>
