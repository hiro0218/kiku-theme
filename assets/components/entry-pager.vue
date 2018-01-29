<template>
  <div class="pager" v-cloak>
    <div class="pager-container">
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

<style lang="scss" scoped>
.pager {
  margin: 2rem 0;
}

.pager-container {
  display: flex;

  a {
    display: flex;
    flex: none;
    flex-direction: column;
    width: 50%;
    padding: 1rem 0;

    &:only-child {
      flex-grow: 1;
    }
  }

  .pager-prev {
    padding-right: 1rem;
    text-align: left;
    .pager-icon {
      margin-right: .5rem;
    }
    .pager-title {
      margin-left: 1.5rem;
    }
  }

  .pager-next {
    padding-left: 1rem;
    text-align: right;
    .pager-icon {
      margin-left: .5rem;
    }
    .pager-title {
      margin-right: 1.5rem;
    }
  }

  .pager-icon {
    color: $grey-800;
    font-size: $font-size-sm;
  }

  .pager-label {
    color: $grey-400;
    font-weight: bold;
    text-transform: capitalize;
  }

  .pager-title {
    color: $grey-600;
    @include text-overflow;
  }

}
</style>
