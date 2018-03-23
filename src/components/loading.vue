<template>
  <div v-show="isLoading" class="loading-container">
    <div class="loading" v-html="svgLoading"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import svgLoading from '@images/loading-spin.svg?inline';

export default {
  name: 'Loading',
  data() {
    return {
      svgLoading,
    };
  },
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
  width: 64px;
  height: 64px;
}
</style>
