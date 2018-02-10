<div class="container">
  <article class="entry">
    <header class="entry-header">
      <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"></h1>
      <div class="entry-meta">
        <entry-time :date="post.date"></entry-time>
        <entry-category :categories="post.categories"></entry-category>
      </div>
    </header>
    <section class="entry-content" v-html="post.content"></section>
    <amazon-product :amazon_product="post.amazon_product"></amazon-product>
    <footer class="entry-footer">
      <entry-tag :tags="post.tags"></entry-tag>
      <entry-share :title="post.title" :link="post.link"></entry-share>
      <entry-pager :pagers="post.attach.pagers"></entry-pager>
    </footer>
  </article>
</div>

<entry-related :relateds="post.attach.relateds"></entry-related>
<entry-breadcrumb :title="post.title" :categories="post.categories"></entry-breadcrumb>
