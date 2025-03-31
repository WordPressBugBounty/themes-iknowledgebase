<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package iknowledgebase
 */

get_header();


?>

<section class="section" id="content">
    <div class="container">
        <div class="has-text-centered mb-6">
			<?php iknowledgebase_main_image(); ?>
            <div class="is-max-w-2xl mx-auto">
				<?php get_search_form(); ?>
            </div>
        </div>
        <div class="is-max-w-2xl mx-auto pt-5">
            <div class="box is-mobile">
				<?php iknowledgebase_posts_sorter(); ?>
            </div>

			<?php if ( have_posts() ) : ?>
            <h2 class="screen-reader-text"><?php esc_html_e('Article List', 'iknowledgebase');?></h2>
                <div class="panel has-background-white"  role="list">
					<?php
					// Load posts loop.
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', 'list' );
					}
					?>
                </div>
				<?php iknowledgebase_the_posts_pagination(); ?><?php endif; ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
