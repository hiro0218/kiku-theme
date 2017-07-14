<ul class="entry-time" v-cloak>
<?php if (is_singular()): ?>
  <li class="date-published" v-if="date.publish"><time itemprop="datePublished" v-bind:datetime="date.publish">{{date.publish | formatDate}}</time></li>
  <li class="date-modified" v-if="date.modified"><time itemprop="dateModified" v-bind:datetime="date.modified">{{date.modified | formatDate}}</time></li>
  <?php if (is_user_logged_in()): ?>
  <li><?php edit_post_link('<i class="material-icons">edit</i>'); ?></li>
  <?php endif; ?>
<?php else: ?>
  <?php
    $is_modified_post = Kiku\Util::is_modified_post();
    $posted_time_ago = Kiku\Util::get_posted_time_ago( $is_modified_post ? get_post_modified_time() : get_post_time() );
  ?>
  <li><?= $posted_time_ago; ?></li>
<?php endif; ?>
</ul>
