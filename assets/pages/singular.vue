<template>
  <div class="container">
    <article class="entry">
      <entry-header :post="post"/>
      <entry-content :content="post.content"/>
      <advertise :id-name="'ads2'"
                 :display="advertise.ads2.display.includes($route.meta.type)"
                 :content="advertise.ads2.content"
                 :script="advertise.ads2.script" />
      <amazon-product :amazon_product="post.amazon_product"/>
      <entry-footer :post="post"/>
    </article>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

import amazonProduct from '@components/amazon-product.vue';
import advertise from '@components/advertise.vue';

import entryHeader from '@components/entry/header.vue';
import entryContent from '@components/entry/content.vue';
import entryFooter from '@components/entry/footer.vue';

export default {
  name: 'Singular',
  components: {
    amazonProduct,
    advertise,
    entryHeader,
    entryContent,
    entryFooter,
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
}
</style>
