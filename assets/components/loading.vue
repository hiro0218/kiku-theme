<template>
  <div class="loading-container">
    <img class="loading" src="../images/loading-spin.svg" width="64" height="64">
  </div>
</template>

<script>
export default {
  name: 'Loading',
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
