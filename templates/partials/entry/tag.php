<div class="entry-tag">
  <ul>
    <li v-for="tag in tags">
      <a v-bind:href="tag.link" itemprop="keywords">{{ tag.name }}</a>
    </li>
  </ul>
</div>
