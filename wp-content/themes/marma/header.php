<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link href='https://fonts.googleapis.com/css?family=Oleo+Script&Work+Sans:300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Work+Sans:300,500' rel='stylesheet' type='text/css'>
</head>

<!-- get_the_category -->
<?php
	global $curr_cat;
	$post = $wp_query->post;
	if ($post) {
		$curr_cat = get_the_category($post->ID)[0]->slug;
	}
	
?>

<body id="<?php echo $curr_cat ?>" <?php body_class(); ?>>

<div id="bg-container"></div>

<div id="page" class="hfeed site">

	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;
				?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
			</div><!-- .site-branding -->
			<div class="header-social">
				<div class="social-shinfo">
					<p>follow us:</p>
					<a class="twitter" href="https://twitter.com/marmeladromecc" target="_blank"><span class="image"></span><span class="text">twitter // </span></a>
					<a class="instagram" href="https://www.instagram.com/marmeladrome/"><span class="text">instagram // </span></a>
					<a class="facebook" href="https://www.facebook.com/marmeladrome"><span class="image"></span><span class="text">facebook</span></a>
				</div>
				<p class="race-info">upcoming race(s): Tour of Oman</p>
			</div>
		</header><!-- .site-header -->

		<?php //get_sidebar(); ?>

		<div id="secondary" class="secondary">

			<div id="widget-area" class="widget-area" role="complementary">
				<aside id="categories-4" class="widget widget_categories">
					<div class="menu-line left"></div>
					<ul>
						<li class="cat-item ">
							<a href="/races/grand-tours/"><span class="desk">Grand Tours</span><span class="mob">Grand Tours</span></a>
						</li>
						<li class="cat-item ">
							<a href="/races/stage-races"><span class="desk">Stage Races</span><span class="mob">Stage Races</span></a>
						</li>
						<li class="cat-item ">
							<a href="/races/one-day-races/"><span class="desk">One Day Races</span><span class="mob">One Days</span></a>
							<!-- <a href="/about-us"><span class="desk">About</span><span class="mob">About</span></a> -->
						</li>
						<li class="cat-item ">
							<a href="/races/opinion"><span class="desk">Opinion</span><span class="mob">Opinion</span></a>
						</li>
					</ul>
					<div class="menu-line right"></div>
				</aside>
			</div><!-- .widget-area -->
		
		</div>

	</div><!-- .sidebar -->

	<div id="content" class="site-content">
