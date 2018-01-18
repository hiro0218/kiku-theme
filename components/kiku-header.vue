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
    name: 'kiku-header',
    methods: {
      toggeleDrawer(e) {
        if (e.target.checked) {
          this.focusSearchInput();
        }
        document.body.classList.toggle('open-drawer');
      },
      focusSearchInput() {
        var search = document.querySelector('#widget_searchform');
        if (search) {
          search.focus();
        }
      },
    },
    mounted: function() {
      headerScroll.setScrollableHeader('.header-navigation', {
        topOffset: 100,
      });
    },
  };
</script>
