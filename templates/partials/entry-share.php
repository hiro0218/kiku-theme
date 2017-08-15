<?php $Share = new \Share(); ?>
<section class="entry-share">
<?php if ($Share->display['twitter']): ?>
  <a href="javascript:void(0)" class="btn-twitter" title="Share on Twitter"
    onClick="openWindow('//twitter.com/share?url=<?= $Share->meta['url']; ?>&text=<?= $Share->meta['title']; ?>',620,310); return false;">
    <span class="icon-twitter"></span>
  </a>
<?php endif; ?>
<?php if ($Share->display['facebook']): ?>
  <a href="javascript:void(0)" class="btn-facebook" title="Share on Facebook"
    onClick="openWindow('//www.facebook.com/sharer/sharer.php?u=<?= $Share->meta['url']; ?>', 560,550); return false;">
    <span class="icon-facebook"></span>
  </a>
<?php endif; ?>
<?php if ($Share->display['hatena']): ?>
  <a href="//b.hatena.ne.jp/entry/<?= $Share->meta['url']; ?>" class="hatena-bookmark-button btn-hatena"
     title="Share on LINE"
     data-hatena-bookmark-title="<?= $Share->meta['title']; ?>"
     data-hatena-bookmark-layout="simple">
     <span class="icon-hatena"></span>
  </a>
<?php endif; ?>
<?php if ($Share->display['line']): ?>
  <a href="javascript:void(0)" class="btn-line" title="Share on LINE"
    onClick="openWindow('//lineit.line.me/share/ui?url=<?= $Share->meta['url']; ?>', 560,550); return false;">
    <span class="icon-line"></span>
  </a>
<?php endif; ?>
</section>
