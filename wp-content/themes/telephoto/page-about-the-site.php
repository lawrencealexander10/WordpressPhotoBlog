<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="top-image">
	<img class="tech-team" src="<?php echo get_template_directory_uri();?>/images/fullBW.jpg" alt="">
	<h1 id="title" class="photo-text">Redesigning <span style="font-style:italic;">the</span> <span style="text-transform:uppercase;">oldest college daily</span></h1>
</div>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div id="article-content" class="about-the-site">
	<div class="box">
		<section style="margin-top: 0; padding-top: 35px;" class="article-text">





	<p><strong>Welcome to the new Yale Daily News</strong>. In the fall of 2014, our small team of developers and designers decided to rebuild the YDN’s digital home from the ground up. A lot has changed since the paper first came online in 1999. Almost half of the News’ readers now access the site from devices that didn’t exist back then. The web is not a second-class citizen, but rather a primary way that readers interact with the newspaper. Despite all this change, the YDN site hasn’t evolved much since it first launched.</p>

	<p>We set out to create a thoughtfully designed experience that meets the needs of the modern reader. The site should be so much more than just a digital imitation of the print paper. Our goal was to take full advantage of the power of the web. The new YDN gives you a more engaging, visually immersive look at the news. And for the first time, it’s easy to read and navigate the site no matter what size screen you’re on.</p>

	<p>The homepage uses a card-based design, which makes the site more flexible and dynamic than ever. Editors have far more control over the layout and prominence of each individual story. The content now has room to breathe, and as a result, the day’s news is easier to make sense of.</p>

	<p>The improvements to the site extend beyond the homepage. We’ve refined the typography on the article pages and removed distractions from the sidebar so that you can focus on the content. Cross Campus no longer lives on a separate site; just scroll within the new Cross Campus box on the homepage to quickly read the News’ classic and clever daily blurbs. Once relegated to a small corner of the site, the Weekend and Magazine sections have been redesigned to highlight their compelling visual content. Photographers’ pages now include a beautiful grid of the photos they’ve taken, and the new homepage design makes room for larger, more expressive photography. Nervation has been simplified—gone are the long dropdown menus and confusing labels. We think you’ll find the new easier to use and more fun to explore.</p>

	<p>The site is a living product that will continue to evolve over the coming weeks, months, and years. We realize this is a big change, but the time has come to re-build YDN for our mobile-first age. Enjoy the update, and please send your feedback to aaron.z.lewis@yale.edu.</p>



		</section>
		<div class="people">
			<div class="person">
				<div class="image">
				<img src="<?php echo get_template_directory_uri();?>/images/alexColor.jpg" alt="">
			</div>
				<div class="person-info">
					<p>Alex Tenn</p>
					<p>Morse College '16</p>
				</div>
			</div>
			<div id="person" class="person">
				<div class="image">
				<img src="<?php echo get_template_directory_uri();?>/images/annieColor.jpg" alt="">
			</div>
				<div class="person-info">
					<p>Annie Cook</p>
					<p>Morse College '17</p>
				</div>
			</div>
			<div id="person" class="person">
				<div class="image">
				<img src="<?php echo get_template_directory_uri();?>/images/aaronColor.jpg" alt="">
			</div>
				<div class="person-info">
					<p>Aaron Z. Lewis</p>
					<p>Saybrook College '16</p>
				</div>
			</div>
			<div id="person" class="person">
				<div class="image">
				<img src="<?php echo get_template_directory_uri();?>/images/waldenColor.jpg" alt="">
			</div>
				<div class="person-info">
					<p>Walden Davis</p>
					<p>Saybrook College '16</p>
				</div>
			</div>
			<div id="person" class="person">
				<div class="image">
				<img src="<?php echo get_template_directory_uri();?>/images/chrisColor.jpg" alt="">
			</div>
				<div class="person-info">
					<p>Chris Wan</p>
					<p>Pierson College '17</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="top-image">
	<img class="tech-team" src="<?php echo get_template_directory_uri();?>/images/fullfunnyBW.jpg" alt="">
</div>

<div id="article-content" class="about-the-site">
	<div class="box">
		<section class="article-text">
			<?php the_content(); ?>
		</section>
	</div>
</div>
<?php endwhile; ?>


<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<script>
	$(document).ready(function(){
		var controller = new ScrollMagic.Controller();
		  $(function() { // wait for document ready
		    // build Scene
		    var scene = new ScrollMagic.Scene({
		        triggerElement: ".article-text",
		        triggerHook: 1
		      })
		      .setClassToggle('.photo-text', 'stay')
		      //.addIndicators({name: "1 (duration: 300)"}) // add indicators (requires plugin)
		      .addTo(controller);
		  });
		});
</script>
