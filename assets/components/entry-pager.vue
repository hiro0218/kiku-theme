<template>
  <div v-if="pager" class="pager">
    <div class="pager-container">
      <router-link v-if="pager.prev" :to="pager.prev.url" :title="pager.prev.title" class="pager-prev">
        <span class="pager-label">previous</span>
        <div class="pager-title">{{ pager.prev.title }}</div>
      </router-link>
      <router-link v-if="pager.next" :to="pager.next.url" :title="pager.next.title" class="pager-next">
        <span class="pager-label">next</span>
        <div class="pager-title">{{ pager.next.title }}</div>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EntryPager',
  props: {
    pager: {
      type: Object,
      default: () => {},
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.pager {
  margin: 2rem 0;
}

.pager-container {
  display: flex;

  a {
    position: relative;
    display: flex;
    flex: none;
    flex-direction: column;
    width: 50%;
    padding: 1rem 0;

    &:hover {
      .pager-title {
        color: $blue-300;
      }
    }

    &:only-child {
      flex-grow: 1;
    }
  }
}

.pager-label {
  margin-bottom: 0.25rem;
  color: $grey-400;
  font-weight: bold;
  text-transform: capitalize;
}

.pager-title {
  color: $grey-600;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
  @include text-overflow;
}

.pager-prev {
  padding-right: 1rem;
  text-align: left;
  &::before {
    position: absolute;
    right: 100%;
    top: 25%;
    margin: 1rem 0.75rem;
    line-height: 1rem;
    content: url('../images/icon/arrow_back.svg');
  }
}

.pager-next {
  padding-left: 1rem;
  text-align: right;
  &::after {
    position: absolute;
    left: 100%;
    top: 25%;
    margin: 1rem 0.75rem;
    line-height: 1rem;
    content: url('../images/icon/arrow_forward.svg');
  }
}
</style>
