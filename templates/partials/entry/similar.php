<section class="entry-related" v-cloak>
  <div class="related-container" v-for="(related,index) in relateds">
    <a v-bind:href="related.uri" class="card">
      <div class="related-title">{{ related.title }}</div>
      <div class="related-description">{{ related.description }}</div>
    </a>
  </div>
</section>
