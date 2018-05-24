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
import copy from 'fast-copy';

export default {
  name: 'Header',
  components: {
    search,
  },
  data() {
    return {
      eleHeader: null,
      classes: {
        unpinned: 'unpin',
      },
      lastKnownScrollY: 0,
      ticking: false,
    };
  },
  computed: {
    site: () => copy(WP.site),
  },
  mounted: function() {
    this.eleHeader = document.querySelector('.header-navigation');
    document.addEventListener('scroll', this.handleScroll, false);
  },
  methods: {
    onScroll() {
      this.ticking = false;
      let currentScrollY = window.pageYOffset;

      if (currentScrollY < this.lastKnownScrollY) {
        this.eleHeader.classList.remove(this.classes.unpinned);
      } else {
        this.eleHeader.classList.add(this.classes.unpinned);
      }

      this.lastKnownScrollY = currentScrollY;
    },
    handleScroll() {
      if (!this.ticking) {
        requestAnimationFrame(this.onScroll);
      }
      this.ticking = true;
    },
  },
};
</script>

<style lang="scss" scoped>
.header-navigation {
  position: fixed;
  top: 0;
  left: 0;
  height: $header-nav-height;
  width: 100%;
  background: #fff;
  box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.25);
  will-change: transform;
  transition: transform 0.25s $animation-curve-fast-out-slow-in;
  z-index: 10;

  &.unpin {
    transform: translateY($header-nav-height * -1);
  }

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
