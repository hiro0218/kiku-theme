<?php if( is_singular() ): ?>
<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <a href="<?= BLOG_URL ?>" itemprop="item">
      <i class="material-icons">home</i>
      <span itemprop="name"><?= BLOG_NAME ?></span>
    </a>
  </li>
  <li class="list-icon-arrow"><i class="material-icons">navigate_next</i></li>
  <?php if ( is_single() ): ?>
  <?php
    $catid = get_the_category()[0]->cat_ID;
    $allcats = array($catid);

    while( !$catid == 0 ) {
      $catid = get_category($catid)->parent;
      if ( !$catid == 0 ) {
        array_push( $allcats, $catid );
      }
    }
    $allcats = array_reverse($allcats);
  ?>
  <?php foreach ( $allcats as $catid ): ?>
  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <a href="<?= get_category_link($catid); ?>" itemprop="item">
      <span itemprop="name"><?= get_cat_name($catid); ?></span>
    </a>
  </li>
  <li class="list-icon-arrow"><i class="material-icons">navigate_next</i></li>
  <?php endforeach; ?>
  <?php endif; ?>
  <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <a href="<?= get_the_permalink(); ?>" itemprop="item">
      <i class="material-icons">location_on</i>
      <span itemprop="name"><?php the_title_attribute(); ?></span>
    </a>
  </li>
</ol>
<?php endif; ?>
