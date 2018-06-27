<template>
  <div>
    <div class="singular container">
      <article class="entry">
        <header class="entry-header">
          <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
          <div class="entry-meta">
            <entry-time :date="post.date" :modified="post.modified"/>
            <entry-category v-if="$route.meta.type === 'post'" :categories="post._embedded['wp:term'][0]"/>
          </div>
        </header>
        <entry-content :post="post"/>
        <advertise :id-name="ads.id"
                   :display="advertise.ads2.display.includes($route.meta.type)"
                   :content="ads.content"
                   :script="ads.script" />
        <amazon :product="post.amazon_product"/>
        <entry-share :title="post.title.rendered"/>
        <entry-tag v-if="$route.meta.type === 'post'" :tags="post._embedded['wp:term'][1]"/>
        <entry-related :related="post.attach.related"/>
      </article>
    </div>
    <div>
      <entry-pager :pager="post.attach.pager"/>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import updateSingularAppearance from '@scripts/utils/singular';

import amazon from '@components/singular/amazon.vue';
import advertise from '@components/advertise.vue';

import entryContent from '@components/singular/content.vue';
import entryTime from '@components/singular/meta/time.vue';
import entryCategory from '@components/singular/meta/category.vue';
import entryTag from '@components/singular/meta/tag.vue';
import entryShare from '@components/singular/share.vue';
import entryRelated from '@components/singular/related.vue';
import entryPager from '@components/singular/pager.vue';

export default {
  name: 'Singular',
  beforeRouteLeave(to, from, next) {
    if (to.path !== from.path) {
      this.$store.dispatch('resetPost');
    }
    next();
  },
  components: {
    amazon,
    advertise,
    entryContent,
    entryTime,
    entryCategory,
    entryTag,
    entryShare,
    entryRelated,
    entryPager,
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
      this.$store.dispatch('resetPost').then(() => {
        this.requestPostData();
      });
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
      updateSingularAppearance.init(element);
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

<style lang="scss" scoped>
.singular {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: space-between;
}

.entry-header {
  margin-bottom: 2rem;
  text-align: center;
}

.entry-title {
  word-wrap: break-word;
}

.entry-meta {
  color: $grey-400;

  ul {
    margin-bottom: 0;
    padding-left: 0;
    list-style: none;
  }
}
</style>
