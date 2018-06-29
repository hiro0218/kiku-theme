<template>
  <ul v-cloak v-if="date" class="entry-time">
    <li class="date-published">
      <span class="icon-update"/><time :datetime="date | dateToISOString" itemprop="datePublished">{{ date | formatDate }}</time>
    </li>
    <li v-if="!isSameDay()" class="date-modified">
      <time :datetime="modified | dateToISOString" itemprop="dateModified">{{ modified | formatDate }}</time>
    </li>
    <li v-if="canEdit">
      <a :href="editPostUrl">Edit</a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Time',
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
  computed: {
    canEdit: function() {
      return WP.is_logined && this.$route.meta.type !== 'preview';
    },
    editPostUrl: function() {
      return `/wp-admin/post.php?post=${this.$route.meta.id}&action=edit`;
    },
  },
  methods: {
    isSameDay: function() {
      return new Date(this.date).toDateString() === new Date(this.modified).toDateString();
    },
  },
};
</script>

<style lang="scss" scoped>
.icon-update {
  margin-right: 0.25rem;
  background-image: url('~@images/icon/update.svg?fill=#{$grey-400}');
  @include svg-icon(1rem);
}

a {
  color: inherit;

  &:hover,
  &:focus {
    color: inherit;
    text-decoration: underline;
  }
}

ul {
  margin-bottom: 0;
  padding-left: 0;
}

li {
  display: inline-flex;
  align-items: center;
  margin-bottom: 0;
  color: $grey-500;

  & + li::before {
    content: '';
    display: inline-block;
    width: 1rem;
    height: 1rem;
    margin: 0 0.125rem;
    background: url('~@images/icon/arrow_right.svg') no-repeat;
    background-size: contain;
  }
}
</style>
