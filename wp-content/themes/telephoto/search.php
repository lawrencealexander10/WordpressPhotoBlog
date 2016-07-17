<?php
/**
 * Search results page
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ): ?>
<h2 class="search-title container" style="margin: auto auto; text-align: center">Search results for <strong><?php echo get_search_query(); ?></strong>

</h2>
<section id="search" class="container category">
<?php rewind_posts(); while ( have_posts() ) : the_post(); ?>
	<?php $tags = get_tag_value(); ?>
	<?php
    $category = get_the_category($post->ID);

    $catid = $category[0]->cat_ID;

    $top_level_cat = smart_category_top_parent_id ($catid);
    $parent_cat = get_cat_name($top_level_cat) ;
?>
     <a class="link-wrap" href="<?php esc_url( the_permalink() ); ?>"><article class="card story <?php if (str_replace("-", "", strtolower(get_the_category()[0]->cat_name)) == "ytv"): echo("story-softcore") ?> <?php endif?> <?php $category = get_the_category(); echo (str_replace("-", "", strtolower($parent_cat))); echo($tags);?> ">
      <?php place_cards_in_category(true, false); ?>
    </article></a>
<?php endwhile; ?>
</section>
<?php pagination(); ?>
<?php else: ?>
<h2>No results found for '<?php echo get_search_query(); ?>'</h2>
<?php endif; ?>
<script>
  $(document).ready(function() {
    $(function() {
  $sections = ["#search"];
  //functions for creating and destroying
  function setUpPackery(sections) {
    for (i = 0; i < (sections.length); i++) {
      $(sections[i]).packery({
        itemSelector: '.card',
        gutter: 38.5,
        containerStyle: null
      });
    }
  }
  function destroyPackery(sections) {
    for (i = 0; i < (sections.length); i++) {
      $(sections[i]).packery('destroy');
    }
  }
  function layoutPackery(sections) {
    for (i = 0; i < (sections.length); i++) {
      $(sections[i]).packery('layout');
    }
  }
  //make packery fire only once after window resize is complete
  var waitForFinalEvent = (function() {
    var timers = {};
    return function(callback, ms, uniqueId) {
      if (!uniqueId) {
        uniqueId = "Don't call this twice without a uniqueId";
      }
      if (timers[uniqueId]) {
        clearTimeout(timers[uniqueId]);
      }
      timers[uniqueId] = setTimeout(callback, ms);
    };
  })();
  //
  //onLoad
  var windowWatcher = $(window).width();
  if ($(window).width() > 480) {
    setUpPackery($sections);
  };
  //
  //resize function for breaking at 480
  function breakingPackery(num, array, text) {
    $(window).resize(function() {
      waitForFinalEvent(function() {
        if (windowWatcher > num) {
          if ($(window).width() < num) {
            destroyPackery(array);
            windowWatcher = $(window).width();
          }
           else{
             layoutPackery(array);
           }
        } else {
          if ($(window).width() >= num) {
            setUpPackery(array);
            windowWatcher = $(window).width();
          }
        }
      }, 1000, text);
    });
  }
  breakingPackery(480, $sections, "1st");
  });
  });
</script>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
