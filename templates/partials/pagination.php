<nav class="pagination" v-if="pagination">
  <ul>
    <li class="pagination-first" v-if="pagination.first">
      <a href="/"><i class="material-icons">first_page</i></a>
    </li>
    <li class="pagination-previous" v-if="pagination.prev">
      <a v-bind:href="'/page/' + pagination.prev"><i class="material-icons">chevron_left</i></a>
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
      <a v-bind:href="'/page/' + pagination.next"><i class="material-icons">chevron_right</i></a>
    </li>
    <li class="pagination-last" v-if="pagination.last">
      <a v-bind:href="'/page/' + pagination.last"><i class="material-icons">last_page</i></a>
    </li>
  </ul>
</nav>
