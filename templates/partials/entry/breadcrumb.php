<?php if( is_singular() ): ?>
<nav class="breadcrumb">
<ol itemscope itemtype="http://schema.org/BreadcrumbList">
  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <i class="material-icons">home</i>
    <a href="<?= BLOG_URL ?>" itemprop="item">
      <span itemprop="name"><?= BLOG_NAME ?></span>
    </a>
  </li>
  <li class="list-icon-arrow"><i class="material-icons">navigate_next</i></li>
  <?php if ( is_singular() ): ?>
  <?php
    $category = get_the_category();
    if (!empty($category)):
  ?>
  <?php
    $catid = $category[0]->cat_ID;
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
    <a href="<?= get_category_link($catid); ?>" itemprop="item"><span itemprop="name"><?= get_cat_name($catid); ?></span></a>
    <i class="material-icons">navigate_next</i>
  </li>
  <?php endforeach; ?>
  <?php endif;  // $category is not empty ?>
  <?php endif;  // is_singular() ?>
  <li class="breadcrumb-active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <i class="material-icons">location_on</i>
    <a href="<?= get_the_permalink(); ?>" itemprop="item">
      <span itemprop="name"><?php the_title_attribute(); ?></span>
    </a>
  </li>
</ol>
</nav>
<?php endif; ?>
