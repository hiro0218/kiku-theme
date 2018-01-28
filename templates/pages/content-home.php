<div class="container">
  <entry-list :total="headers.total" :page_title="page_title" :posts="posts"></entry-list>
  <div>
    <home-content></home-content>
  </div>
  <entry-pagination :totalpages="headers.totalpages"></pagination>
</div>
