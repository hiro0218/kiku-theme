<?php $Share = new \Share(); ?>
<section class="entry-share">
<?php if ($Share->display['twitter']): ?>
  <a href="javascript:void(0)" class="btn-twitter" title="<?php __('Share on Twitter.', 'kiku'); ?>"
    onClick="openWindow('//twitter.com/share?url=<?= $Share->meta['url']; ?>&text=<?= $Share->meta['title']; ?>',620,310); return false;">
  twitter
  </a>
<?php endif; ?>
<?php if ($Share->display['facebook']): ?>
  <a href="javascript:void(0)" class="btn-facebook" title="<?php __('Share on Facebook.', 'kiku'); ?>"
    onClick="openWindow('//www.facebook.com/sharer/sharer.php?u=<?= $Share->meta['url']; ?>', 560,550); return false;">
  facebook
  </a>
<?php endif; ?>
<?php if ($Share->display['hatena']): ?>
  <a href="//b.hatena.ne.jp/entry/<?= $Share->meta['url']; ?>" class="hatena-bookmark-button btn-hatena"
     title="<?php __('Share on LINE.', 'kiku'); ?>"
     data-hatena-bookmark-title="<?= $Share->meta['title']; ?>"
     data-hatena-bookmark-layout="simple"
  >
  hatena
  </a>
<?php endif; ?>
<?php if ($Share->display['line']): ?>
  <a href="javascript:void(0)" class="btn-line" title="<?php __('Share on LINE.', 'kiku'); ?>"
    onClick="openWindow('//lineit.line.me/share/ui?url=<?= $Share->meta['url']; ?>', 560,550); return false;">
  line
  </a>
<?php endif; ?>
</section>
