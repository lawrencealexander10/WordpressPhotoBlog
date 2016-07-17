
    <div id="loading">
      <img id = "loader" src="<?php echo get_site_url(); ?>/wp-content/themes/ydnlabs/css/images/Y.gif">
    </div>
    <div class = "sticky-footer-wrapper">
    <header id="site-header">
    <a href="<?php  echo(site_url()); ?>"><h1 class="masthead-logo">Yale Daily News</h1></a>
    <nav id="site-navigation">
      <a id="tag-home" href="<?php  echo(site_url()); ?>">Home</a>
      <a id="tag-opinion" href="<?php  echo(site_url()); ?>/blog/category/opinion">Opinion</a>
      <a id="tag-university" href="<?php  echo(site_url()); ?>/blog/category/university">University</a>
      <a id="tag-city" href="<?php  echo(site_url()); ?>/blog/category/city">City</a>
      <a id="tag-sports" href="<?php  echo(site_url()); ?>/blog/category/sports">Sports</a>
      <a id="small-logo" href="<?php  echo(site_url()); ?>"><h1 class="small-logo">ydn</h1></a>
      <a id="tag-scitech" href="<?php  echo(site_url()); ?>/blog/category/sci-tech">Scitech</a>
      <a id="tag-culture" href="<?php  echo(site_url()); ?>/blog/category/culture">Culture</a>
      <a id="tag-ytv" href="https://www.youtube.com/user/ydnmultimedia/videos">YTV</a>
      <a id="tag-weekend" href="<?php  echo(site_url()); ?>/blog/category/wknd">Wknd</a>
      <a id="tag-magazine" href="<?php  echo(site_url()); ?>/blog/category/mag">Mag</a>
      <div id="nav-search">
        <i class="fa fa-search"></i>
         <form class="search-box" action="<?php bloginfo('home'); ?>/">
            <input type="text" placeholder="Search articles and authors" value="<?php echo get_search_query(); ?>" name="s" id="s" />
            <input style="display:none;" type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
         </form>
      </div>
    </nav>
  </header>

  <header id="mobile-header">
    <a href="#" class="menu-link fa fa-bars fa-lg"></a>
    <img id="mobile-nameplate" src = "<?php echo get_site_url(); ?>/wp-content/themes/ydnlabs/css/images/YDN Nameplate Medium.gif">
    <script> $('#mobile-nameplate').click(function() { window.location = <?php echo( " \" " . get_site_url() . " \" " );  ?> })</script>
    <nav id="mobile-navigation">
      <a class = "fa fa-times fa-lg" id="nav-close-button"></a>
      <i class="fa fa-search first-row search"></i>
       <div id="nav-search-left" class="search"> 
         <form class="search-box search" action="<?php bloginfo('home'); ?>/" autofocus>
             <input type="text" class="search" placeholder="Search articles and authors" value="<?php echo get_search_query(); ?>" name="s" id="s" />
            <input type="submit" class="search" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
         </form>
       </div>
      <a id="tag-home" href="<?php  echo(site_url()); ?>">Home</a>
      <a id="tag-opinion" href="<?php  echo(site_url()); ?>/blog/category/opinion">Opinion</a>
      <a id="tag-university" href="<?php  echo(site_url()); ?>/blog/category/university">University</a>
      <a id="tag-city" href="<?php  echo(site_url()); ?>/blog/category/city">City</a>
      <a id="tag-sports" href="<?php  echo(site_url()); ?>/blog/category/sports">Sports</a>
      <a id="tag-scitech" href="<?php  echo(site_url()); ?>/blog/category/sci-tech">Scitech</a>
      <a id="tag-culture" href="<?php  echo(site_url()); ?>/blog/category/culture">Culture</a>
      <a id="tag-ytv" href="https://www.youtube.com/user/ydnmultimedia/videos">YTV</a>
      <a id="tag-weekend" href="<?php  echo(site_url()); ?>/blog/category/wknd">Wknd</a>
      <a id="tag-magazine" href="<?php  echo(site_url()); ?>/blog/category/mag">Mag</a>
    </nav>
  </header>
  <span class="top-ad"><?php Starkers_Utilities::get_template_parts(array('parts/shared/banner-ad-top')); ?></span>
