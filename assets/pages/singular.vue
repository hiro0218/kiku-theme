<template>
  <div>
    <div class="container">
      <article class="entry">
        <header class="entry-header">
          <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title)"/>
          <div class="entry-meta">
            <entry-time :date="post.date"/>
            <entry-category :categories="post.categories"/>
          </div>
        </header>
        <entry-content :content="post.content"/>
        <advertise :id-name="'ads2'" :display="advertise.ads2.display.includes($route.meta.type)" :content="advertise.ads2.content" :script="advertise.ads2.script" />
        <template v-if="$route.meta.type === 'post'">
          <amazon-product :amazon_product="post.amazon_product"/>
          <footer class="entry-footer">
            <entry-tag :tags="post.tags"/>
            <entry-share :title="post.title"/>
            <entry-pager :pagers="post.attach.pagers"/>
          </footer>
        </template>
      </article>
    </div>

    <template v-if="$route.meta.type === 'post'">
      <entry-related :relateds="post.attach.relateds"/>
    </template>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

import amazonProduct from '@components/amazon-product.vue';
import entryCategory from '@components/entry-category.vue';
import entryPager from '@components/entry-pager.vue';
import entryRelated from '@components/entry-related.vue';
import entryShare from '@components/entry-share.vue';
import entryTag from '@components/entry-tag.vue';
import entryTime from '@components/entry-time.vue';
import advertise from '@components/advertise.vue';

import entryContent from '@components/entry/content.vue';

export default {
  name: 'Singular',
  components: {
    amazonProduct,
    entryCategory,
    entryPager,
    entryRelated,
    entryShare,
    entryTag,
    entryTime,
    advertise,
    entryContent,
  },
  computed: mapState(['post', 'advertise']),
  watch: {
    '$route.path': function() {
      this.$store.dispatch('requestSinglePost', this.$route).then(() => this.updateAppearance());
    },
  },
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      this.$store.dispatch('requestSinglePost', this.$route).then(() => {
        this.$nextTick().then(() => this.updateAppearance());
      });
    },
    updateAppearance: function() {
      const element = this.$el.querySelector('.entry-content');
      mokuji.init(element);
      common.addExternalLink(element);
      common.setTableContainer(element);
      common.zoomImage(element);
      Prism.highlightAll();
      this.viewAttachedInfo();
      this.insertArticleAds(element.querySelector('#ads1'));
    },
    insertArticleAds: function(elementAds) {
      if (elementAds && this.advertise.ads1.display.includes(this.$route.meta.type)) {
        elementAds.innerHTML = this.advertise.ads1.content;
        eval(this.advertise.ads1.script);
      }
    },
    viewAttachedInfo: function() {
      if (this.$route.meta.type !== 'post') {
        return;
      }

      const target = this.$el.querySelector('.entry-footer');
      const observer = new IntersectionObserver(changes => {
        changes.forEach(change => {
          let intersectionRect = change.intersectionRect;
          if (intersectionRect.height * intersectionRect.width > 0) {
            this.$store.dispatch('requestPostAttach', this.$route);
            observer.unobserve(change.target);
          }
        });
      });
      observer.observe(target);
    },
  },
};
</script>

<style lang="scss">
.entry {
  margin-bottom: 1rem;

  .entry-header {
    margin-bottom: 2rem;
  }

  .entry-title {
    margin: 0 0 0.5rem;
    font-size: $font-size-h2;
    line-height: ($font-size-h2 * 2);
    word-wrap: break-word;
  }

  .entry-meta {
    text-align: left;
  }
}
</style>
