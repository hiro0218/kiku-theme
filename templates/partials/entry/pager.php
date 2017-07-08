<div class="pager" v-if="pagers">
  <div class="columns is-gapless">
    <a v-if="pagers.prev" v-bind:href="pagers.prev.url" v-bind:title="pagers.prev.title" class="pager-previous column is-half">
      <span class="pager-icon"><i class="material-icons">chevron_left</i></span>
      <span class="pager-instruct">prev</span>
      <span class="pager-title">{{pagers.prev.title}}</span>
    </a>
    <a v-if="pagers.next" v-bind:href="pagers.next.url" v-bind:title="pagers.next.title" class="pager-next column is-half">
      <span class="pager-icon"><i class="material-icons">chevron_right</i></span>
      <span class="pager-instruct">next</span>
      <span class="pager-title">{{pagers.next.title}}</span>
    </a>
  </div>
</div>
