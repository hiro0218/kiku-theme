<template>
  <div>
    <footer class="footer footer-navigation">
      <div class="container">
        <nav class="footer-menu">
          <ul v-if="navi.footer">
            <li v-for="(menu, index) in navi.footer.menu" v-bind:key="index">
              <a v-bind:href="menu.url">{{ menu.title }}</a>
            </li>
          </ul>
        </nav>
        <div class="footer-copytight" v-if="navi.site">
          <span>{{ navi.site.copyright }} <a v-bind:href="navi.site.url">{{ navi.site.name }}</a></span>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
  export default {
    name: 'kiku-footer',
    props: {
      navi: {
        type: Object,
        default: {},
        required: true,
      },
    },
    methods: {},
    mounted: function() {},
  };
</script>
