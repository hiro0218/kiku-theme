<template>
  <div class="drawer-container">
    <input type="checkbox" id="drawer-trigger" class="drawer-checkbox" @click="toggeleDrawer">
    <label for="drawer-trigger" class="drawer-trigger">
      <span class="icon-menu"/>
    </label>
  </div>
</template>

<script>
export default {
  name: 'MenuButton',
  methods: {
    toggeleDrawer() {
      this.$store.commit('toggleSidebar');
    },
  },
};
</script>
