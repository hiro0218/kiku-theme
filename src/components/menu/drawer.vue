<template>
  <div class="drawer-container">
    <input id="drawer-trigger" class="drawer-checkbox" type="checkbox" @click="toggeleDrawer">
    <label for="drawer-trigger" class="drawer-trigger icon-menu"/>
  </div>
</template>

<script>
export default {
  name: 'Drawer',
  methods: {
    toggeleDrawer() {
      this.$store.commit('toggleSidebar');
    },
  },
};
</script>

<style lang="scss" scoped>
.icon-menu {
  background-image: url('~@images/icon/menu.svg?fill=#{$grey-700} svg');
  cursor: pointer;
  @include svg-icon(1.5rem);
}
</style>
