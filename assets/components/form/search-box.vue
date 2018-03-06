<template>
  <div class="search-container">
    <input id="search-box" v-model="search_value" class="search-input" type="search" name="s" placeholder="Search..." required @keyup.enter="checkKeypress" @keydown.enter="search"><!--
  --><label class="icon" for="search-box"><span class="icon-search"/></label>
  </div>
</template>

<script>
export default {
  name: 'SearchBox',
  data() {
    return {
      search_value: this.$route.params.search_query,
      ENTER_KEY: 13,
      keypressed: false,
    };
  },
  methods: {
    checkKeypress: function(event) {
      if (event.keyCode !== this.ENTER_KEY) {
        return;
      }
      this.keypressed = true;
    },
    search: function(event) {
      if (event.keyCode === this.ENTER_KEY && this.keypressed) {
        this.$router.push({
          path: `/search/${this.search_value}`,
          params: { search_query: this.search_value },
        });
      }
      this.keypressed = false;
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
