<template>
  <footer class="footer footer-navigation">
    <div v-if="navigation" class="container">
      <nav v-if="navigation.footer.menu" class="footer-menu">
        <ul>
          <li v-for="(menu, index) in navigation.footer.menu" :key="index">
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
import { mapState } from 'vuex';
import { cloneDeep } from 'lodash-es';

export default {
  name: 'Footer',
  data() {
    return {
      site: cloneDeep(WP.site),
    };
  },
  computed: mapState(['navigation']),
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
