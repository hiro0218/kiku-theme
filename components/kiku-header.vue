<template>
  <div>
    <header class="header-navigation">
      <div class="container">
        <div class="header-title" v-if="navi.footer">
          <a v-bind:href="navi.site.url">{{ navi.site.name }}</a>
        </div>
        <div class="header-menu">
          <input id="drawer-trigger" class="drawer-checkbox" type="checkbox">
          <label for="drawer-trigger" class="drawer-trigger">
            <span class="icon-menu"></span>
          </label>
        </div>
      </div>
    </header>
  </div>
</template>

<script>
  export default {
    name: 'kiku-header',
    props: {
      navi: {
        type: Object,
        default: {},
        required: true,
      },
    },
    methods: {
      startDrawer() {
        var trigger = this.$el.querySelector('#drawer-trigger');
        if (!trigger) {
          return;
        }

        trigger.addEventListener('change', (e) => {
          if (trigger.checked) {
            this.focusSearchInput();
          }
          document.body.classList.toggle('open-drawer');
        });
      },
      focusSearchInput() {
        var search = document.querySelector('#widget_searchform');
        if (search) {
          search.focus();
        }
      },
    },
    mounted: function() {
      this.startDrawer();
    },
  };
</script>
