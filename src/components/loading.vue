<template>
  <div :class="{ 'fadeOut': !isLoading }" class="loading-container">
    <div class="loading"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Loading',
  computed: {
    elementHTML: () => document.querySelector('html'),
    ...mapState(['isLoading']),
  },
  watch: {
    isLoading: function(bool) {
      this.elementHTML.classList.toggle('lock-scroll', this.isLoading);
    },
  },
};
</script>

<style lang="scss">
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
  $size: 64px;
  position: fixed;
  top: 50%;
  left: 50%;
  margin: 0;
  z-index: 20;
  width: $size;
  height: $size;
  margin-top: ($size / 2) * -1;
  margin-left: ($size / 2) * -1;
  background-image: url('~@images/loading-spin.svg');
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
