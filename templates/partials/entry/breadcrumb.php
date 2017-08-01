<?php
global $Schema;
$Schema->make_breadcrumb_list(); ?>
<nav class="breadcrumb">
  <ol>
    <li>
      <a href="<?= BLOG_URL ?>"><?= BLOG_NAME ?></a>
    </li>
    <li v-for="category in categories" v-cloak>
      <a v-bind:href="category.link">{{category.name}}</a>
    </li>
    <li class="breadcrumb-active">
      <a href="<?= get_the_permalink(); ?>">
        <span class="icon-location_on"></span><?php the_title_attribute(); ?>
      </a>
    </li>
  </ol>
</nav>
