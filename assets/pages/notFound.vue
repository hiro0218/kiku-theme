<template>
  <div class="container">
    <h1 class="title">Page Not Found</h1>
    <p class="description">The page you were looking for could not be found.</p>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
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
