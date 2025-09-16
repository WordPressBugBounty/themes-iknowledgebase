<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package iknowledgebase
 */

?>


<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>

<aside id="sidebar"<?php iknowledgebase_sidebar_class();?>>
	<?php dynamic_sidebar( 'sidebar' ); ?>
</aside>
<?php endif; ?>
	

