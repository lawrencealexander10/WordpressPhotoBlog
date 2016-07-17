<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================

	Required external files

	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );


// ==========================================================================
// removing URL autocomplete (so invlid URLs get a 404 instead)
// http://wordpress.stackexchange.com/questions/144937/disable-only-url-auto-complete-not-the-whole-canonical-url-system/144970#144970

function remove_redirect_guess_404_permalink( $redirect_url ) {
    if ( is_404() )
        return false;
    return $redirect_url;
}
add_filter( 'redirect_canonical', 'remove_redirect_guess_404_permalink' );

function wpb_load_fa() {

wp_enqueue_style( 'wpb-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

}

add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );


	/* ========================================================================================================================

	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme

	======================================================================================================================== */

	add_theme_support('post-thumbnails');

	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================

	Actions and Filters

	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================

	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );

	======================================================================================================================== */

	/* ========================================================================================================================

	Scripts

	======================================================================================================================== */
	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		// wp_register_script( 'jquery', get_template_directory_uri().'/js/jquery.min.js', array( 'jquery' ) );
		// wp_enqueue_script('jquery');

		// wp_register_script( 'packery', get_template_directory_uri().'/js/packery.pkgd.min.js', array( 'jquery' ) );
		// wp_enqueue_script('packery');

		// wp_register_script( 'scroll-magic', get_template_directory_uri().'/js/ScrollMagic.min.js', array( 'jquery' ) );
		// wp_enqueue_script('scroll-magic');

		// wp_register_script( 'jquery.sticky', get_template_directory_uri().'/js/jquery.sticky.js', array( 'jquery' ) );
		// wp_enqueue_script('jquery.sticky');

		// wp_register_script( 'jquery.smooth-scroll', get_template_directory_uri().'/js/jquery.smooth-scroll.min.js', array( 'jquery' ) );
		// wp_enqueue_script('jquery.smooth-scroll');

		// wp_register_script( 'bigSlide', get_template_directory_uri().'/js/bigSlide.js', array( 'jquery' ) );
		// wp_enqueue_script('bigSlide');

		// wp_register_script( 'bigSlideXC', get_template_directory_uri().'/js/bigSlideXC.js', array( 'jquery' ) );
		// wp_enqueue_script('bigSlideXC');

		// wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		// wp_enqueue_script('site');

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/css/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}

	/* ========================================================================================================================

	Comments

	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}

	function wpb_set_post_views($postID) {
	    $count_key = 'wpb_post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}
	//To keep the count accurate, lets get rid of prefetching
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


	function wpb_track_post_views ($post_id) {
	    if ( !is_single() ) return;
	    if ( empty ( $post_id) ) {
	        global $post;
	        $post_id = $post->ID;
	    }
	    wpb_set_post_views($post_id);
	}
	add_action( 'wp_head', 'wpb_track_post_views');



 /* ===================================== */

 // Custom fields for setting priority
 // cribbed from http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336

	add_action( 'add_meta_boxes', 'cd_meta_box_add' );
	function cd_meta_box_add()
	{
			add_meta_box( 'article-priority-id', 'Article Priority', 'cd_meta_box_cb', 'post', 'side', 'default' );
	}

	add_action( 'add_meta_boxes', 'cd_meta_box_add4' );
	function cd_meta_box_add4()
	{
			add_meta_box( 'top-section', 'Top Section', 'cd_meta_box_cb4', 'post', 'side', 'default' );
	}

		function cd_meta_box_cb4( $post )
	{
			// $post is already set, and contains an object: the WordPress post
			global $post;
			$values = get_post_custom( $post->ID );
			$selected = isset( $values['top-sec'] ) ? esc_attr( $values['top-sec'][0] ) : '';

			// We'll use this nonce field later on when saving.
			wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
			?>
			<p>
					<label for="top-sec">Top section</label>
					<select name="top-sec" id="top-sec">
							<option value="none" <?php selected( $selected, 'none' ); ?>>none</option>
							<option value="2x2" <?php selected( $selected, '2x2' ); ?>>2x2</option>
							<option value="2x1" <?php selected( $selected, '2x1' ); ?>>2x1</option>
							<option value="1x1" <?php selected( $selected, '1x1' ); ?>>1x1</option>
					</select>
			</p>
			<?php
	}

	function cd_meta_box_cb( $post )
	{
			// $post is already set, and contains an object: the WordPress post
			global $post;
			$values = get_post_custom( $post->ID );
			$selected = isset( $values['post-priority'] ) ? esc_attr( $values['post-priority'][0] ) : '';
			$check = isset( $values['post-breaking'] ) ? esc_attr( $values['post-breaking'][0] ) : '';

			// We'll use this nonce field later on when saving.
			wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
			?>
			<p>
					<label for="post-priority">Priority</label>
					<select name="post-priority" id="post-priority">
							<option value="small" <?php selected( $selected, 'small' ); ?>>Small</option>
							<option value="medium" <?php selected( $selected, 'medium' ); ?>>Medium</option>
							<option value="large" <?php selected( $selected, 'large' ); ?>>Large</option>
							<option value="xlarge" <?php selected( $selected, 'xlarge' ); ?>>X-large</option>
					</select>
			</p>

			<p>
					<input type="checkbox" id="post-breaking" name="post-breaking" <?php checked( $check, 'on' ); ?> />
					<label for="post-breaking">Breaking</label>
			</p>
			<?php
	}

add_action( 'add_meta_boxes', 'cd_meta_box_add2' );
function cd_meta_box_add2()
{
    add_meta_box( 'my-meta-box-id1', 'Weeknd/Magazine Only', 'cd_meta_box_cb2', 'post', 'side', 'default' );
}


function cd_meta_box_cb2($post)
{
    $values = get_post_custom( $post->ID );
    $check = isset( $values['full-bleed'] ) ? esc_attr( $values['full-bleed'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<input type="checkbox" id="full-bleed" name="full-bleed" <?php checked( $check, 'on' ); ?> />
		<label for="full-bleed">Top Story Full Bleed</label>
	</p>
	<?php
}

			add_action( 'save_post', 'cd_meta_box_save' );
			function cd_meta_box_save( $post_id )
			{
					// Bail if we're doing an auto save
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

					// if our nonce isn't there, or we can't verify it, bail
					if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

					// if our current user can't edit this post, bail
					if( !current_user_can( 'edit_post', $post_id ) ) return;

					// now we can actually save the data
					$allowed = array(
							'a' => array( // on allow a tags
									'href' => array() // and those anchors can only have href attribute
							)
					);

					// Make sure your data is set before trying to save it

					if( isset( $_POST['post-priority'] ) )
					update_post_meta( $post_id, 'post-priority', esc_attr( $_POST['post-priority'] ) );

					if( isset( $_POST['top-sec'] ) )
					update_post_meta( $post_id, 'top-sec', esc_attr( $_POST['top-sec'] ) );

					$chk = isset( $_POST['post-breaking'] ) && $_POST['post-breaking'] ? 'on' : 'off';
					$chk2 = isset( $_POST['full-bleed'] ) && $_POST['full-bleed'] ? 'on' : 'off';
					update_post_meta( $post_id, 'post-breaking', $chk );
					update_post_meta( $post_id, 'full-bleed', $chk2 );

					if( isset( $_POST['my_meta_box_text'] ) )
        				update_post_meta( $post_id, 'my_meta_box_text', wp_kses( $_POST['my_meta_box_text'], $allowed ) );


			};
// ============================================================================
	//weekend and magazine headline


 /* ===================================== */

 // Custom fields for subhead
add_action( 'add_meta_boxes', 'cd_meta_box_add3' );
function cd_meta_box_add3()
{
    add_meta_box( 'my-meta-box-id', 'Assorted Portfolio Abbrev', 'cd_meta_box_cb3', 'post', 'test', 'high' );
}
function cd_meta_box_cb3($post)
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['my_meta_box_text'] ) ? esc_attr( $values['my_meta_box_text'][0] ) : "";
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
   ?>
    <input style="width: 90%; height: 30px; font-size: 1.4em" type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo $text; ?>" />
    <?php
}

function foo_move_deck() {
        # Get the globals:
        global $post, $wp_meta_boxes;

        # Output the "advanced" meta boxes:
        do_meta_boxes( get_current_screen(), 'test', $post );

        # Remove the initial "advanced" meta boxes:
        unset($wp_meta_boxes['post']['test']);
    }

add_action('edit_form_after_title', 'foo_move_deck');

// ============================================================================
// add second box for multiple feature images

			if (class_exists('MultiPostThumbnails')) {
		    new MultiPostThumbnails(
		        array(
		            'label' => 'Home Page Image (square)',
		            'id' => 'square-image',
		            'post_type' => 'post'
		        )
		    );
		    new MultiPostThumbnails(
		        array(
		            'label' => 'Article Image (rectangle)',
		            'id' => 'rectangle-image',
		            'post_type' => 'post'
		        )
		    );
		}

// rename featured image box to square image
		// add_action('do_meta_boxes', 'remove_featured_image_box');
		// function remove_featured_image_box()  {
		//     remove_meta_box( 'postimagediv', 'post', 'side' );
		// }


// ==========================================================================
//adding custom fields to user profile fields: http://www.flyinghippo.com/blog/adding-custom-fields-uploading-images-wordpress-users/
//www.wpbeginner.com/wp-tutorials/how-to-display-authors-twitter-and-facebook-on-the-profile-page/

function my_new_contactmethods( $contactmethods ) {
// Add Twitter
$contactmethods['linkedin'] = 'LinkedIn';
//unset methods

// unset($contactmethods['aim']);

// return $contactmethods;

//add Instagram
$contactmethods['insta'] = 'Instagram';

return $contactmethods;
}

			add_filter('user_contactmethods','my_new_contactmethods',10,1);
			add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
			add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );


function my_show_extra_profile_fields( $user ) {
?>
<h2>YDN Specific Info</h2>
	<table class="form-table">
	        <tr>
            <th><label for="dropdown">User Role</label></th>
            <td>
                <?php
                //get dropdown saved value
                $selected_dropdown = esc_attr(get_the_author_meta( 'user_select', $user->ID ) );
                ?>
                <select name="user_select" id="user_select">
                	<option value="none" <?php echo ($selected_dropdown == "none")?  'selected="selected"' : '' ?>>none</option>
                    <option value="Staff Reporter" <?php echo ($selected_dropdown == "Staff Reporter")?  'selected="selected"' : '' ?>>Staff Reporter</option>
                    <option value="Contributing Reporter" <?php echo ($selected_dropdown == "Contributing Reporter")?  'selected="selected"' : '' ?>>Contributing Reporter</option>
                    <option value="Staff Columnist" <?php echo ($selected_dropdown == "Staff Columnist")?  'selected="selected"' : '' ?>>Staff Columnist</option>
                    <option value="Guest Columnist" <?php echo ($selected_dropdown == "Guest Columnist")?  'selected="selected"' : '' ?>>Guest Columnist</option>
                    <option value="Staff Photographer" <?php echo ($selected_dropdown == "Staff Photographer")?  'selected="selected"' : '' ?>>Staff Photographer</option>
                    <option value="Contributing Photographer" <?php echo ($selected_dropdown == "Contributing Photographer")?  'selected="selected"' : '' ?>>Contributing Photographer</option>

                <span class="description">Simple text field</span>
            </td>
        </tr>
    </table>

	<style type="text/css">
		.fh-profile-upload-options th,
		.fh-profile-upload-options td,
		.fh-profile-upload-options input {
			vertical-align: top;
		}

		.user-preview-image {
			display: block;
			height: auto;
			width: 300px;
		}

	</style>

	<table class="form-table fh-profile-upload-options">
		<tr>
			<th>
				<label for="image">Main Profile Image</label>
			</th>

			<td>
				<img class="user-preview-image" src="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>">

				<input type="text" name="image" id="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" class="regular-text" />
				<input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />

				<span class="description">Please upload an image for your profile.</span>
			</td>
		</tr>
	</table>

	<script type="text/javascript">
		(function( $ ) {
			$( '#uploadimage' ).on( 'click', function() {
				tb_show('Upload Profile Picture', 'media-upload.php?type=image&TB_iframe=1');

				window.send_to_editor = function( html )
				{
					imgurl = $( 'img',html ).attr( 'src' );
					$( '#image' ).val(imgurl);
					tb_remove();
				}

				return false;
			});

			$( 'input#sidebarUploadimage' ).on('click', function() {
				tb_show('', 'media-upload.php?type=image&TB_iframe=true');

				window.send_to_editor = function( html )
				{
					imgurl = $( 'img', html ).attr( 'src' );
					$( '#sidebarimage' ).val(imgurl);
					tb_remove();
				}

				return false;
			});
		})(jQuery);
	</script>

<?php
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin' );

function enqueue_admin()
{
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_style('thickbox');

	wp_enqueue_script('media-upload');
}

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
{
		return false;
	}

update_user_meta( $user_id, 'image', $_POST[ 'image' ] );
update_usermeta( $user_id, 'user_select', $_POST['user_select'] );
}
// ==========================================================================


/* Each card has certain classes that make it render properly, whether it is on the home page, category page, author page, etc.
 * This function is an all purpose function for some given post to grab its "tags" (i.e., its appropriate HTML classes)
 */
function get_tag_value() {
  /* Opinion, Weekend, and Magazine are special cases of articles, so we need to know whether a post falls under those categories or not */
  $inOpinion = false;
  $inWeekend = false;
  $inMag = false;
  $categoryArray = get_the_category();
  for($i = 0; $i < count($categoryArray); $i++) {
  	$categoryName = $categoryArray[$i]-> cat_name;
  	if($categoryName === 'Opinion') {
  		$inOpinion = true;
  	}
  	if($categoryName === 'Weekend') {
  		$inWeekend = true;
  	}
  	if($categoryName === 'Magazine') {
  		$inMag = true;
  	}
  }
  $tags = ''; // Initialize tags to empty string
  if(has_excerpt() || get_post_meta(get_the_ID(), 'post-priority', true) === 'medium') {
  	/* If the story has preview text, add story-preview to the tags.
  	 * Note that NO Opinion card will EVER have a preview. This is taken care of later */
    $tags .= ' story-preview';
  }
  if(get_post_meta(get_the_ID(), 'post-priority', true) === 'medium' && (class_exists('MultiPostThumbnails')) &&
  	(MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'square-image') || MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'rectangle-image'))) {
  	/* If the post has a photo attached to it, whether its aspect ratio is 'square' (1x1) or 'rectangle' (1x2), add the story-photo tag */
    $tags .= ' story-photo';
  }
  if($inOpinion) {
  	/* If the story is opinion, we are giving it its special tags for ALL opinion stories.
  	 * In other words, it doesn't matter whether it has an image, excerpt, or whatever post priority,
  	 * these classes are the classes that ALL opinion articles will have
  	 */
    $tags = ' opinion story-opinion';
  } elseif(get_post_meta(get_the_ID(), 'post-priority', true) === 'small') {
  	if($inWeekend) {
  		/* All weekend stories will have this class */
  		$tags = ' story-weekend';
  	} else if($inMag) {
  		/* All Mag stories will have this class */
  		$tags = ' story-mag';
  	} else {
  		/* All other stories (not weekend, mag, or opinion) that have small priority will be story-simple */
    	$tags = ' story-simple';
    }
  } elseif(get_post_meta(get_the_ID(), 'post-priority', true) === 'large' || get_post_meta(get_the_ID(), 'post-priority', true) === 'xlarge') {
  	/* 2x2 card */
    $tags = ' story-major';
  }
  if(($inWeekend || $inMag) && get_post_meta(get_the_ID(), 'post-priority', true) === 'small' &&
  	(class_exists('MultiPostThumbnails')) &&
  	(MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'square-image')
  	 || MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'rectangle-image'))) {
  		$tags .= ' story-small-photo';
  }
  	if($inOpinion) {
  		$category = get_the_category();
		$opinion = "Opinion";
		$i = 0;
		$subcategory = $category[$i]->cat_name;
		while (strpos($subcategory, $opinion) !== false) {
			$i = $i + 1;
			$subcategory = $category[$i]->cat_name;
		}
	  	$author_image_url = get_the_author_meta('image', $authorID);
	  	if (get_post_meta(get_the_ID(), 'post-priority', true) === 'small' &&
	        $subcategory !== 'comics' && $author_image_url) { /* Comic opinion articles should show the comic on the card */
	      		$tags .= ' story-small-photo';
	      }
  	}
	if(get_post_meta(get_the_ID(), 'post-breaking', true) === 'on') {
  	/* Add the breaking tag if the story is breaking */
    	$tags .= ' story-breaking';
  	}
  return $tags;
}

function get_top_tag_value() {
  $inOpinion = false;
  $inWeekend = false;
  $inMag = false;
  $hasCustomSize = get_post_meta(get_the_ID(), 'top-sec', true) === 'none' ? false : true;
  $categoryArray = get_the_category();
  for($i = 0; $i < count($categoryArray); $i++) {
  	$categoryName = $categoryArray[$i]-> cat_name;
  	if($categoryName === 'Opinion') {
  		$inOpinion = true;
  	}
  	if($categoryName === 'Weekend') {
  		$inWeekend = true;
  	}
  	if($categoryName === 'Magazine') {
  		$inMag = true;
  	}
  }
  $tags = ''; // Initialize tags to empty string
  if(has_excerpt() || ($hasCustomSize && get_post_meta(get_the_ID(), 'top-sec', true) === '2x1') ||
  	(!$hasCustomSize && get_post_meta(get_the_ID(), 'post-priority', true) === 'medium')) {
  	/* If the story has preview text, add story-preview to the tags.
  	 * Note that NO Opinion card will EVER have a preview. This is taken care of later */
    $tags .= ' story-preview';
  }
  if((($hasCustomSize && get_post_meta(get_the_ID(), 'top-sec', true) === '2x1') ||
  	(!$hasCustomSize && get_post_meta(get_the_ID(), 'post-priority', true) === 'medium')) &&
  	(class_exists('MultiPostThumbnails')) &&
  	(MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'square-image') || MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'rectangle-image'))) {
  	/* If the post has a photo attached to it, whether its aspect ratio is 'square' (1x1) or 'rectangle' (1x2), add the story-photo tag */
    $tags .= ' story-photo';
  }

  if($inOpinion) {
  	/* If the story is opinion, we are giving it its special tags for ALL opinion stories.
  	 * In other words, it doesn't matter whether it has an image, excerpt, or whatever post priority,
  	 * these classes are the classes that ALL opinion articles will have
  	 */
    $tags = ' opinion story-opinion';
  } elseif(($hasCustomSize && get_post_meta(get_the_ID(), 'top-sec', true) === '1x1') ||
  		   (!$hasCustomSize && get_post_meta(get_the_ID(), 'post-priority', true) === 'small')) {
  	if($inWeekend) {
  		/* All weekend stories will have this class */
  		$tags = ' story-weekend';
  	} else if($inMag) {
  		/* All Mag stories will have this class */
  		$tags = ' story-mag';
  	} else {
  		/* All other stories (not weekend, mag, or opinion) that have small priority will be story-simple */
    	$tags = ' story-simple';
    }
  } elseif(($hasCustomSize && get_post_meta(get_the_ID(), 'top-sec', true) === '2x2') ||
  		   (!$hasCustomSize &&
  		   		(get_post_meta(get_the_ID(), 'post-priority', true) === 'large' ||
  		   		 get_post_meta(get_the_ID(), 'post-priority', true) === 'xlarge'))) {
  	/* 2x2 card */
    $tags = ' story-major';
  }
  if(get_post_meta(get_the_ID(), 'post-breaking', true) === 'on') {
  	/* Add the breaking tag if the story is breaking */
    $tags .= ' story-breaking';
  }
  return $tags;
}

function place_cards_in_category($show_cat_option, $hide_opinion_author_photo) {
	?>
	<?php if (get_post_meta(get_the_ID(), 'post-breaking', true) === 'on'):?>
		<div class="breaking">
          <h3>Breaking</h3>
          <time><?php the_time( 'M d,' ); ?> <?php the_time(); ?></time>
        </div>
    <?php endif ?>
        <h1><?php the_title(); ?></h1>
        <?php $category = get_the_category();
                $catid = $category[0]->cat_ID;
        		$top_level_cat = smart_category_top_parent_id ($catid);
       		 	$parent_cat_object = get_category($top_level_cat);
       		 	$parent_cat_slug = $parent_cat_object->slug;
        	  /* The opinion, sports, YTV, weekend, and magazine categories all have special cases */
        	  $inOpinion = false;
        	  $inSports = false;
        	  $inYtv = false;
        	  $inWeekend = false;
        	  $inMag = false;
              	if($parent_cat_slug === 'sports') {
              		$inSports = true;
              	}
              	if($parent_cat_slug === 'opinion') {
              		$inOpinion = true;
              	}
              	if($parent_cat_slug === 'ytv') {
              		$inYtv = true;
              	}
              	if($parent_cat_slug === 'wknd'){
              		$inWeekend = true;
              	}
              	if($parent_cat_slug === 'mag') {
              		$inMag = true;
              	}

        ?>
        <?php if(!$inYtv && !$inWeekend && !$inMag): /* The YTV, Weekend, and Mag categories don't have authors on their cards */?>
        <p class="byline"><?php if (function_exists( 'coauthors_posts_links' ) ) { $new_byline = coauthors(null, null, null, null, null, false); echo str_replace(" and ", ", ",$new_byline);} else {the_author();}?></p>
        <?php endif; ?>
        <?php if (class_exists('MultiPostThumbnails')) /*grab the images, if it exists, and save it in the image variable to be used later*/ :?>
          <?php $image = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'square-image'); ?>
          <?php if (!$image) {
          	$image = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'rectangle-image');
          } ?>
           <?php endif; ?>
        <p class="card-preview"><?php
        if(get_post_meta(get_the_ID(), 'post-priority', true) !== 'small' && !$inYtv && !$inOpinion) {
          echo(get_the_excerpt()); //once again, YTV and Opinion articles will never have excerpts
        }?></p>
        <?php if(!$inOpinion): /*opinion articles don't have timestamps */?>
        	<time class="published-time"><?php (strtotime($post->post_date) < strtotime('-1 year')) ? the_time( 'M d' ) : the_time( 'M d, Y' ) ; ?> <?php //the_time(); ?></time>
        <?php endif; ?>
        <?php $category = get_the_category(); ?>
        <?php if($show_cat_option): ?>
        <?php if(!$inSports && !$inOpinion): /* Opinion and Sports articles need to show their subcategory on the card */?>
          <p class="category"><?php echo($category[0]->cat_name)?></p>
        <?php else: ?>
        <?php
          $sports = "Sports";
          $opinion = "Opinion";
          $i = 0;
          $subcategory = $category[$i]->cat_name;
          while (strpos($subcategory, $sports) !== false || strpos($subcategory, $opinion) !== false){
            $i = $i + 1;
            $subcategory = $category[$i]->cat_name;
          };
          ?>
        <p class="category"><?php echo($subcategory) ?></p>
      <?php endif; ?>
      <?php endif; ?>
      <?php if(!$show_cat_option): ?>
              <?php
          $sports = "Sports";
          $opinion = "Opinion";
          $i = 0;
          $subcategory = $category[$i]-> slug;
          while (strpos($subcategory, $sports) !== false || strpos($subcategory, $opinion) !== false){
            $i = $i + 1;
            $subcategory = $category[$i]-> slug;
          };
          ?>
      <?php endif; ?>
      <?php $author_image_url = get_the_author_meta('image', $authorID); if ($image && get_post_meta(get_the_ID(), 'post-priority', true) !== 'small' || $inOpinion || $inWeekend || $inMag): ?>
      <?php if(($subcategory !== 'comics') && $inOpinion && !$hide_opinion_author_photo && $author_image_url): /* Comic opinion articles should show the comic on the card */?>
      	<img src='<?php echo $author_image_url; ?>' class="card-image">
      <?php elseif($image && !$inOpinion): /* Display the image for the card */ ?>
      	<img class='card-image' src='<?php echo $image ?>'>
      <?php endif; ?>
      <?php endif; ?>
      <?php

}
function smart_category_top_parent_id ($catid) {
    while ($catid) {
        $cat = get_category($catid); // get the object for the catid
        $catid = $cat->category_parent; // assign parent ID (if exists) to $catid
          // the while loop will continue whilst there is a $catid
          // when there is no longer a parent $catid will be NULL so we can assign our $catParent
        $catParent = $cat->cat_ID;
    }
    return $catParent;
}

/* Magazine and Weekend categories may have a full-bleed article.
 * This query searches for the latest one and sets it.
 */
function full_bleed($category) { // The $category variable can either be "mag" or "wknd"

	$args = array(
  'posts_per_page'   => 1,
  'offset'           => 0,
  'orderby'          => 'date',
  'include'          => '',
  'exclude'          => '',
  'meta_key'         => 'full-bleed',
  'meta_value'       => 'on',
  'post_type'        => 'post',
  'post_mime_type'   => '',
  'post_parent'      => '',
  'category_name'    => $category,
  'post_status'      => 'publish',
 );?>
    <?php query_posts($args); $full_id = get_the_ID(); while ( have_posts() ) : the_post(); ?>
    <a class="link-wrap" href="<?php esc_url( the_permalink() ); ?>">
      <article class="story-softcore-cover">
        <?php if (class_exists('MultiPostThumbnails')) :?>
        <?php $image = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'rectangle-image'); ?>
            <?php if ($image) :?>
            <img class='card-image' src='<?php echo $image?>'>
           <?php endif; ?>
        <?php endif; ?>
        <h1 class="container"><?php the_title(); ?></h1>
        <p class="container byline"> <?php the_author();?> | <?php the_date();?> </p>
      </article>
    </a>
  <?php endwhile; ?>
  <?php return $full_id; ?>
  <?php
}

/* This function is very much like the function above.
 * The only difference is that it does not set the full-bleed.
 * It only performs the query and returns the ID of the full-bleed.
 * This solution is not optimum, but it is done because of PHP variable scoping.
 */
function get_full_bleed_id($categoryId) {
	$args = array(
  'posts_per_page'   => 1,
  'offset'           => 0,
  'orderby'          => 'date',
  'include'          => '',
  'exclude'          => '',
  'meta_key'         => 'full-bleed',
  'meta_value'       => 'on',
  'post_type'        => 'post',
  'post_mime_type'   => '',
  'post_parent'      => '',
  'cat'              => $categoryId,
  'post_status'      => 'publish',
 );?>
    <?php query_posts($args); $full_id = get_the_ID(); ?>
    <?php return $full_id; ?>
    <?php
}

function pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


/**
 * Add credit fields for image attachment source name + URL
 *
 * @link http://konstruktors.com/blog/wordpress/3203-how-to-automatically-add-image-credit-or-source-url-to-photo-captions-in-wordpress/
 *
 */
add_filter( 'attachment_fields_to_edit', 'ac_add_image_source', 10, 2 );

function ac_add_image_source( $form_fields, $post ) {

	$form_fields['source_name'] = array(
		'label' => __('Assorted Portfolio Abbrev'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, '_wp_attachment_source_name', true ),
        'helps' => __('Add the name of the image source'),
	);
 	return $form_fields;
}

/**
 * Save credit fields
 *
 */
add_filter( 'attachment_fields_to_save', 'ac_save_image_source', 10 , 2 );

function ac_save_image_source( $post, $attachment ) {

	if ( isset( $attachment['source_name'] ) ) {
		$source_name = get_post_meta( $post['ID'], '_wp_attachment_source_name', true );
		if ( $source_name != esc_attr( $attachment['source_name'] ) ) {
			if ( empty( $attachment['source_name'] ) )
				delete_post_meta( $post['ID'], '_wp_attachment_source_name' );
			else
				update_post_meta( $post['ID'], '_wp_attachment_source_name', esc_attr( $attachment['source_name'] ) );
		}
	}

	return $post;

}
//http://frankiejarrett.com/get-an-attachment-id-by-url-in-wordpress/
function get_attachment_id_by_url( $url ) {
	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}
	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );
	// Returns null if no attachment is found
	return $attachment[0];
}


//=================================================
//code for what displays on chrome tab
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Yale Daily News', 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
  } else if ( is_category()){
  		return $title . ' | ' . 'Yale Daily News';
  }
  return $title;
}

//limit excerpt
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

