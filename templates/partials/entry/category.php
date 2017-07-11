<ul class="entry-category">
  <li v-for="category in categories" v-cloak>
    <a v-bind:href="category.link">{{category.name}}</a>
  </li>
</ul>
