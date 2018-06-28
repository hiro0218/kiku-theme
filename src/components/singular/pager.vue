<template>
  <nav v-if="Object.keys(pager).length !== 0" class="pager-container">
    <div class="pager-content container">
      <router-link v-if="pager.prev" :to="pager.prev.url" :title="pager.prev.title" class="prev">
        <div class="icon-container">
          <div class="icon icon-arrow-back"/>
        </div>
        <div class="pager">
          <span class="label">previous</span>
          <div class="title">{{ pager.prev.title }}</div>
        </div>
      </router-link>
      <router-link v-if="pager.next" :to="pager.next.url" :title="pager.next.title" class="next">
        <div class="pager">
          <span class="label">next</span>
          <div class="title">{{ pager.next.title }}</div>
        </div>
        <div class="icon-container">
          <div class="icon icon-arrow-forward"/>
        </div>
      </router-link>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Pager',
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
.icon {
  @include svg-icon(1.5rem);
}

.icon-arrow-forward {
  background-image: url('~@images/icon/arrow_forward.svg?fill=#{$grey-600} svg');
}

.icon-arrow-back {
  background-image: url('~@images/icon/arrow_back.svg?fill=#{$grey-600} svg');
}

.pager-container {
  padding: 2rem 0;
  background: $grey-100;
}

.pager-content {
  display: flex;
  flex-wrap: wrap;
}

.prev,
.next {
  display: flex;
  width: 50%;

  &:hover,
  &:focus {
    opacity: 0.6;
  }

  &:only-child {
    flex-grow: 1;
  }

  @include mobile {
    flex: none;
    width: 100%;
  }
}

.icon-container {
  display: flex;
  align-items: center;
  width: 2rem;
}

.pager {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.label {
  margin-bottom: 0.25rem;
  color: $grey-500;
  font-weight: bold;
  text-transform: capitalize;
}

.title {
  color: $grey-600;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
}

.prev {
  padding-right: 1rem;
  text-align: left;

  .icon-container {
    margin-right: 0.5rem;
  }
}

.next {
  padding-left: 1rem;
  text-align: right;

  .icon-container {
    margin-left: 0.5rem;
  }
}
</style>
