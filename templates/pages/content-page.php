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
  </article>
</div>

<entry-breadcrumb :title="title" :categories="post.categories"></entry-breadcrumb>
