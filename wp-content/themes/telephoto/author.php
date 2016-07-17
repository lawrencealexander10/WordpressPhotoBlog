<?php
/**
 * The template for displaying Author Archive pages
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<section id="author" class="container category">

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
	<div class="link-wrap"><article class="card author-card author-photo">
	<h1><?php echo  $curauth->first_name . " " .$curauth->last_name ; ?></h1>
  <?php if ($curauth->image): ?>
	<img src='<?php echo $curauth->image;?>' class="card-image">
  <?php endif; ?>
	<?php if ($curauth->twitter):?>
		<a class="author-twitter" href="http://twitter.com/<?php echo $curauth->twitter;  ?>">
			<i class="fa fa-twitter"></i>
			<h3><?php echo $curauth->twitter; ?></h3>
		</a>
	<?php endif; ?>
  <?php if ($curauth->user_email):?>
	<a class="author-email" href="mailto:<?php echo $curauth->user_email; ?>">
		<i class="fa fa-envelope"></i>
		<h3><?php echo $curauth->user_email; ?></h3>
	</a>
  <?php endif; ?>
  <?php if ($curauth->user_select && $curauth->user_select != "none" ):?>
  <h2 class="author-title"><?php echo $author_title = $curauth->user_select; ?></h2>
  <h2 class="archive"><?php if(preg_match('/Photo/', $author_title)){echo 'Photographer Archive';} elseif($author_title != 'none'){echo 'Author Archive';}// echo "Author Archive"}; ?></h2>
<?php endif; ?>
</article></div>

<?php if (preg_match('/Photo/', $curauth->user_select )):?>
  <?php $username =  sanitize_text_field($curauth->user_login); ?>
  <?php $query_images_args = "SELECT guid, id FROM `wp_postmeta` postmeta, `wp_posts` posts where meta_key = '_wp_attachment_source_name' and meta_value ='$username' and posts.id = postmeta.post_id"; 
$query_images = $wpdb->get_results( $query_images_args );?>
<?php if($query_images): ?>
<?php foreach($query_images as $image_url): ?>
<a class="link-wrap" href="<?php echo get_permalink(get_post_field( 'post_parent', $image_url->id)); ?>"> <img class='card photo-card' src=" <?php echo $image_url->guid ?>">  </a>
<?php endforeach;?>
<?php endif; ?>
<? endif; ?>


<?php if ( have_posts() ): the_post(); ?>

<?php rewind_posts(); while ( have_posts() ) : the_post(); ?>
	<?php $tags = get_tag_value(); ?>
	<?php 
    $category = get_the_category($post->ID);
 
    $catid = $category[0]->cat_ID;
 
    $top_level_cat = smart_category_top_parent_id ($catid);
    $parent_cat = get_cat_name($top_level_cat);
    if($category[0]->cat_name !== 'Cross Campus') :
?>
     <a class="link-wrap" href="<?php esc_url( the_permalink() ); ?>"><article class="card story <?php if (str_replace("-", "", strtolower(get_the_category()[0]->cat_name)) == "ytv"): echo("story-softcore") ?> <?php endif?> <?php $category = get_the_category(); echo (str_replace("-", "", strtolower($parent_cat))); echo($tags);?> ">
      <?php place_cards_in_category(true, true); ?>
    </article></a>
  <?php endif; ?>
<?php endwhile; ?>


<?php else: ?>
<!-- <div class="link-wrap"><article class="card author-card author-photo"> <h2>No posts to display </h2></article></div> -->
<?php endif; ?>
</section>
<?php pagination(); ?>
<script>
  $(document).ready(function() {
    $(function() {

  $sections = ["#author"];



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