<?php
/*
 * Template Name: Monthly Archive
 */

global $wpdb;

$sql = "SELECT ID, post_title, post_date
        FROM $wpdb->posts
        WHERE post_status = 'publish'
          AND post_date <= now()
          AND post_type = 'post'
        ORDER BY post_date DESC";
$archives = $wpdb->get_results($sql, ARRAY_A);
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
        echo "<ul class='archive-list'>";
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
