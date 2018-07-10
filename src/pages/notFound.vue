<template>
  <div class="container">
    <h1 class="title">{{ pageTitle }}</h1>
    <p class="description">The page you were looking for could not be found.</p>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
  metaInfo() {
    return {
      title: this.pageTitle,
    };
  },
  computed: {
    pageTitle: () => 'Page Not Found',
  },
  mounted() {
    this.$store.commit('setPageTitle', this.pageTitle);
  },
};
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 100%;
  text-align: center;
}

.description {
  font-size: $font-size-lg;
}
</style>
