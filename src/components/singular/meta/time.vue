<template>
  <ul v-cloak v-if="date" class="entry-time">
    <li class="date-published">
      <span class="icon" v-html="iconUpdate"/><time :datetime="date | dateToISOString" itemprop="datePublished">{{ date | formatDate }}</time>
    </li><!--
 --><li v-if="!isSameDay()" class="date-modified">
      <time :datetime="modified | dateToISOString" itemprop="dateModified">{{ modified | formatDate }}</time>
    </li><!--
 --><li v-if="edit.is_display">
      <a :href="edit.link">Edit</a>
    </li>
  </ul>
</template>

<script>
import iconUpdate from '@images/icon/update.svg?inline';

export default {
  name: 'Time',
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
      type: String,
      default: '',
      required: true,
    },
    modified: {
      type: String,
      default: '',
      required: false,
    },
  },
  data() {
    return {
      iconUpdate,
      edit: {
        is_display: WP.is_logined && this.$route.meta.type !== 'preview',
        link: `/wp-admin/post.php?post=${this.$route.meta.id}&action=edit`,
      },
    };
  },
  methods: {
    isSameDay: function() {
      return new Date(this.date).toDateString() === new Date(this.modified).toDateString();
    },
  },
};
</script>

<style lang="scss" scoped>
.icon /deep/ {
  display: inline-block;
  vertical-align: middle;
  width: 1rem;
  height: 1rem;
  margin-right: 0.25rem;

  svg {
    display: block;
    fill: $grey-400;
  }
}

li {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;

  a {
    color: inherit;

    &:hover,
    &:focus {
      color: inherit;
      text-decoration: underline;
    }
  }

  & + li::before {
    content: '';
    display: inline-block;
    background: url('~@images/icon/arrow_right.svg') no-repeat;
    background-size: contain;
    width: 1rem;
    height: 1rem;
    margin: 0 0.125rem;
  }
}
</style>
