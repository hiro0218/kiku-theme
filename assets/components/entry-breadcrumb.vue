<template>
  <nav class="breadcrumb" v-if="title">
    <ol>
      <li>
        <span class="icon-home"></span>
        <a v-bind:href="navigation.site.url">{{ navigation.site.name }}</a>
      </li>
      <li v-for="(category,index) in categories" v-cloak v-bind:key="index">
        <a v-bind:href="category.link">{{ category.name }}</a>
      </li>
      <li class="breadcrumb-active">
        <span class="icon-location_on"></span>
        <a href="" v-html="$options.filters.escapeBrackets(title)"></a>
      </li>
    </ol>
  </nav>
</template>

<script>
  export default {
    name: 'entry-breadcrumb',
    props: {
      title: {
        type: String,
        default: '',
        required: true,
      },
      categories: {
        type: Array,
        default: [],
        required: false,
      },
    },
  };
</script>
