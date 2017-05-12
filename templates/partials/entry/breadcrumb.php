<?php if( is_singular() ): ?>
<?php
global $Schema;
$Schema->make_breadcrumb_list();
?>
<nav class="breadcrumb">
<ol>
  <li>
    <a href="<?= BLOG_URL ?>"><?= BLOG_NAME ?></a>
  </li>
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
  <li>
    <a href="<?= get_category_link($catid); ?>"><?= get_cat_name($catid); ?></a>
  </li>
  <?php endforeach; ?>
  <?php endif;  // $category is not empty ?>
  <?php endif;  // is_singular() ?>
  <li class="breadcrumb-active">
    <a href="<?= get_the_permalink(); ?>">
      <?php the_title_attribute(); ?>
    </a>
  </li>
</ol>
</nav>
<?php endif; ?>
