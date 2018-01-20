<template>
  <div class="entry-tag" v-cloak v-if="tags">
    <ul>
      <li v-for="(tag, index) in tags" v-bind:key="index">
        <a v-bind:href="tag.link" itemprop="keywords">{{ tag.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'entry-tag',
    props: {
      tags: {
        type: Array,
        default: [],
        required: false,
      },
    },
  };
</script>
