<template>
  <section class="entry-share" v-if="title">
    <template v-if="is_display.twitter">
      <a href="javascript:void(0)" class="btn-twitter"
         title="Share on Twitter"
         :data-url="twitter_url"
         data-width="620" data-height="310" @click="openWindows">
        <span class="icon-twitter"></span>
      </a>
    </template>
    <template v-if="is_display.facebook">
      <a href="javascript:void(0)" class="btn-facebook"
         title="Share on Facebook"
         :data-url="facebook_url"
         data-width="560" data-height="550" @click="openWindows">
        <span class="icon-facebook"></span>
      </a>
    </template>
    <template v-if="is_display.hatena">
      <a :href="hatena_url" class="hatena-bookmark-button btn-hatena"
         title="Share on LINE"
         :data-url="hatena_url"
         :data-hatena-bookmark-title="title"
         data-hatena-bookmark-layout="simple">
        <span class="icon-hatena"></span>
      </a>
    </template>
    <template v-if="is_display.line">
      <a href="javascript:void(0)" class="btn-line"
         title="Share on LINE"
         :data-url="line_url"
         data-width="560" data-height="550" @click="openWindows">
        <span class="icon-line"></span>
      </a>
    </template>
  </section>
</template>

<script>
export default {
  name: 'entry-share',
  data() {
    return {
      is_display: WP.is_shared,
    };
  },
  props: {
    title: {
      type: String,
      default: '',
      required: true,
    },
    link: {
      type: String,
      default: '',
      required: true,
    },
  },
  computed: {
    twitter_url: function () {
      return `https://twitter.com/intent/tweet?url=${this.link}&text=${this.title}`;
    },
    facebook_url: function () {
      return `https://www.facebook.com/sharer/sharer.php?u=${this.link}`;
    },
    hatena_url: function () {
      return `http://b.hatena.ne.jp/entry/${this.link}`;
    },
    line_url: function () {
      return `https://lineit.line.me/share/ui?url=${this.link}`;
    },
  },
  mounted() {
    this.$nextTick().then(() => {
      var script = document.createElement('script');
      script.async = true;
      script.defer = true;
      script.src = 'https://cdn-ak.b.st-hatena.com/js/bookmark_button.js';
      document.body.appendChild(script);
    });
  },
  methods: {
    openWindows(e) {
      const target = e.target;
      const data = target.dataset;
      const w = data.width || 480;
      const h = data.height || 450;
      const x = window.screen.width / 2 - w / 2;
      const y = window.screen.height / 2 - h / 2;
      const features = `width=${w},height=${h},top=${y},left=${x},menubar=0,toolbar=0,directories=0,toolbar=0,status=0,resizable=0`;

      window.open(data.url, '', features);
      return false;
    },
  }
};
</script>

<style lang="scss" scoped>
$twitter-color: #55acee;
$facebook-color: #3b5998;
$hatena-color: #00a4de;
$line-color: #00B900;

.entry-share {
  display: flex;
  margin-bottom: 2rem;
  text-align: center;

  a {
    color: $white;
    font-size: 1.5rem;
    line-height: 1;
    &:hover {
      opacity: .8;
    }
    & + a {
      margin-left: 1rem;
    }
  }
}

.btn-twitter,
.btn-facebook,
.btn-line,
.btn-hatena {
  flex: auto;
  padding: .5rem .7rem;
  border-radius: .125rem;
}

.btn-twitter {
  background: $twitter-color;
}

.btn-facebook {
  background: $facebook-color;
}

.btn-hatena {
  background: $hatena-color;
}

.btn-line {
  background: $line-color;
}
</style>
