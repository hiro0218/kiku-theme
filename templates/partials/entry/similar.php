<section class="entry-related">
  <div class="columns">
    <div class="related-container column" v-for="(related,index) in relatedData" v-if="index >= 3">
      <a v-bind:href="related.uri" class="card">
        <div class="related-title">{{ related.title }}</div>
        <div class="related-description">{{ related.description }}</div>
      </a>
    </div>
  </div>
</section>
