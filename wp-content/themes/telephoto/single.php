<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package   WordPress
 * @subpackage  Starkers
 * @since     Starkers 4.0
 */
?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header') ); ?>
<?php if ( have_posts() ): the_post(); ?>
		<section class="content single">
	    	<h1><?php the_title();?></h1>
	    	<div class="info"><?php the_content();?></div>
		</section>

		<section class="carousel">
			<?php $photo_tag = get_post_meta(get_the_ID(), 'my_meta_box_text', true);?>
			<?php if($photo_tag){
				$query_images_args = array(
				    'post_type'      => 'attachment',
				    'post_mime_type' => 'image',
				    'post_status'    => 'inherit',
				    'posts_per_page' => - 1,
				);

				$query_images = new WP_Query( $query_images_args );
				$images = array();
				foreach ( $query_images->posts as $image ) {
					if(get_post_meta($image->ID, '_wp_attachment_source_name', true) === $photo_tag){
				   		$images[] = wp_get_attachment_url( $image->ID );
					}
				};
			}?>
			<div data-featherlight-gallery data-featherlight-filter="a">
				<?php foreach ($images as $image):?>
	        		<a href="<?php echo $image ?>"><img class="lazy" src="<?php echo $image ?>"> </a>
	      		<?php endforeach; ?>
      		</div>
		</section>
<?php endif; ?>

 <script type="text/javascript">
  $(function() {
    $('.lazy').Lazy({
        effect: 'fadeIn',
        effectTime: 2000,
        threshold: 0,
        afterLoad: function(element) {
            console.log(element.attr("src"));
        }
    });
});
</script>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
