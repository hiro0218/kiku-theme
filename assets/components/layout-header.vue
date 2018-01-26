<template>
  <div>
    <header class="header-navigation">
      <div class="container" v-if="navigation">
        <div class="header-title">
          <a v-bind:href="navigation.site.url">{{ navigation.site.name }}</a>
        </div>
        <div class="header-menu">
          <input type="checkbox" id="drawer-trigger" class="drawer-checkbox" @click="toggeleDrawer">
          <label for="drawer-trigger" class="drawer-trigger">
            <span class="icon-menu"></span>
          </label>
        </div>
      </div>
    </header>
  </div>
</template>

<script>
  import headerScroll from 'header-scroll-up';

  export default {
    name: 'layout-header',
    data() {
      return {
        searchForm: null,
      }
    },
    methods: {
      toggeleDrawer(e) {
        if (e.target.checked) {
          this.focusSearchInput();
        }
        document.body.classList.toggle('open-drawer');
      },
      focusSearchInput() {
        let input = this.searchForm || (this.searchForm = document.querySelector("#widget_searchform"));
        input.focus();
      },
    },
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
  box-shadow: 0 2px 2px -2px rgba(0, 0, 0, .25);
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
