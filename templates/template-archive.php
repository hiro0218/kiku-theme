<?php
/*
 * Template Name: Monthly Archive
 */

global $wpdb;

$sql = "SELECT DISTINCT MONTH( post_date ) AS month, YEAR( post_date ) AS year, COUNT( id ) AS count
        FROM $wpdb->posts
        WHERE post_status = 'publish'
          AND post_date <= now()
          AND post_type = 'post'
        GROUP BY month, year
        ORDER BY post_date DESC";
$months = $wpdb->get_results($sql);
?>
<article class="entry mdl-cell mdl-cell--12-col">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
  </header>
  <div class="entry-content">
    <section>
      <?php
        $tmp_year = null;
        foreach ($months as $row):
          $year = $row->year;
          $month = $row->month;

          if ($tmp_year != $year) {
            // ループの最初以外
            if ($month !== reset($months)) {
              echo '</ul>';  // 前のループのタグを閉じる
            }

            echo '<h2>'. $year .'</h2>';
            echo '<ul class="archive-list">';
        }
        ?>
        <li>
          <a href="<?= BLOG_URL ?><?= $year; ?>/<?= str_pad($month, 2, 0, STR_PAD_LEFT); ?>">
            <?= jdmonthname($month, 1); ?> (<?= $row->count; ?>)
          </a>
        </li>
        <?php
            // 次のループに渡す
            $tmp_year = $year;

            // ループが最後のとき
            if ($month === end($months)) {
              echo "</ul>"; // タグを閉じる
            }

          endforeach;
        ?>
    </section>
  </div>
</article>
