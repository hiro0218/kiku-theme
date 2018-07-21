<template>
  <div id="attach" />
</template>

<script>
export default {
  name: 'EntryAttach',
  props: {
    attach: {
      type: Object,
      default: () => {},
      require: false,
    },
  },
  data() {
    return {
      styleElement: null,
    };
  },
  watch: {
    attach: 'initAttach',
  },
  mounted() {
    this.initAttach();
  },
  methods: {
    initAttach: function() {
      this.initStyleElement();

      this.$nextTick().then(() => {
        this.setStyle();
        this.setScript();
      });
    },
    initStyleElement: function() {
      // style要素を初期化
      if (this.styleElement) {
        this.styleElement.innerHTML = '';
        return;
      }

      // style要素がない場合は作成
      let element = document.createElement('style');
      element.id = 'custom_style';
      this.$el.appendChild(element);
      this.styleElement = document.getElementById('custom_style');
    },
    setStyle: function() {
      if (this.attach.custom.style) {
        this.styleElement.innerHTML = this.attach.custom.style;
      }
    },
    setScript: function() {
      if (this.attach.custom.script) {
        eval(this.attach.custom.script);
      }
    },
  },
};
</script>

<style>
</style>
