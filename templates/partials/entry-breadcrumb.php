<?php
global $Schema;
$Schema->make_breadcrumb_list(); ?>
<nav class="breadcrumb">
  <ol>
    <li>
      <span class="icon-home"></span>
      <a href="<?php echo BLOG_URL ?>"><?php echo BLOG_NAME ?></a>
    </li>
    <li v-for="category in categories" v-cloak>
      <a v-bind:href="category.link">{{category.name}}</a>
    </li>
    <li class="breadcrumb-active">
      <span class="icon-location_on"></span>
      <a href="<?php echo get_the_permalink(); ?>"><?php the_title_attribute(); ?></a>
    </li>
  </ol>
</nav>
