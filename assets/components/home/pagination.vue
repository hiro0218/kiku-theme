<template>
  <div>
    <nav v-if="requestHeader.total > 0 && requestHeader.totalpages > 1" class="pagination">
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
  name: 'Pagination',
  data() {
    return {
      pagination: {
        currentPage: parseInt(this.$route.params.page_number || 1, 10),
      },
      per_page: WP.per_page,
    };
  },
  computed: mapState(['requestHeader']),
  watch: {
    '$route.path': function() {
      this.pagination.currentPage = parseInt(this.$route.params.page_number || 1, 10);
    },
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
  margin: 3rem 0;
  user-select: none;

  ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 0;
    list-style: none;
  }

  li {
    display: inline-block;
    list-style: none;

    & + li {
      margin-left: 0.5rem;
    }
  }

  a {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    min-width: 3rem;
    min-height: 3rem;
    border-radius: $radius-base;
    color: $grey-600;
    text-align: center;

    &:hover {
      outline: 0;
      background: $grey-300;
    }

    &::before {
      position: relative;
      top: 0.25rem;
    }
  }

  .active a {
    background: $grey-600;
    color: $white;
    cursor: default;
  }

  .disabled a {
    opacity: 0.5;
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
      content: url('../images/icon/first_page.svg');
    }
  }

  .pagination-prev a {
    &::before {
      content: url('../images/icon/chevron_left.svg');
    }
  }

  .pagination-next a {
    &::before {
      content: url('../images/icon/chevron_right.svg');
    }
  }

  .pagination-last a {
    &::before {
      content: url('../images/icon/last_page.svg');
    }
  }
}
</style>
