<ul class="entry-time" v-cloak v-if="date.publish">
  <li class="date-published">
    <span class="icon-update"></span><time itemprop="datePublished" v-bind:datetime="date.publish">{{date.publish | formatDate}}</time>
  </li>
  <li class="date-modified" v-if="date.modified">
    <time itemprop="dateModified" v-bind:datetime="date.modified">{{date.modified | formatDate}}</time>
  </li>
  <?php if (is_user_logged_in()): ?>
  <li><?php edit_post_link('<span class="icon-edit"></span>'); ?></li>
  <?php endif; ?>
</ul>
