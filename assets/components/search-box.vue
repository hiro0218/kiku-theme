<template>
  <div class="search-container">
    <input id="search-box" v-model="searchValue" class="search-input" type="search" placeholder="Search..."
           @keyup.enter="setKeypress"
           @keydown.enter="submitSearch"><!--
  --><label class="icon" for="search-box"><span class="icon-search"/></label>
  </div>
</template>

<script>
export default {
  name: 'SearchBox',
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
.search-container {
  margin-right: 0.5rem;
  white-space: nowrap;
}

.icon {
  display: inline-block;
  width: 2rem;
  color: $grey-700;
  text-align: center;
  cursor: pointer;
}

.search-input {
  width: 0;
  font-size: 1rem;
  line-height: 0;
  border: 0;
  border-radius: 0;
  outline: none;
  background: transparent;
  box-shadow: none;
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
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
