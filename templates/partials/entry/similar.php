<section class="entry-related" v-cloak if="relateds">
  <div class="related-container" v-for="(related,index) in relateds">
    <a v-bind:href="related.uri">
      <div class="related-title">{{ related.title }}</div>
      <div class="related-description">{{ related.description }}</div>
    </a>
  </div>
</section>
