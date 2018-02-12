<template>
  <div class="ads-container" :id="idName">
    <div v-html="content"/>
  </div>
</template>

<script>
export default {
  name: 'Advertise',
  props: {
    idName: {
      type: String,
      default: '',
      required: false,
    },
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
  margin: 2rem 0;
  text-align: center;
}
</style>
