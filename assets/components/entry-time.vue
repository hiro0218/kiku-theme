<template>
  <ul v-cloak v-if="date.publish" class="entry-time">
    <li class="date-published">
      <span class="icon-update"/><time :datetime="date.publish" itemprop="datePublished">{{ date.publish | formatDate }}</time>
    </li>
    <li v-if="date.modified" class="date-modified">
      <time :datetime="date.modified" itemprop="dateModified">{{ date.modified | formatDate }}</time>
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
