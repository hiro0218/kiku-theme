<template>
  <div class="breadcrumb-container" v-if="title">
    <div class="container" v-if="navigation">
      <nav class="breadcrumb">
        <ol>
          <li>
            <span class="icon-home"/>
            <a :href="navigation.site.url">{{ navigation.site.name }}</a>
          </li>
          <li v-for="(category,index) in categories" v-cloak :key="index">
            <a :href="category.link">{{ category.name }}</a>
          </li>
          <li class="breadcrumb-active">
            <span class="icon-location_on"/>
            <a href="" v-html="$options.filters.escapeBrackets(title)"/>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'EntryBreadcrumb',
  props: {
    title: {
      type: String,
      default: '',
      required: true,
    },
    categories: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
  computed: mapState(['navigation']),
};
</script>

<style lang="scss" scoped>
.breadcrumb-container {
  padding: 2rem 0;
  background: $grey-100;
}

.breadcrumb {
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
      margin-left: 0.25rem;
      &::before {
        // .icon-keyboard_arrow_right;
        content: '\e907';
        font-family: 'icon';
        line-height: 1rem;
      }
    }
  }

  .icon-home,
  .icon-location_on {
    margin-right: 0.25rem;
  }
}
</style>
