<div class="container">
  <template v-if="loaded === false">
    <?php get_template_part('partials/placeholder-home'); ?>
  </template>

  <div class="entry-list" v-cloak v-show="loaded">
    <h1 class="page-header"><?php echo App\title(); ?></h1>
    <entry-list :lists="lists"></entry-list>
  </div>

  <section>
    <?php echo get_option('kiku_insert_data_top_of_pagination'); ?>
    <?php get_template_part('partials/pagination', 'home'); ?>
  </section>
</div>
