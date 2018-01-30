<template>
  <div>
    <footer class="footer footer-navigation">
      <div class="container" v-if="navigation">
        <nav class="footer-menu" v-if="navigation.footer.menu">
          <ul>
            <li v-for="(menu, index) in navigation.footer.menu" :key="index">
              <a :href="menu.url">{{ menu.title }}</a>
            </li>
          </ul>
        </nav>
        <div class="footer-copytight" v-if="navigation.site">
          <span>{{ navigation.site.copyright }} <a :href="navigation.site.url">{{ navigation.site.name }}</a></span>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'LayoutFooter',
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
