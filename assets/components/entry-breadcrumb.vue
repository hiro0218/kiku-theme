<template>
  <div class="breadcrumb-container container" v-if="title">
    <nav class="breadcrumb">
      <ol>
        <li>
          <span class="icon-home"></span>
          <a v-bind:href="navigation.site.url">{{ navigation.site.name }}</a>
        </li>
        <li v-for="(category,index) in categories" v-cloak v-bind:key="index">
          <a v-bind:href="category.link">{{ category.name }}</a>
        </li>
        <li class="breadcrumb-active">
          <span class="icon-location_on"></span>
          <a href="" v-html="$options.filters.escapeBrackets(title)"></a>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script>
  export default {
    name: 'entry-breadcrumb',
    props: {
      title: {
        type: String,
        default: '',
        required: true,
      },
      categories: {
        type: Array,
        default: [],
        required: false,
      },
    },
  };
</script>

<style lang="scss" scoped>
.breadcrumb-container {
  background: $grey-100;
}

.breadcrumb {
  padding: 2rem 0;
  line-height: 1.5rem;
  white-space: nowrap;
  overflow: scroll;
  color: $grey-600;

  a {
    color: inherit;
    &:hover {
      text-decoration: underline;
    }
  }

  ol {
    margin-bottom: 0;
    padding: 0;
    font-size: 0;
    list-style: none;
  }

  li {
    display: inline-flex;
    font-size: $font-size-sm;
    line-height: 1;
    vertical-align: middle;

    & + li {
      margin-left: .25rem;
      &::before {
        // .icon-keyboard_arrow_right;
        content: "\e907";
        font-family: 'icon';
        line-height: 1rem;
      }
    }
  }

  .icon-home,
  .icon-location_on {
    margin-right: .25rem;
  }

}
</style>
