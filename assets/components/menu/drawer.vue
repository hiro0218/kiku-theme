<template>
  <div class="drawer-container">
    <input id="drawer-trigger" class="drawer-checkbox" type="checkbox" @click="toggeleDrawer">
    <label for="drawer-trigger" class="drawer-trigger icon" v-html="iconMenu"/>
  </div>
</template>

<script>
import iconMenu from '@/images/icon/menu.svg?inline';

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
  display: inline-block;
  vertical-align: middle;
  text-align: center;
  width: 1.5rem;
  height: 1.5rem;
  cursor: pointer;

  svg {
    display: block;
    fill: $grey-700;
  }
}
</style>
