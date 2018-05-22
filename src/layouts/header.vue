<template>
  <header class="header-navigation">
    <div class="container">
      <div class="title">
        <router-link :to="site.url | formatBaseLink">{{ site.name }}</router-link>
      </div>
      <div class="menu">
        <search class="menu-item" />
      </div>
    </div>
  </header>
</template>

<script>
import search from '@components/menu/search.vue';
import headerScroll from 'header-scroll-up';
import copy from 'fast-copy';

export default {
  name: 'Header',
  components: {
    search,
  },
  computed: {
    site: () => copy(WP.site),
  },
  mounted: function() {
    headerScroll.setScrollableHeader('.header-navigation', {
      topOffset: 0,
    });
  },
};
</script>

<style lang="scss" scoped>
.header-navigation {
  position: fixed;
  top: 0;
  left: 0;
  height: $header-nav-height;
  background: #fff;
  box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.25);
  z-index: 10;

  > .container {
    display: flex;
    width: 100%;
    height: 100%;
  }

  .title,
  .menu {
    display: flex;
    flex: 1;
    align-items: center;
  }

  .title {
    justify-content: flex-start;
    color: $grey-900;
    font-size: 1rem;
    letter-spacing: 0.125rem;
    white-space: nowrap;

    a {
      height: $header-nav-height;
      line-height: $header-nav-height;
      color: inherit;
    }
  }

  .menu {
    justify-content: flex-end;
  }

  .menu-item {
    display: flex;
    align-items: center;
  }
}
</style>
