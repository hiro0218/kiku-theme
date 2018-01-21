<template>
  <ul class="entry-time" v-cloak v-if="date.publish">
    <li class="date-published">
      <span class="icon-update"></span><time itemprop="datePublished" v-bind:datetime="date.publish">{{ date.publish | formatDate }}</time>
    </li>
    <li class="date-modified" v-if="date.modified">
      <time itemprop="dateModified" v-bind:datetime="date.modified">{{ date.modified | formatDate }}</time>
    </li>
    <li v-if="is_logined">
      <a :href="edit_link"><span class="icon-edit"></span></a>
    </li>
  </ul>
</template>

<script>
  export default {
    name: 'entry-time',
    data() {
      return {
        is_logined: WP.is_logined,
        edit_link: `/wp-admin/post.php?post=${WP.page_id}&action=edit`,
      }
    },
    props: {
      date: {
        type: Object,
        default: {},
        required: false,
      },
    },
  };
</script>
