<template>
  <aside v-if="display" :id="idName" class="ads-container">
    <div v-html="content"/>
  </aside>
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
    display: {
      type: Boolean,
      default: true,
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
    '$route.path': 'runScript',
    content: 'runScript',
  },
  methods: {
    runScript: function() {
      this.$nextTick().then(() => {
        if (this.content) {
          eval(this.script);
        }
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
