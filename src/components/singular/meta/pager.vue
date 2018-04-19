<template>
  <div v-if="pager" class="pager-container">
    <router-link v-if="pager.prev" :to="pager.prev.url" :title="pager.prev.title" class="prev">
      <div class="icon-container">
        <div class="icon" v-html="iconArrowBack"/>
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
        <div class="icon" v-html="iconArrowForward"/>
      </div>
    </router-link>
  </div>
</template>

<script>
import iconArrowBack from '@images/icon/arrow_back.svg?inline';
import iconArrowForward from '@images/icon/arrow_forward.svg?inline';

export default {
  name: 'Pager',
  props: {
    pager: {
      type: Object,
      default: () => {},
      required: true,
    },
  },
  data() {
    return {
      iconArrowBack,
      iconArrowForward,
    };
  },
};
</script>

<style lang="scss" scoped>
.icon /deep/ {
  @include svn-icon(1.5rem, $grey-600);
}

.pager-container {
  display: flex;
  margin: 2rem 0;
  padding: 1rem 0;

  a {
    display: flex;
    width: 50%;

    &:hover {
      .title {
        color: $blue-300;
      }
    }

    &:only-child {
      flex-grow: 1;
    }
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
  color: $grey-400;
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
