<?php
/**
 * The template for displaying Category Archive pages
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/header', 'parts/shared/html-header') ); ?>

<?php if ( have_posts() ): ?>
  <section class="content">
    <h1>Work</h1>
    <?php while (have_posts()) : the_post() ?>
      <a href="<?php esc_url( the_permalink() ); ?>">
        <article>
          <img class="card-image" src="<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $feat_image;?>" alt="">
          <h2><?php the_title();?></h2>
          <br>
          <div class="preview">
            <?php echo (excerpt(20));?>
            <?php  ?>
          </div>
        </article>
      </a>
    <?php endwhile; ?>
  </section>
<?php endif; ?>
      

<?php //Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
