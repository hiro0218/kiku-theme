<ul class="entry-meta">
  <li><time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time></li>
  <?php if (is_single()): ?><li><?php edit_post_link('edit', '<p>', '</p>'); ?></li><?php endif; ?>
</ul>
