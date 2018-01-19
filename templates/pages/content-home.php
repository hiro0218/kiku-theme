<div class="container">
  <div class="entry-list">
    <h1 class="page-header"><?php echo App\title(); ?></h1>
    <entry-list :lists="lists"></entry-list>
  </div>

  <div>
    <?php echo get_option('kiku_insert_data_top_of_pagination'); ?>
  </div>

  <pagination :totalpages="headers.totalpages"></pagination>
</div>
