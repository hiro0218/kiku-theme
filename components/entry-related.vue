<template>
  <div class="related-container container" v-cloak v-if="relateds">
    <h2 class="related-heading">Related Posts</h2>
    <div class="entry-related">
      <div class="related-section" v-for="(related,index) in relateds">
        <a v-bind:href="related.uri">
          <div class="related-image">
            <div class="image-sheet" v-bind:style="related.image ? 'background-image: url('+ related.image  +')' : ''"></div>
          </div>
          <div class="related-title" v-html="$parent.$options.filters.escapeBrackets(related.title)"></div>
          <div class="related-description" v-html="$parent.$options.filters.escapeBrackets(related.description)"></div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'entry-related',
    props: {
      relateds: {
        type: Array,
        default: [],
        required: true,
      }
    },
    methods: {},
    mounted: function () {},
  }
</script>
