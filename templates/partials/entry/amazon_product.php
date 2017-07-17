<div class="amazon-product" v-cloak v-bind:style="{ 'background-image': 'url('+ amazon_product.LargeImage.URL +')' }" v-if="amazon_product">
  <a v-bind:href="amazon_product.DetailPageURL" class="columns is-multiline is-vcentered">
    <div class="column is-12">
      <img v-bind:src="amazon_product.LargeImage.URL" data-zoom-disabled="true">
    </div>
    <div class="column is-12">
      <span class="amazon-title">{{amazon_product.ItemAttributes.Title}}</span>
    </div>
  </a>
</div>
