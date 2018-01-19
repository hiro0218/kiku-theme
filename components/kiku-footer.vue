<template>
  <div>
    <footer class="footer footer-navigation">
      <div class="container" v-if="navigation">
        <nav class="footer-menu" v-if="navigation.footer.menu">
          <ul>
            <li v-for="(menu, index) in navigation.footer.menu" v-bind:key="index">
              <a v-bind:href="menu.url">{{ menu.title }}</a>
            </li>
          </ul>
        </nav>
        <div class="footer-copytight" v-if="navigation.site">
          <span>{{ navigation.site.copyright }} <a v-bind:href="navigation.site.url">{{ navigation.site.name }}</a></span>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
  export default {
    name: 'kiku-footer',
    methods: {},
    mounted: function() {},
  };
</script>
