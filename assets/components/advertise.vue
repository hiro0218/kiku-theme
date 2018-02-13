<template>
  <div class="ads-container" :id="idName" v-if="content">
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
      default: '',
      required: true,
    },
    script: {
      type: String,
      default: '',
      required: true,
    },
  },
  watch: {
    content: function() {
      this.$nextTick().then(() => {
        eval(this.script);
      });
    },
  },
};
</script>

<style>
.ads-container {
  margin: 2rem 0;
  text-align: center;
}
</style>
