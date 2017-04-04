<?php global $Ogp; ?>
<head prefix="<?= $Ogp->output_prefix(); ?>">
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php
  global $Schema;
  $Schema->make_search_action();
  ?>
</head>
