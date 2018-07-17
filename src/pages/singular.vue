<template>
  <div class="singular">
    <article class="entry container">
      <header class="entry-header">
        <h1 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
        <entry-time :date="post.date" :modified="post.modified"/>
      </header>
      <entry-content :content="post.content.rendered" />
      <entry-attach :attach="post.attach" />
      <advertise :id-name="ads.id"
                 :display="advertise.ads2.display.includes($route.meta.type)"
                 :content="ads.content"
                 :script="ads.script" />
      <amazon :product="post.amazon_product"/>
      <template v-if="$route.meta.type === 'post'">
        <entry-share :title="post.title.rendered"/>
        <entry-term :categories="post._embedded['wp:term'][0]" :tags="post._embedded['wp:term'][1]"/>
        <entry-related :related="post.attach.related"/>
      </template>
    </article>
    <template v-if="$route.meta.type === 'post'">
      <entry-pager v-if="$route.meta.type === 'post'" :pager="post.attach.pager"/>
    </template>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import updateSingularAppearance from '@scripts/utils/singular';

import amazon from '@components/singular/amazon.vue';
import advertise from '@components/advertise.vue';

import entryContent from '@components/singular/content.vue';
import entryAttach from '@components/singular/attach.vue';
import entryTime from '@components/singular/time.vue';
import entryTerm from '@components/singular/term.vue';
import entryShare from '@components/singular/share.vue';
import entryRelated from '@components/singular/related.vue';
import entryPager from '@components/singular/pager.vue';

export default {
  name: 'Singular',
  metaInfo() {
    return {
      title: this.pageTitle,
    };
  },
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
    entryAttach,
    entryTime,
    entryTerm,
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
  computed: mapState(['pageTitle', 'post', 'advertise']),
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
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.entry-header {
  margin: 0 auto 2rem;
  text-align: center;
  @include from($desktop) {
    width: 80%;
  }
}

.entry-title {
  margin: 0 0 1rem;
  overflow-wrap: break-word;
}
</style>
