<template>
  <div>
    <label for="drawer-trigger" class="drawer-overlay"/>
    <aside class="sidebar drawer" data-comes-from="left" v-html="themes.widget"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Sidebar',
  computed: mapState(['themes', 'isOpenSidebar']),
  mounted() {
    // サイドバーが始めて開いた場合のみ、データを取得する
    let unwatch = this.$watch('isOpenSidebar', function(isOpen) {
      if (isOpen) {
        this.$store.dispatch('requestThemes');
        unwatch();
      }
    });
  },
};
</script>

<style lang="scss">
// sidebar
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
      color: inherit;
      background: $grey-200;
    }
  }
}

.widget-title {
  padding-left: 0.75rem;
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

// drawer
.drawer-trigger {
  &:hover {
    cursor: pointer;
  }
}

.open-drawer {
  overflow: hidden !important;

  .drawer {
    transform: translate3d(0, 0, 0);
    opacity: 1;
    overflow-x: hidden;
    overflow-y: auto;
  }

  .drawer-overlay {
    opacity: 1;
    visibility: visible;
  }
}

.drawer-checkbox {
  position: absolute;
  top: 0;
  right: 0;
  width: 0;
  height: 0;
  opacity: 0;
}

.drawer {
  position: fixed;
  top: 0;
  bottom: 0;
  right: 0;
  width: calc(100vw / 1.618);
  height: 100%;
  max-height: 100%;
  transform: translate3d(100%, 0, 0);
  transition: opacity 0.2s ease, transform 0.5s ease;
  background: #fff;
  opacity: 0;
  z-index: 25;
}

.drawer-overlay {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  transition: opacity 0.5s ease, visibility 0.2s ease;
  background: rgba(0, 0, 0, 0.5);
  opacity: 0;
  visibility: hidden;
  z-index: 20;
}
</style>
