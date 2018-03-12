<template>
  <div v-cloak v-if="product">
    <div :style="{ 'background-image': 'url('+ product.LargeImage +')' }" class="amazon-product">
      <a :href="product.DetailPageURL" target="_blank">
        <div class="product-image">
          <img :src="product.LargeImage" data-zoom-disabled="true">
        </div>
        <div class="product-title">
          <span class="amazon-title">{{ product.Title }}</span>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Amazon',
  props: {
    product: {
      type: Object,
      default: null,
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.amazon-product {
  position: relative;
  margin: 1rem 0;
  padding: 1rem;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  text-align: center;
  overflow: hidden;
  z-index: 0;

  &::before {
    position: absolute;
    top: -6px;
    right: -6px;
    bottom: -6px;
    left: -6px;
    background: inherit;
    content: '';
    z-index: -1;
    filter: blur(6px);
  }

  a {
    display: block;
    padding: 0;
    border: 0;
    color: $grey-600;

    &:focus {
      outline: 0;
    }
  }

  img {
    max-width: 10rem;
    max-height: 10rem;
    margin: auto;
  }
}

.amazon-title {
  display: block;
  color: $white;
  font-weight: bold;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4), -2px -2px 1px rgba(0, 0, 0, 0.08);
}
</style>
