<?php get_template_part('components/page-header'); ?>
<template v-if="loaded">
<div class="entry-list">
  <a v-bind:href="post.link" v-for="(post,index) in posts">
  <article class="entry-container">
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
  </article>
</a>
</div>
</template>
