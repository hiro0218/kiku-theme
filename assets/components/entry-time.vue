<template>
  <ul v-cloak v-if="date.publish" class="entry-time">
    <li class="date-published">
      <span class="icon-update"/><time :datetime="date.publish" itemprop="datePublished">{{ date.publish | formatDate }}</time>
    </li>
    <li v-if="date.modified" class="date-modified">
      <time :datetime="date.modified" itemprop="dateModified">{{ date.modified | formatDate }}</time>
    </li>
    <li v-if="edit.is_display">
      <a :href="edit.link"><span class="icon-edit"/></a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'EntryTime',
  filters: {
    formatDate: function(date) {
      if (typeof date === 'string') {
        date = new Date(date);
      }

      return date
        .toISOString()
        .split('T')[0]
        .replace(/-/g, '/');
    },
  },
  props: {
    date: {
      type: Object,
      default: () => {},
      required: false,
    },
  },
  data() {
    return {
      edit: {
        is_display: WP.is_logined && this.$route.meta.type !== 'preview',
        link: `/wp-admin/post.php?post=${this.$route.meta.id}&action=edit`,
      },
    };
  },
};
</script>
