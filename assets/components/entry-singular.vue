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
        <section class="entry-content" v-html="post.content"/>
        <advertise :id-name="'ads2'" :content="advertise.ads2.content" :script="advertise.ads2.script" />
        <template v-if="$route.meta.type === 'post'">
          <amazon-product :amazon_product="post.amazon_product"/>
          <footer class="entry-footer">
            <entry-tag :tags="post.tags"/>
            <entry-share :title="post.title" :link="post.link"/>
            <entry-pager :pagers="post.attach.pagers"/>
          </footer>
        </template>
      </article>
    </div>

    <template v-if="$route.meta.type === 'post'">
      <entry-related :relateds="post.attach.relateds"/>
    </template>
    <entry-breadcrumb :title="post.title" :categories="post.categories"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { MODEL_POST } from '@scripts/models';
import api from '@scripts/api';
import mokuji from '@scripts/module/mokuji';
import common from '@scripts/module/common';

import amazonProduct from '@components/amazon-product.vue';
import entryBreadcrumb from '@components/entry-breadcrumb.vue';
import entryCategory from '@components/entry-category.vue';
import entryPager from '@components/entry-pager.vue';
import entryRelated from '@components/entry-related.vue';
import entryShare from '@components/entry-share.vue';
import entryTag from '@components/entry-tag.vue';
import entryTime from '@components/entry-time.vue';
import advertise from '@components/advertise.vue';

export default {
  name: 'EntrySingular',
  components: {
    amazonProduct,
    entryBreadcrumb,
    entryCategory,
    entryPager,
    entryRelated,
    entryShare,
    entryTag,
    entryTime,
    advertise,
  },
  computed: mapState(['post', 'advertise']),
  created: function() {
    this.requestPostData();
  },
  methods: {
    requestPostData: function() {
      var response =
        this.$route.meta.type === 'post' ? api.getPosts(this.$route.meta.id) : api.getPages(this.$route.meta.id);

      response
        .then(response => {
          let json = response.data;
          let post = MODEL_POST;

          post.link = json.link;
          post.title = json.title.rendered;
          post.date.publish = json.date;
          post.date.modified = this.isSameDay(json.date, json.modified) ? null : json.modified;
          post.content = json.content.rendered;
          post.categories = json.categories || post.categories;
          post.tags = json.tags || post.tags;
          post.amazon_product = json.amazon_product || post.amazon_product;

          this.$store.commit('setPost', post);
        })
        .then(() => {
          this.$nextTick().then(() => {
            var element = this.$el.querySelector('.entry-content');
            mokuji.init(element);
            common.addExternalLink(element);
            common.setTableContainer(element);
            common.zoomImage(element);
            Prism.highlightAll();
            this.viewAttachedInfo();
            const ads = element.querySelector('#ads1');
            if (ads) {
              this.insertArticleAds(ads);
            }
          });
        });
    },
    requestAttachedData: function(target) {
      var response = api.getAttachData(this.$route.meta.id);

      response.then(response => {
        let json = response.data;

        this.$store.commit('setPostAttach', {
          relateds: json.related || MODEL_POST.attach.relateds,
          pagers: json.pager || MODEL_POST.attach.pagers,
        });
      });
    },
    insertArticleAds: function(ads) {
      ads.innerHTML = this.advertise.ads1.content;
      eval(this.advertise.ads1.script);
    },
    isSameDay: function(publish, modified) {
      return new Date(publish).toDateString() === new Date(modified).toDateString();
    },
    viewAttachedInfo: function() {
      if (this.$route.meta.type !== 'post') {
        return;
      }

      var target = this.$el.querySelector('.entry-footer');
      var clientHeight = document.documentElement.clientHeight;
      var observer = new IntersectionObserver(changes => {
        changes.forEach(change => {
          var rect = change.target.getBoundingClientRect();
          var isShow =
            (0 < rect.top && rect.top < clientHeight) ||
            (0 < rect.bottom && rect.bottom < clientHeight) ||
            (0 > rect.top && rect.bottom > clientHeight);
          if (isShow) {
            this.requestAttachedData(change.target);
            observer.unobserve(change.target);
          }
        });
      });
      observer.observe(target);
    },
  },
};
</script>
