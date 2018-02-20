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
      this.$router.push({
        params: { page_number: this.pagination.currentPage },
      });
    },
    setPaginationData: function() {
      var totalpages = this.requestHeader.totalpages;

      if (totalpages <= 1) {
        return;
      }

      var range = 3;
      var paged = this.$route.params.page_number === undefined ? 1 : parseInt(this.$route.params.page_number, 10);
      var ceil = Math.ceil(range / 2);
      var min = 0;
      var max = 0;
      var param = this.getPaginationParam();

      if (totalpages > range) {
        if (paged <= range) {
          min = 1;
          max = range + 1;
        } else if (paged >= totalpages - ceil) {
          min = totalpages - range;
          max = totalpages;
        } else if (paged >= range && paged < totalpages - ceil) {
          min = paged - ceil;
          max = paged + ceil;
        }
      } else {
        min = 1;
        max = totalpages;
      }

      var prev = paged - 1;
      var first = 1;
      if (first && 1 != paged) {
        this.pagination.label.first = first;
        this.pagination.links.first = `${param}/page/${first}/`;
      }
      if (prev && 1 != paged) {
        this.pagination.prev = prev;
        this.pagination.links.prev = `${param}/page/${prev}/`;
      }

      if (min && max) {
        for (var i = min; i <= max; i++) {
          if (paged == i) {
            this.pagination.label.active = i;
          }
          this.pagination.pages[i] = {
            links: `${param}/page/${i}/`,
          };
        }
      }

      if (totalpages != paged) {
        var next = paged + 1;
        var last = totalpages;
        if (next) {
          this.pagination.label.next = next;
          this.pagination.links.next = `${param}/page/${next}/`;
        }
        if (last) {
          this.pagination.label.last = last;
          this.pagination.links.last = `${param}/page/${last}/`;
        }
      }
    },
    getPaginationParam: function() {
      if (WP.category_name) {
        return `/category/${WP.category_name}`;
      } else if (WP.tag_name) {
        return `/tag/${WP.tag_name}`;
      } else if (WP.search) {
        return `/search/${WP.search}`;
      } else {
        return '';
      }
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
