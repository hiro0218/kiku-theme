<template>
  <section v-if="title" class="entry-share">
    <template v-if="is_display.twitter">
      <a href="javascript:void(0)"
         class="icon icon-twitter"
         title="Share on Twitter"
         @click.stop="openWindow(twitter_url, 620, 310)"/>
    </template>
    <template v-if="is_display.facebook">
      <a href="javascript:void(0)"
         class="icon icon-facebook"
         title="Share on Facebook"
         @click.stop="openWindow(facebook_url, 560, 550)"/>
    </template>
    <template v-if="is_display.hatena">
      <a :href="hatena_url"
         target="_blank"
         class="icon icon-hatena"
         title="Share on Hatena Bookmark"/>
    </template>
    <template v-if="is_display.line">
      <a href="javascript:void(0)"
         class="icon icon-line"
         title="Share on LINE"
         @click.stop="openWindow(line_url, 560, 550)"/>
    </template>
  </section>
</template>

<script>
import copy from 'fast-copy';

export default {
  name: 'Share',
  props: {
    title: {
      type: String,
      default: '',
      required: true,
    },
  },
  data() {
    return {
      link: location.href,
    };
  },
  computed: {
    is_display: () => copy(WP.is_shared),
    twitter_url: function() {
      return `https://twitter.com/intent/tweet?url=${this.link}&text=${encodeURIComponent(this.title)}`;
    },
    facebook_url: function() {
      return `https://www.facebook.com/sharer/sharer.php?u=${this.link}`;
    },
    hatena_url: function() {
      return `http://b.hatena.ne.jp/add?url=${this.link}`;
    },
    line_url: function() {
      return `https://lineit.line.me/share/ui?url=${this.link}`;
    },
  },
  watch: {
    '$route.path': function() {
      this.link = location.href;
    },
  },
  methods: {
    openWindow(url, width, height) {
      const w = width || 480;
      const h = height || 450;
      const x = window.screen.width / 2 - w / 2;
      const y = window.screen.height / 2 - h / 2;
      const features = `width=${w},height=${h},top=${y},left=${x},menubar=0,toolbar=0,directories=0,toolbar=0,status=0,resizable=0`;

      window.open(url, '', features);
      return false;
    },
  },
};
</script>

<style lang="scss" scoped>
.entry-share {
  display: flex;
  justify-content: center;
  margin: 4rem 0;
}

.icon {
  @include svg-icon(2rem);

  &:hover {
    opacity: 0.8;
  }

  & + & {
    margin-left: 2rem;
  }
}

.icon-twitter {
  background-image: url('~@images/icon/twitter.svg');
}

.icon-facebook {
  background-image: url('~@images/icon/facebook.svg');
}

.icon-hatena {
  background-image: url('~@images/icon/hatenabookmark.svg');
}

.icon-line {
  background-image: url('~@images/icon/line.svg');
}
</style>
