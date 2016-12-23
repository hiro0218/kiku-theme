<?php
/*
 * Template Name: Archive
 */

$DB = new \Kiku\DB();
$archives = $DB->get_archive_list();

$tmp_year = 0;
?>
<?php while (have_posts()) : the_post(); ?>
<article class="entry mdl-cell mdl-cell--12-col">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
  </header>
  <div class="entry-content">
    <section>
    <?php foreach($archives as $entry): ?>
    <?php
      // set year
      $current_year = intval( strtok($entry['post_date'], '-') );
      if ($tmp_year != $current_year) {
        echo "</ul>";  // for prev loop's
        $tmp_year = $current_year;
        echo "<h2>". $tmp_year ."</h2>";
        echo "<ul class='page-archive-list'>";
      }
      $post_date = strtotime($entry['post_date']);
    ?>
    <li>
      <time datetime="<?= date(DATE_W3C, $post_date) ?>"><?= date('M d', $post_date) ?></time>
      <a href="<?= get_permalink($entry['ID']) ?>"><?= esc_html($entry['post_title']) ?></a>
    </li>
    <?php
    // loop end
    if ($entry === end($archives)) {
      echo "</ul>";
    }
    ?>
    <?php endforeach; ?>
    </section>
  </div>
</article>
<?php endwhile; ?>
