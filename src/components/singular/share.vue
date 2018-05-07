<template>
  <section v-if="title" class="entry-share">
    <template v-if="is_display.twitter">
      <a href="javascript:void(0)"
         class="icon icon-twitter"
         title="Share on Twitter"
         @click.stop="openWindow(twitter_url(), 620, 310)"/>
    </template>
    <template v-if="is_display.facebook">
      <a href="javascript:void(0)"
         class="icon icon-facebook"
         title="Share on Facebook"
         @click.stop="openWindow(facebook_url(), 560, 550)"/>
    </template>
    <template v-if="is_display.hatena">
      <a :href="hatena_url()"
         :data-hatena-bookmark-title="title"
         class="hatena-bookmark-button icon icon-hatena"
         title="Share on LINE"
         data-hatena-bookmark-layout="simple"/>
    </template>
    <template v-if="is_display.line">
      <a href="javascript:void(0)"
         class="icon icon-line"
         title="Share on LINE"
         @click.stop="openWindow(line_url(), 560, 550)"/>
    </template>
  </section>
</template>

<script>
import { cloneDeep } from 'lodash-es';

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
      is_display: cloneDeep(WP.is_shared),
      link: location.href,
    };
  },
  watch: {
    '$route.path': function() {
      this.link = location.href;
    },
  },
  mounted() {
    this.$nextTick().then(() => {
      if (!document.getElementById('bookmark_button')) {
        var script = document.createElement('script');
        script.id = 'bookmark_button';
        script.async = true;
        script.defer = true;
        script.src = 'https://cdn-ak.b.st-hatena.com/js/bookmark_button.js';
        document.body.appendChild(script);
      }
    });
  },
  methods: {
    twitter_url: function() {
      return `https://twitter.com/intent/tweet?url=${this.link}&text=${this.title}`;
    },
    facebook_url: function() {
      return `https://www.facebook.com/sharer/sharer.php?u=${this.link}`;
    },
    hatena_url: function() {
      return `http://b.hatena.ne.jp/entry/${this.link}`;
    },
    line_url: function() {
      return `https://lineit.line.me/share/ui?url=${this.link}`;
    },
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
  margin: 2rem 0;
}

.icon {
  margin-right: 1.5rem;
  @include svg-icon(1.5rem);

  &:hover {
    opacity: 0.8;
  }

  &:last-child {
    margin-right: 0;
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
