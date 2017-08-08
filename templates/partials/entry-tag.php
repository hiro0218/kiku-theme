<section class="entry-tag" v-cloak v-if="tags">
  <ul>
    <li v-for="tag in tags">
      <a v-bind:href="tag.link" itemprop="keywords">{{ tag.name }}</a>
    </li>
  </ul>
</section>
