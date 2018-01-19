<template>
  <div class="pager">
    <div class="pager-container container" v-cloak v-if="pagers">
      <a v-if="pagers.prev" v-bind:href="pagers.prev.url" v-bind:title="pagers.prev.title" class="pager-prev">
        <span class="pager-label">
          <span class="pager-icon icon-chevron_left"></span>previous
        </span>
        <span class="pager-title">{{pagers.prev.title}}</span>
      </a>
      <a v-if="pagers.next" v-bind:href="pagers.next.url" v-bind:title="pagers.next.title" class="pager-next">
        <span class="pager-label">
          next<span class="pager-icon icon-chevron_right"></span>
        </span>
        <span class="pager-title">{{pagers.next.title}}</span>
      </a>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'entry-pager',
    props: {
      pagers: {
        type: Object,
        default: {},
        required: false,
      },
    },
  };
</script>
