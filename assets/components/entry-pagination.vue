<template>
  <div>
    <nav class="pagination" v-if="requestHeader.total > 0">
      <uib-pagination
        v-model="pagination"
        :total-items="requestHeader.total"
        :items-per-page="per_page"
        :boundary-links="true"
        :rotate="true"
        :max-size="4"
        first-text=""
        next-text=""
        previous-text=""
        last-text=""
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
        currentPage: 1,
      },
      per_page: WP.per_page,
    };
  },
  computed: mapState(['requestHeader']),
  watch: {
    '$route.path': function() {
      this.pagination.currentPage = parseInt(this.$route.params.page_number || 1, 10);
    }
  },
  methods: {
    changePage: function() {
      let basePath = this.getBasePath();
      let pageNumber = this.pagination.currentPage || 1;
      let pagePath = `page/${pageNumber}`;
      let path = `${basePath}/`;

      if (pagePath !== 'page/1') {
        path = `${basePath}/${pagePath}/`;
      }

      this.$router.push({
        path: path,
        params: { page_number: pageNumber },
      });
    },
    getBasePath: function() {
      let type = this.$route.meta.type;
      let slug = this.$route.meta.slug || this.$route.params.search_query;

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
    min-width: 3rem;
    min-height: 3rem;
    border-radius: $radius-base;
    color: $grey-600;
    line-height: 3rem;
    text-align: center;
    &:hover {
      outline: 0;
      background: $grey-300;
    }
  }

  .active a {
    background: $grey-600;
    color: $white;
    cursor: default;
  }

  .disabled a {
    cursor: not-allowed;

    @include mobile {
      display: none;
    }

    &:hover {
      background: none;
    }
  }

  .pagination-first a {
    &::before {
      content: '\e903';
      font-family: 'icon';
    }
  }

  .pagination-prev a {
    &::before {
      content: '\e900';
      font-family: 'icon';
    }
  }

  .pagination-next a {
    &::before {
      content: '\e901';
      font-family: 'icon';
    }
  }

  .pagination-last a {
    &::before {
      content: '\e908';
      font-family: 'icon';
    }
  }
}
</style>
