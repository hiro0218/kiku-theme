<template>
  <section v-if="title" class="entry-share">
    <template v-if="is_display.twitter">
      <a href="javascript:void(0)"
         class="btn-twitter"
         title="Share on Twitter"
         @click.stop="openWindow(twitter_url(), 620, 310)"
         v-html="icon.twitter"/>
    </template>
    <template v-if="is_display.facebook">
      <a href="javascript:void(0)"
         class="btn-facebook"
         title="Share on Facebook"
         @click.stop="openWindow(facebook_url(), 560, 550)"
         v-html="icon.facebook"/>
    </template>
    <template v-if="is_display.hatena">
      <a :href="hatena_url()"
         :data-hatena-bookmark-title="title"
         class="hatena-bookmark-button btn-hatena"
         title="Share on LINE"
         data-hatena-bookmark-layout="simple"
         v-html="icon.hatena"/>
    </template>
    <template v-if="is_display.line">
      <a href="javascript:void(0)"
         class="btn-line"
         title="Share on LINE"
         @click.stop="openWindow(line_url(), 560, 550)"
         v-html="icon.line"/>
    </template>
  </section>
</template>

<script>
import iconTwitter from '@/images/icon/twitter.svg?inline';
import iconFacebook from '@/images/icon/facebook.svg?inline';
import iconHatena from '@/images/icon/hatenabookmark.svg?inline';
import iconLine from '@/images/icon/line.svg?inline';

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
      is_display: WP.is_shared,
      link: location.href,
      icon: {
        twitter: iconTwitter,
        facebook: iconFacebook,
        hatena: iconHatena,
        line: iconLine,
      },
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
$twitter-color: #55acee;
$facebook-color: #3b5998;
$hatena-color: #00a4de;
$line-color: #00b900;

.entry-share /deep/ {
  margin: 2rem 0;
  line-height: 1rem;

  a {
    display: inline-block;
    width: 1.5rem;
    height: 1.5rem;

    & + a {
      margin-left: 1.5rem;
    }
  }

  svg path {
    fill: $grey-400;
    transition: fill 0.4s ease;
  }

  .btn-twitter:hover svg path {
    fill: $twitter-color;
  }

  .btn-facebook:hover svg path {
    fill: $facebook-color;
  }

  .btn-hatena:hover svg path {
    fill: $hatena-color;
  }

  .btn-line:hover svg path {
    fill: $line-color;
  }
}
</style>
