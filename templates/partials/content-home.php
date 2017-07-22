<?php get_template_part('components/page-header'); ?>
<template v-if="loaded">
<div class="entry-home card">
  <article class="entry-container" v-for="(post,index) in posts">
    <a v-bind:href="post.link">
      <div class="entry-image" v-bind:data-thumbnail-image="post.thumbnail">
        <div class="image-container">
          <div class="image-sheet">
            <i class="icon material-icons">photo_camera</i>
          </div>
        </div>
      </div>
      <div class="entry-body">
        <header>
          <h2 class="entry-title">{{post.title}}</h2>
        </header>
        <div class="entry-summary">{{post.excerpt}}</div>
        <footer>
          <div class="entry-meta">
            <ul class="entry-time">
              <li>{{post.date.timeAgo}}</li>
            </ul>
          </div>
        </footer>
      </div>
    </a>
  </article>
</div>
</template>
