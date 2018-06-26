<template>
  <section class="entry-content" v-html="post.content.rendered"/>
</template>

<script>
export default {
  name: 'EntryContent',
  props: {
    post: {
      type: Object,
      default: () => {},
      require: true,
    },
  },
  data() {
    return {
      styleElement: null,
    };
  },
  watch: {
    'post.content.rendered': function() {
      this.$nextTick().then(() => {
        this.fireCustomAppearance();
      });
    },
  },
  mounted() {
    this.fireCustomAppearance();
  },
  methods: {
    fireCustomAppearance: function() {
      if (this.post.hasOwnProperty('attach')) {
        if (this.post.attach.custom.style) this.setCustomStyle();
        if (this.post.attach.custom.script) this.setCustomScript();
      }
    },
    initStyleElement: function() {
      if (!this.styleElement) {
        let element = document.createElement('style');
        element.id = 'custom_style';
        this.$el.parentNode.insertBefore(element, this.$el.nextSibling);
        this.styleElement = document.getElementById('custom_style');
      }

      this.styleElement.innerHTML = '';
    },
    setCustomStyle: function() {
      this.initStyleElement();
      if (this.post.attach.custom.style) {
        this.styleElement.innerHTML = this.post.attach.custom.style;
      }
    },
    setCustomScript: function() {
      if (this.post.attach.custom.script) {
        eval(this.post.attach.custom.script);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.entry-content /deep/ {
  margin-bottom: 1rem;

  .anchor {
    position: absolute;
    right: 100%;
    border: 0;
    color: $grey-400;
    font-family: $font-family-monospace;
    user-select: none;
    @include until($desktop) {
      position: static;
    }
  }

  img {
    margin-bottom: 2rem;
  }

  li + li {
    margin-top: 0.25rem;
  }

  > hr {
    height: 2rem;
    margin: 2rem 0;
    border: 0;
    color: $grey-600;
    font-size: $font-size-h2;
    text-align: center;

    &::before {
      content: '***';
    }
  }
}
</style>
