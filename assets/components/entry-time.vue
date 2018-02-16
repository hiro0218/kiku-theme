<template>
  <ul class="entry-time" v-cloak v-if="date.publish">
    <li class="date-published">
      <span class="icon-update"/><time itemprop="datePublished" :datetime="date.publish">{{ date.publish | formatDate }}</time>
    </li>
    <li class="date-modified" v-if="date.modified">
      <time itemprop="dateModified" :datetime="date.modified">{{ date.modified | formatDate }}</time>
    </li>
    <li v-if="is_logined">
      <a :href="edit_link"><span class="icon-edit"/></a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'EntryTime',
  props: {
    date: {
      type: Object,
      default: () => {},
      required: false,
    },
  },
  data() {
    return {
      is_logined: WP.is_logined,
      edit_link: `/wp-admin/post.php?post=${this.$route.meta.id}&action=edit`,
    };
  },
};
</script>
