<template>
  <div>
    <article class="entry">
      <entry-header :post="post"/>
      <entry-content :post="post"/>
      <advertise :id-name="ads.id"
                 :display="advertise.ads2.display.includes($route.meta.type)"
                 :content="ads.content"
                 :script="ads.script" />
      <amazon :product="post.amazon_product"/>
      <entry-footer :post="post"/>
    </article>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

import amazon from '@components/singular/amazon.vue';
import advertise from '@components/advertise.vue';

import entryHeader from '@components/singular/header.vue';
import entryContent from '@components/singular/content.vue';
import entryFooter from '@components/singular/footer.vue';

export default {
  name: 'Singular',
  components: {
    amazon,
    advertise,
    entryHeader,
    entryContent,
    entryFooter,
  },
  data() {
    return {
      ads: {
        id: 'ads2',
        content: '',
        script: '',
      },
    };
  },
  computed: mapState(['post', 'advertise']),
  watch: {
    '$route.path': function() {
      this.$store.dispatch('requestSinglePost', this.$route).then(() => this.updateAppearance());
    },
    'post.title.rendered': function(title) {
      if (!title) {
        this.ads.content = '';
        this.ads.script = '';
        return;
      }

      this.ads.content = this.advertise.ads2.content;
      this.ads.script = this.advertise.ads2.script;
      this.$store.commit('setPageTitle', title);
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
      this.insertArticleAds(element.querySelector('#ads1'));
    },
    insertArticleAds: function(elementAds) {
      if (elementAds && this.advertise.ads1.display.includes(this.$route.meta.type)) {
        elementAds.innerHTML = this.advertise.ads1.content;
        eval(this.advertise.ads1.script);
      }
    },
  },
};
</script>

<style lang="scss">
.entry {
  margin-bottom: 1rem;
}
</style>
