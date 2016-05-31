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
					?>
					<div class="category-index">
					<h1 class="parent-category-header">
		      			<?php echo $parent_cat->name; ?> report index:
					</h1>
					<?php 
				  	foreach($categories as $category) {
				      	$posts=get_posts('showposts=1&cat='. $category->term_id);
				     	if ($posts) { ?>
					      	<h2 class="subcategory-header">
					      		<a href="<?php echo esc_attr(get_term_link($category, 'category')); ?>" title="View all posts in <?php echo $category->name; ?>">
					      			<?php echo $category->name; ?>
					      		</a>
					      	</h2>
					        <?
				      	} // if ($posts
				    } // foreach($categories
				    ?></div><?php
				} // if (categories
			} // if (is_category
            
        ?>
		<?php 
			if (!$has_sub_categories) { 

				if (have_posts()) { 
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array( 'paged' => $paged, 'posts_per_page' => 10, 'category' => $parent_cat->term_id );
					$posts=get_posts($args);

		            if($posts) {

		            	?>
		                <div class="homepage-cat-teaser subcategory-teaser">
		                <?
		                $count =  0;

		                foreach($posts as $post) {

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							// get_template_part( 'content', get_post_format() );
			                    
			                if($count % 2 === 0) { ?>
			                    <div class="homepage-cat-row">
			                <?php }?>

			                <div class="homepage-cat-container">

			                    <div class="hp-cat-title-container">
			                        <h2 class="entry-title"><a href="<?php echo get_permalink( $post->ID); ?>"> <?php echo get_the_title( $post->ID ); ?></a></h2>
			                        <p class="cat-name"><span class="cat-latest"><a href="<?php echo esc_attr(get_term_link($parent_cat, 'category')); ?>" title="View all posts in <?php echo $parent_cat->name; ?>"><?php echo $parent_cat->name; ?></a></span> &mdash; <span class="cat-date"><?php echo date('D, d M' ,strtotime($post->post_date_gmt)); ?></span></p>
			                    </div>

			                    <div class="hp-post-content">
			                        <?php echo truncateHtml(apply_filters('the_content', $post->post_content), $length = 300); ?>
			                    </div>

			                    <div class="hp-teaser-footer">

			                        <div class="homepage-readmore"><a href="<?php echo get_permalink( $post->ID); ?>">Read More</a></div>

			                    </div>
			                </div>
			                
			                <?php
			                $count++;
			                if($count % 2 === 0) { ?>
			                    </div>
			                <?php }
			              

			            }

			            ?>
			            </div> <!-- close homepage-cat-teaser-->
			            <?php

					// End the loop.
					}

					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
						'next_text'          => __( 'Next page', 'twentyfifteen' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
					) );

				// If no content, include the "No posts found" template.
				} 
				else {
					get_template_part( 'content', 'none' );

				}
			}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
