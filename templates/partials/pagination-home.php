<nav class="pagination">
  <ul>
    <li class="pagination-first" v-if="pagination.label.first">
      <a v-bind:href="pagination.links.first"><span class="icon-first_page"></span></a>
    </li>
    <li class="pagination-previous" v-if="pagination.label.prev">
      <a v-bind:href="pagination.links.prev"><span class="icon-chevron_left"></span></a>
    </li>
    <template v-for="(pages, index) in pagination.pages">
      <template v-if="pagination.label.active == index">
        <li class="pagination-active">
          <span>{{pagination.label.active | zeroPadding}}</span>
        </li>
      </template>
      <template v-else>
        <li>
          <a v-bind:href="pages.links">{{index | zeroPadding}}</a>
        </li>
      </template>
    </template>
    <li class="pagination-next" v-if="pagination.label.next">
      <a v-bind:href="pagination.links.next"><span class="icon-chevron_right"></span></a>
    </li>
    <li class="pagination-last" v-if="pagination.label.last">
      <a v-bind:href="pagination.links.last"><span class="icon-last_page"></span></a>
    </li>
  </ul>
</nav>
