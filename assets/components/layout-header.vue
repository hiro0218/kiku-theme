<template>
  <div>
    <header class="header-navigation">
      <div class="container" v-if="navigation">
        <div class="header-title">
          <a :href="navigation.site.url">{{ navigation.site.name }}</a>
        </div>
        <div class="header-menu">
          <search-box />
          <menu-button />
        </div>
      </div>
    </header>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import searchBox from '@components/form/search-box.vue';
import menuButton from '@components/form/menu-button.vue';
import headerScroll from 'header-scroll-up';

export default {
  name: 'LayoutHeader',
  components: {
    searchBox,
    menuButton,
  },
  computed: mapState(['navigation']),
  mounted: function() {
    headerScroll.setScrollableHeader('.header-navigation', {
      topOffset: 100,
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
