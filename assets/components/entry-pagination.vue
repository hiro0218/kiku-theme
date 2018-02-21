<template>
  <div>
    <nav class="pagination" v-if="requestHeader.total > 0">
      <uib-pagination
        v-model="pagination"
        :total-items="requestHeader.total"
        :items-per-page="per_page"
        :boundary-links="true"
        :rotate="true"
        next-text="Next"
        previous-text="Prev"
        @change="changePage"/>
    </nav>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'EntryPagination',
  data() {
    return {
      pagination: {
        currentPage: parseInt(this.$route.params.page_number || 1, 10),
      },
      per_page: WP.per_page,
    };
  },
  computed: mapState(['requestHeader']),
  methods: {
    changePage: function() {
      const basePath = this.getBasePath();
      const page_number = this.pagination.currentPage || 1;
      const path = `${basePath}/page/${page_number}/`;

      this.$router.push({
        path: path,
        params: { page_number: page_number },
      });
    },
    getBasePath: function() {
      let type = this.$route.meta.type;
      let slug = this.$route.meta.slug;

      if (type) {
        if (type === 'post_tag') {
          type = 'tag';
        }
        return `/${type}/${slug}`;
      }

      return '';
    },
  },
};
</script>

<style lang="scss" scoped>
.pagination /deep/ {
  margin-bottom: 1rem;
  user-select: none;

  ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 0;
  }

  li {
    display: flex;
    & + li {
      margin-left: 0.5rem;
    }
  }

  a {
    &:hover {
      background: $grey-300;
    }
  }

  a {
    min-width: 3rem;
    min-height: 3rem;
    border-radius: $radius-base;
    color: $grey-600;
    line-height: 3rem;
    text-align: center;
    &:hover,
    &:focus {
      outline: 0;
    }
  }

  .active a {
    background: $grey-600;
    color: $white;
    cursor: default;
  }
}
</style>
