<?php
/*
 * Template Name: Archive
 */

$DB = new \Kiku\DB();
$archives = $DB->get_archive_list(); ?>
<?php while (have_posts()) : the_post(); ?>
<article class="entry mdl-cell mdl-cell--12-col">
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
  </header>
  <div class="entry-content">
    <section>
      <?php
      // 年別に整理
      $store;
      foreach($archives as $entry) {
        $store[$entry['post_year']][] = [
          'id'    => $entry['ID'],
          'date'  => strtotime($entry['post_date']),
          'title' => $entry['post_title']
        ];
      }
      ?>
      <?php foreach($store as $year => $value): ?>
      <h2><?= $year ?></h2>
      <ul class="page-archive-list">
        <?php foreach($value as $entry): ?>
        <li>
          <time datetime="<?= date(DATE_W3C, $entry['date']) ?>"><?= date('M d', $entry['date']) ?></time>
          <a href="<?= get_permalink($entry['id']) ?>"><?= esc_html($entry['title']) ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endforeach;?>
    </section>
  </div>
</article>
<?php endwhile; ?>
