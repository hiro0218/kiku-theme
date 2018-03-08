<template>
  <section class="entry-content" v-html="content"/>
</template>

<script>
export default {
  name: 'EntryContent',
  props: {
    content: {
      type: String,
      default: '',
    },
  },
};
</script>

<style lang="scss" scoped>
.entry-content /deep/ {
  margin-bottom: 1rem;

  a {
    padding-bottom: 1px;
    border-bottom: 1px solid $link-border-color;
    color: $link-color;

    &:hover {
      border-color: $link-color;
    }
    &:focus {
      outline: thin dotted;
      outline-offset: -2px;
    }
  }

  .anchor {
    position: absolute;
    right: 100%;
    border: 0;
    color: $grey-400;
    font-family: $font-family-monospace;
    user-select: none;
    @include until($desktop) {
      position: static;
    }
  }

  li + li {
    margin-top: 0.25rem;
  }

  > hr {
    height: 2rem;
    margin: 2rem 0;
    border: 0;
    color: $grey-600;
    font-size: $font-size-h2;
    line-height: 1;
    text-align: center;

    &::before {
      content: '***';
    }
  }
}
</style>
