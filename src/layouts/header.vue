<template>
  <header class="header-navigation">
    <div class="container">
      <div class="header-title">
        <router-link :to="site.url | formatBaseLink">{{ site.name }}</router-link>
      </div>
      <div class="header-menu">
        <search />
        <drawer />
      </div>
    </div>
  </header>
</template>

<script>
import search from '@components/menu/search.vue';
import drawer from '@components/menu/drawer.vue';
import headerScroll from 'header-scroll-up';
import { cloneDeep } from 'lodash-es';

export default {
  name: 'Header',
  components: {
    search,
    drawer,
  },
  data() {
    return {
      site: cloneDeep(WP.site),
    };
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
  display: flex;
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  flex-wrap: wrap;
  align-items: center;
  height: $header-nav-height;
  background: #fff;
  box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.25);
  overflow: hidden;
  z-index: 10;

  > .container {
    display: flex;
    align-items: stretch;
    width: 100%;
    height: 100%;
  }
}

.header-title,
.header-menu {
  display: flex;
  flex: 1;
  align-items: stretch;
  line-height: $header-nav-height;
}

.header-title {
  justify-content: flex-start;
  color: $grey-900;
  font-size: 1rem;
  white-space: nowrap;
  a {
    color: inherit;
  }
}

.header-menu {
  justify-content: flex-end;
  font-size: 1.5rem;
}
</style>
