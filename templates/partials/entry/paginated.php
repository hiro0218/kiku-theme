<?php 
wp_link_pages([
  'before'         => '<nav><p>' .  __('Pages:', 'kiku'),
  'after'          => '</nav></p>',
  'link_before'    => '',
  'link_after'     => '',
  'next_or_number' => 'number',
  'separator'      => ', ',
  'pagelink'       => '%',
  'echo'           => 1
]);
