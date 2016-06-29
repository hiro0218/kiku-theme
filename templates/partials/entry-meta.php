<div class="entry-meta">
  <ul>
    <?php
    $is_modified_post = Kiku\Util::is_modified_post();
    $posted_time_ago = Kiku\Util::get_posted_time_ago( $is_modified_post ? get_post_modified_time() : get_post_time() );
    ?>
    <?php if (is_singular()): ?>
    <li class="date-published"><i class="material-icons">update</i> <time itemprop="datePublished" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date('Y/m/d'); ?></time></li>
    <?php if ($is_modified_post): ?>
    <li><i class="material-icons">navigate_next</i></li>
    <li class="date-modified"><time itemprop="dateModified" datetime="<?= get_post_time('c', true); ?>"><?= get_the_modified_date('Y/m/d'); ?></time></li>
    <?php endif; ?>
    <li><?php edit_post_link('edit', '<p>', '</p>'); ?></li>
    <?php else: ?>
    <li><i class="material-icons">update</i> <?= $posted_time_ago; ?></li>
    <?php endif; ?>
  </ul>
</div>
