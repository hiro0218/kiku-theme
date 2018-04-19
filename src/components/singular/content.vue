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
    '$route.path': function() {
      this.initStyleElement();
    },
    'post.content.rendered': function() {
      if (!this.post.content.rendered) {
        return;
      }
      this.$nextTick().then(() => {
        if (this.post.hasOwnProperty('attach')) {
          this.setCustomStyle();
          this.setCustomScript();
        }
      });
    },
  },
  created() {
    this.styleElement = document.getElementById('custom_style');
  },
  methods: {
    initStyleElement: function() {
      if (!this.styleElement) {
        let element = document.createElement('style');
        element.id = 'custom_style';
        document.head.appendChild(element);
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

  a {
    padding-bottom: 1px;
    border-bottom: 1px solid $link-border-color;
    color: $link-color;

    &:hover {
      border-color: $link-color;
    }
    &:focus {
      outline: thin dotted;
      outline-offset: -2px;
    }
  }

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
