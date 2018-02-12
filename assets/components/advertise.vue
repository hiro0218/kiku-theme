<template>
  <div class="ads-container">
    <div v-html="content"/>
  </div>
</template>

<script>
export default {
  name: 'Advertise',
  props: {
    content: {
      type: String,
      required: true,
    },
    script: {
      type: String,
      required: true,
    },
  },
  mounted() {
    eval(this.script);
  },
};
</script>

<style>
.ads-container {
  text-align: center;
}
</style>
