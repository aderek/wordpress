<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <?php 
        	global $has_sub_categories;
        	$has_sub_categories = false;
			// in category template, get child categories of queried category and if there are child cats, get one post for each child
			if ( is_category() ) {

			$parent_cat = get_category((get_query_var('cat')));

			$args = array(
				'child_of'                 => get_query_var('cat'),
				'orderby'                  => 'id',
				'order'                    => 'DESC'
			);

			$categories = get_categories($args);
			if ( $categories ) {
				$has_sub_categories = true;
			  	foreach($categories as $category) {
			      $posts=get_posts('showposts=1&cat='. $category->term_id);
			      if ($posts) { ?>
			      	<p class="cat-name parent-cat-page">
			      		<span class="cat-latest">Latest in: 
			      			<a href="<?php echo esc_attr(get_term_link($parent_cat, 'category')); ?>" title="View all posts in <?php echo $parent_cat->name; ?>">
				      			<?php echo $parent_cat->name; ?>
				      		</a> /
				      		<a href="<?php echo esc_attr(get_term_link($category, 'category')); ?>" title="View all posts in <?php echo $category->name; ?>">
				      			<?php echo $category->name; ?>
				      		</a>
			      		</span>
			      	</p>
			        <?
			        foreach($posts as $post) {
			          setup_postdata($post); ?>
			          <!-- <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> -->
			          <?php get_template_part( 'content', get_post_format() ); ?>
			          <?php
			        } // foreach($posts
			      } // if ($posts
			    } // foreach($categories
			  } // if (categories
			} // if (is_category
            
        ?>
		<?php if (!$has_sub_categories) : ?>
			<?php if (have_posts()) : ?> 
			<header class="page-header">
				
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
