<!doctype html>
<html <?php language_attributes(); ?>>
  <head prefix="<?php echo \Kiku\Util::output_prefix(); ?>">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate" />
    <meta name="format-detection" content="telephone=no">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <?php wp_head(); ?>
  </head>
  <body>
    <div id="app"></div>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default-3.4,Array.prototype.includes,IntersectionObserver"></script>
    <?php wp_footer(); ?>
  </body>
</html>
