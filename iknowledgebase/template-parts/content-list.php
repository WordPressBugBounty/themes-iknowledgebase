<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package iknowledgebase
 */

$post_icon = apply_filters( 'iknowledgebase_post_icon', 'icon-book' );
?>

<a class="panel-block is-borderless" href="<?php the_permalink(); ?>" role="listitem">
    <span class="panel-icon" aria-hidden="true">
        <span class="<?php echo esc_attr( $post_icon ); ?>" aria-hidden="true"></span>
    </span>
    <?php do_action( 'iknowledgebase_post_time');?>
    <span><?php the_title(); ?></span>
</a>
