<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
            if ( is_home() ) {

                global $wpdb;

                $cat_array = $wpdb->get_results( "
                    SELECT terms.*, posts.ID as post_ID, posts.post_date_gmt
                    FROM
                    wp_terms terms
                    JOIN wp_term_taxonomy term_taxonomy 
                        ON terms.term_id = term_taxonomy.term_id
                    JOIN wp_term_relationships term_relationships 
                        ON ( term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id 
                            AND term_taxonomy.taxonomy = 'category' )
                    JOIN (
                        SELECT ID, post_type, post_status, post_date_gmt
                        FROM wp_posts
                        ORDER BY post_date_gmt DESC
                        ) posts 
                        ON ( posts.ID = term_relationships.object_id 
                            AND posts.post_type='post'
                            AND posts.post_status='publish' )
                    GROUP BY terms.term_id
                    ORDER BY posts.post_date_gmt DESC
                    LIMIT 3" );

                $args = array(
                    'orderby'                  => 'id',
                    'order'                    => 'DESC'
                );

                $categories = get_categories($args);
                if ( $cat_array ) {
                    $postArr = [];
                    $index = 0;
                    $catArr = [];

                    foreach($cat_array as $category) {

                        $posts=get_posts('showposts=4&cat='. $category->term_id);
                        if ($posts) {
                            
                            foreach($posts as $post) {
                                $postArr[$index] = $post;
                                $catArr[$index] = $category;
                                $index++;
                            }
                        }
                    }

                    $count =  0;
                    ?>
                    <div class="homepage-cat-teaser">

                    <?php
                    foreach($postArr as $post) {
                            
                        if($count % 2 === 0) { ?>
                            <div class="homepage-cat-row">
                        <?php }?>

                        <div class="homepage-cat-container container<?php echo $count; ?>">

                            <?php
                            $category = $catArr[$count];
                            ?>

                            <div class="hp-cat-title-container">
                                <h2 class="entry-title"><a href="<?php echo get_permalink( $post->ID); ?>"> <?php echo get_the_title( $post->ID ); ?></a></h2>
                                <p class="cat-name"><span class="cat-latest"><a href="<?php echo get_category_link( $category->term_id ) ?>" title="View all posts in <?php echo $category->name; ?>"><?php echo $category->name; ?></a></span> &mdash; <span class="cat-date"><?php echo date('D, d M' ,strtotime($post->post_date_gmt)); ?></span></p>
                            </div>

                            <div class="hp-post-content">
                                <?php echo truncateHtml(apply_filters('the_content', $post->post_content), $length = 500); ?>
                            </div>

                            <div class="hp-teaser-footer">

                                <div class="homepage-readmore"><a href="<?php echo get_permalink( $post->ID); ?>">Read More</a></div>

                            </div>
                        </div>
                        
                        <?php
                        $count++;

                        if($count % 2 === 0 || $count === count($postArr)) { ?>
                            </div>
                            </div>
                            <?php
                            if($count !== count($postArr)) { ?>
                                <hr class="hp-hr"></hr>
                            <?php } ?>
                            
                            <div class="homepage-cat-teaser">
                        <?php }

                    } // close foreach posts
                    ?>

                    </div> <!-- close homepage-cat-teaser-->
                    <hr class="hp-hr"></hr>
            <?php
                } // close if categories

            } else {
    			// Start the loop.
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
            }

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
