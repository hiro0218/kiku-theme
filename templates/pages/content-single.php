<?php while (have_posts()) : the_post(); ?>
<div class="container">
  <article class="entry">
    <header class="entry-header">
      <h1 class="entry-title" v-html="$options.filters.escapeBrackets(title)"></h1>
      <div class="entry-meta">
        <entry-time :date="date"></entry-time>
        <entry-category :categories="categories"></entry-category>
      </div>
    </header>
    <section class="entry-content" v-html="content"></section>
    <amazon-product :amazon_product="amazon_product"></amazon-product>
    <footer>
      <entry-breadcrumb :title="title" :categories="categories"></entry-breadcrumb>
      <entry-tag :tags="tags"></entry-tag>
      <entry-share :title="title" :link="link"></entry-share>
    </footer>
  </article>
</div>
<aside class="attached-info">
  <entry-related :relateds="relateds"></entry-related>
  <entry-pager :pagers="pagers"></entry-pager>
</aside>
<?php endwhile; ?>
