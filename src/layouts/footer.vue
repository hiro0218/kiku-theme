<template>
  <footer class="footer footer-navigation">
    <div class="container">
      <nav v-if="site.primary_navigation" class="footer-menu">
        <ul>
          <li v-for="(menu, index) in site.primary_navigation" :key="index">
            <router-link :to="menu.url | formatBaseLink">{{ menu.title }}</router-link>
          </li>
        </ul>
      </nav>
      <div class="footer-copytight">
        <span>© {{ site.copyright }} <a :href="site.url">{{ site.name }}</a></span>
      </div>
    </div>
  </footer>
</template>

<script>
import copy from 'fast-copy';

export default {
  name: 'Footer',
  computed: {
    site: () => copy(WP.site),
  },
};
</script>

<style lang="scss" scoped>
.footer-navigation {
  padding: 2rem 0;
  background: $grey-300;
  color: $grey-600;
  font-size: $font-size-sm;

  .container {
    display: flex;
    align-items: center;
    @include mobile {
      flex-direction: column;
    }
  }

  a {
    color: $grey-500;
    &:hover {
      text-decoration: underline;
    }
  }

  ul {
    margin: 0;
    padding-left: 0;
    list-style: none;
  }

  li {
    display: inline-block;

    &:not(:last-child) {
      margin-right: 1rem;
    }
  }
}

.footer-menu,
.footer-copytight {
  display: flex;
  flex: 1;
  justify-content: center;
}

.footer-menu {
  justify-content: flex-start;
}

.footer-copytight {
  justify-content: flex-end;
}
</style>
