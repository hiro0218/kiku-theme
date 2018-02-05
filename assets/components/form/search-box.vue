<template>
  <form method="get" action="/">
    <div class="search-container">
      <input type="search" id="search-box" class="search-input" name="s" :value="query" placeholder="Search..." required ><!--
   --><label class="icon" for="search-box"><span class="icon-search"/></label>
    </div>
  </form>
</template>

<script>
export default {
  name: 'SearchBox',
  data() {
    return {
      query: WP.search,
    };
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
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  transition: width 0.3s $animation-curve-fast-out-slow-in;

  &:focus,
  &:active {
    width: 12rem;
    line-height: 2rem;
    border-bottom: 1px solid $grey-400;
  }
}
</style>
