<template>
  <div class="search-container">
    <input id="search-box" v-model="searchValue" class="search-input" type="search" placeholder="Search..."
           @keyup.enter="setKeypress"
           @keydown.enter="submitSearch"><!--
  --><label class="icon-search" for="search-box"/>
  </div>
</template>

<script>
export default {
  name: 'Search',
  data() {
    return {
      searchValue: this.$route.params.search_query,
      isKeypressed: true,
    };
  },
  watch: {
    '$route.params.search_query': function(search_query) {
      this.searchValue = search_query || '';
    },
  },
  methods: {
    // keyup
    setKeypress: function() {
      this.isKeypressed = true;
    },
    // keydown
    submitSearch: function() {
      if (!this.searchValue) {
        return;
      }

      if (this.isKeypressed) {
        this.isKeypressed = false;
        this.$router.push({
          path: `/search/${this.searchValue}`,
          params: { search_query: this.searchValue },
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.icon-search {
  background-image: url('~@images/icon/search.svg?fill=#{$grey-700} svg');
  @include svg-icon(1.5rem);
  cursor: pointer;
}

.search-container {
  display: flex;
  align-items: center;
}

.search-input {
  width: 0;
  font-size: 1rem;
  border: 1px solid transparent;
  outline: none;
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  transition: width 0.3s $animation-curve-fast-out-slow-in;

  &:focus,
  &:active {
    width: 12rem;
    line-height: 2rem;
    border-bottom: 1px solid $grey-400;
    cursor: text;
  }
}
</style>
