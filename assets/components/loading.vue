<template>
  <div v-show="isLoading" class="loading-container">
    <img class="loading" src="../images/loading-spin.svg" width="64" height="64">
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Loading',
  computed: mapState(['isLoading']),
};
</script>

<style lang="scss" scoped>
.loading-container {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100vw;
  background: rgba($white, 0.5);
  z-index: 15;
}

.loading {
  position: fixed;
  top: 50%;
  left: 50%;
  margin: 0;
  z-index: 20;
}
</style>
