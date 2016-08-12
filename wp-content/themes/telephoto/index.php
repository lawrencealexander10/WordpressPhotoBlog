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
  <div class="left-side" style="display: inline-block; width: 50%; margin-top: 100px">
    <img src="https://s3.amazonaws.com/telephoto/wp-content/uploads/2016/07/etport2.jpg" alt="" style="   ;margin: 7%; float: right">
  </div>
  <div class="right-side" style=" display: inline; width: 50%; margin-top: 25%; text-align: center; position: absolute">
    <div class="element"></div>
    <div class="icons">
      <a href="<?php echo the_author_meta( 'insta', 1); ?>" class="fa fa-instagram "></a> 
      <a href="<?php echo the_author_meta( 'linkedin', 1); ?>" class="fa fa-linkedin "></a> 
      <a href="mailto:<?php echo the_author_meta( 'user_email', 1); ?>" class="fa fa-envelope-square "></a>
    </div> 
  </div>
</section>


 <section class="bottom-pane">
    <div data-featherlight-gallery data-featherlight-filter="a" class="grid">
    <div class="gutter-sizer"></div>
    <div class="grid-sizer"></div>
      <?php foreach ($images as $image):?>
        <a class="grid-item" href="<?php echo $image ?>"><img class="lazy" data-src="<?php echo $image ?>"> </a>
      <?php endforeach; ?>  

    </div>
</section>

<script type="text/javascript">
  $(function() {
      var $grid = $('.grid').packery({
          itemSelector: '.grid-item',
          gutter: ".grid-sizer" ,
          containerStyle: null,
          percentPosition: true,
          columnWidth: ".grid-sizer"
        }); 
    $('.lazy').Lazy({
        effect: 'fadeIn',
        effectTime: 2000,
        threshold: 0,
        afterLoad: function(element) {
            console.log(element.attr("src"));
            $('.grid').packery('layout');
        },
        beforeLoad: function(element){
          element.css("margin-bottom", '0px');
        }
    });
});
</script>

  <script>
  $(function(){
      $(".element").typed({
        strings: ["Photographer.", "Filmmaker.", "Everlena."],
        typeSpeed: 100
      });
  });
  </script>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
