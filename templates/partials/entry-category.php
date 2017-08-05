<ul class="entry-category">
  <li v-for="(category, index) in categories" v-cloak>
    <span v-if="index == 0" class="icon-folder"></span><a v-bind:href="category.link">{{category.name}}</a>
  </li>
</ul>
