<div class="container">
  <entry-list :total="headers.total" :page_title="page_title" :posts="posts"></entry-list>
  <div>
    <?php echo get_option('kiku_insert_data_top_of_pagination'); ?>
  </div>
  <pagination :totalpages="headers.totalpages"></pagination>
</div>
