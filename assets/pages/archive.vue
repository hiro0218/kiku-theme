<template>
  <div>
    <article class="entry">
      <header>
        <h1 class="entry-title">Archive</h1>
      </header>
      <section v-for="(entries, year) in list" :key="year" class="entry-content">
        <h2 class="archive-year">{{ year }}</h2>
        <ul>
          <li v-for="entry in entries" :key="entry.id">
            <time :datetime="entry.date | dateToISOString">{{ entry.date | formatDate }}</time>
            <router-link :to="entry.link">{{ entry.title }}</router-link>
          </li>
        </ul>
      </section>
    </article>
  </div>
</template>

<script>
/**
 * Create a page named "archive".
 *  permalink: 'https://example.com/archive/'
 */
import api from '@scripts/api';

export default {
  name: 'Archive',
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
  data() {
    return {
      list: null,
    };
  },
  mounted() {
    this.$store.dispatch('loading', true);

    api.getArchive().then(response => {
      this.list = response.data;
      this.$store.dispatch('loading', false);
    });
  },
};
</script>

<style lang="scss" scoped>
ul {
  padding: 0;
}

li {
  display: flex;
  padding: 0 1rem;
  line-height: 2.5rem;
  list-style-type: none;
}

time {
  flex: 0 0 6rem;
  margin-right: 2rem;
  color: $grey-400;
}
</style>
