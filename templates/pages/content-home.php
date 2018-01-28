<div class="container">
  <entry-list :total="headers.total" :page_title="page_title" :posts="posts"></entry-list>
  <home-content></home-content>
  <entry-pagination :totalpages="headers.totalpages"></pagination>
</div>
