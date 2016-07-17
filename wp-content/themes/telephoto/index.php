<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 * <?php if (++$count > 1) break; ?>
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package   WordPress
 * @subpackage  Starkers
 * @since     Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/header', 'parts/shared/html-header') ); ?>

<?php $query_images_args = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => - 1,
);

$query_images = new WP_Query( $query_images_args );

$images = array();
foreach ( $query_images->posts as $image ) {
    if( !get_post_meta($image->ID, '_wp_attachment_source_name', true) ){
      $images[] = wp_get_attachment_url( $image->ID );
    }
} ?>

<!-- HTML -->
<section class="top-pane">
  <div class="headline" style="text-align:center">
    <div class="element"></div>
  </div>
  <div class="icons">
    <a href="<?php echo the_author_meta( 'insta', 1); ?>" class="fa fa-instagram "></a> 
    <a href="<?php echo the_author_meta( 'linkedin', 1); ?>" class="fa fa-linkedin "></a> 
    <a href="mailto:<?php echo the_author_meta( 'user_email', 1); ?>" class="fa fa-envelope-square "></a>
  </div>
</section>


 <section style="padding: 20px">
    <div data-featherlight-gallery data-featherlight-filter="a" class="grid">
      <?php foreach ($images as $image):?>
        <a class="grid-item" href="<?php echo $image ?>"><img src="<?php echo $image ?>"> </a>
      <?php endforeach; ?>
    </div>
</section>

<script>
  $(function(){
      $(".element").typed({
        strings: ["Photographer.", "Filmmaker.", "Storyteller.", "New Yorker.", "Everlena."],
        typeSpeed: 30
      });
  });
</script>

<script type="text/javascript">
  var $grid = $('.grid').imagesLoaded( function() {
  // init Packery after all images have loaded
  $grid.packery({
    itemSelector: '.grid-item',
    gutter: 6.5 ,
    containerStyle: null,
    percentPosition: true
  });
}); 
</script>
<?php // Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
