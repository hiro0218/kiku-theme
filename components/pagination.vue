<template>
  <div>
    <nav class="pagination">
      <ul>
        <li class="pagination-first" v-if="pagination.label.first">
          <a v-bind:href="pagination.links.first"><span class="icon-first_page"></span></a>
        </li>
        <li class="pagination-previous" v-if="pagination.label.prev">
          <a v-bind:href="pagination.links.prev"><span class="icon-chevron_left"></span></a>
        </li>
        <template v-for="(pages, index) in pagination.pages">
          <template v-if="pagination.label.active == index">
            <li class="pagination-active" v-bind:key="index">
              <span>{{pagination.label.active | zeroPadding}}</span>
            </li>
          </template>
          <template v-else>
            <li v-bind:key="index">
              <a v-bind:href="pages.links">{{index | zeroPadding}}</a>
            </li>
          </template>
        </template>
        <li class="pagination-next" v-if="pagination.label.next">
          <a v-bind:href="pagination.links.next"><span class="icon-chevron_right"></span></a>
        </li>
        <li class="pagination-last" v-if="pagination.label.last">
          <a v-bind:href="pagination.links.last"><span class="icon-last_page"></span></a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
  export default {
    name: 'pagination',
    data() {
      return {
        pagination: {
          label: {
            first: 0,
            prev: 0,
            next: 0,
            last: 0,
            active: 0,
          },
          pages: {},
          links: {
            first: '',
            prev: '',
            next: '',
            last: '',
          },
        },
      };
    },
    props: {
      totalpages: {
        type: Number,
        default: 0,
        required: true,
      },
    },
    mounted: function() {},
    watch: {
      totalpages: function() {
        this.setPaginationData();
      },
    },
    methods: {
      setPaginationData: function() {
        var totalpages = this.totalpages;

        if (totalpages <= 1) {
          return;
        }

        var range = 3;
        var paged = WP.paged;
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
    filters: {
      zeroPadding: function(number) {
        return ('0' + number).slice(-2);
      },
    },
  };
</script>
