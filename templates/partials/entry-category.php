<ul class="entry-category" v-cloak v-if="categories">
  <li v-for="(category, index) in categories">
    <span v-if="index == 0" class="icon-folder"></span><a v-bind:href="category.link">{{category.name}}</a>
  </li>
</ul>
