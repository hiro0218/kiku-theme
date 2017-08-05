<nav class="pagination">
  <ul>
    <li class="pagination-first" v-if="pagination.first">
      <a href="/"><span class="icon-first_page"></span></a>
    </li>
    <li class="pagination-previous" v-if="pagination.prev">
      <a v-bind:href="'/page/' + pagination.prev"><span class="icon-chevron_left"></span></a>
    </li>
    <template v-for="(pages, index) in pagination.pages">
      <template v-if="pagination.active == pages">
        <li class="pagination-active">
          <span>{{pagination.active | zeroPadding}}</span>
        </li>
      </template>
      <template v-else>
        <li>
          <a v-bind:href="'/page/' + pages">{{pages | zeroPadding}}</a>
        </li>
      </template>
    </template>
    <li class="pagination-next" v-if="pagination.next">
      <a v-bind:href="'/page/' + pagination.next"><span class="icon-chevron_right"></span></a>
    </li>
    <li class="pagination-last" v-if="pagination.last">
      <a v-bind:href="'/page/' + pagination.last"><span class="icon-last_page"></span></a>
    </li>
  </ul>
</nav>
