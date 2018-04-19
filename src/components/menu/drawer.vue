<template>
  <div class="drawer-container">
    <input id="drawer-trigger" class="drawer-checkbox" type="checkbox" @click="toggeleDrawer">
    <label for="drawer-trigger" class="drawer-trigger icon" v-html="iconMenu"/>
  </div>
</template>

<script>
import iconMenu from '@images/icon/menu.svg?inline';

export default {
  name: 'Drawer',
  data() {
    return {
      iconMenu,
    };
  },
  methods: {
    toggeleDrawer() {
      this.$store.commit('toggleSidebar');
    },
  },
};
</script>

<style lang="scss" scoped>
.icon /deep/ {
  @include svn-icon(1.5rem, $grey-700);
  cursor: pointer;
}
</style>
