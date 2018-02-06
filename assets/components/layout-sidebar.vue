<template>
  <div>
    <label for="drawer-trigger" class="drawer-overlay"/>
    <aside class="sidebar drawer" data-comes-from="left" v-html="navigation.widget"/>
  </div>
</template>

<script>
export default {
  name: 'LayoutSidebar',
};
</script>

<style lang="scss" scoped>
.sidebar {
  padding: 0.5rem 0;

  ul {
    margin-top: 0;
    padding: 0;
    list-style: none;
  }

  a {
    display: block;
    padding: 1rem 1.5rem;
    color: $grey-600;
    font-size: $font-size-sm;
    &:hover {
      background: $blue-50;
    }
  }
}

.widget-title {
  margin-bottom: 0.5rem;
  padding: 0 0 0 0.75rem;
  font-size: $font-size-h4;
}

.widget_categories {
  ul.children {
    a {
      padding-left: 2rem;
    }
    .children a {
      padding-left: 3rem;
    }
  }
}
</style>
