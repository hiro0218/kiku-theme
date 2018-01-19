<template>
  <div v-cloak v-if="amazon_product">
    <div class="amazon-product" v-bind:style="{ 'background-image': 'url('+ amazon_product.LargeImage +')' }">
      <a v-bind:href="amazon_product.DetailPageURL" target="_blank">
        <div class="product-image">
          <img v-bind:src="amazon_product.LargeImage" data-zoom-disabled="true">
        </div>
        <div class="product-title">
          <span class="amazon-title">{{amazon_product.Title}}</span>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'amazon-product',
    props: {
      amazon_product: {
        type: Object,
        default: null,
        required: false,
      },
    },
  };
</script>
