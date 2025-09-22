<?php
/**
 * Get posts for home page
 *
 * @subpackage iknowledgebase
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iknowledgebase_get_home_posts() {
	$defaults = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 1,
		'exclude'    => '',
		'include'    => '',
		'pad_counts' => true,
	);
	$args     = apply_filters( 'iknowledgebase_category_home_args', $defaults );


	$categories = get_categories( $args );
	$categories = wp_list_filter( $categories, array( 'parent' => 0 ) );

	if ( ! $categories ) {
		return;
	}

	$panel_color = get_theme_mod( 'iknowledgebase_panel_color', 'is-dark' );

	$out = '';
	foreach ( $categories as $cat ) {

		$count = iknowledgebase_total_cat_post_count( $cat->cat_ID );

		$cat_icon = apply_filters( 'iknowledgebase_category_icon', 'icon-folder-open', $cat->cat_ID );

		$out .= '<div class="column is-4-widescreen is-6-desktop is-12-touch">';
		$out .= '<div class="panel has-background-white">';
		$out .= '<div class="panel-heading level is-mobile">';
		$out .= '<div class="level-left">';
		$out .= '<div class="level-item has-text-primary"><span class="' . esc_attr( $cat_icon ) . '" aria-hidden="true"></span></div>';
		$out .= '<div class="level-item"><h2 class="title is-5" id="category-' . absint( $cat->cat_ID ) . '">' . esc_attr( $cat->name ) . '</h2></div>';
		$out .= '</div>';
		$out .= '<div class="level-right"><span class="tag is-white has-text-primary">' . absint( $count ) . '</span></div>';
		$out .= '</div>';
		$out .= iknowledgebase_home_panel_tabs( $cat->cat_ID );
		$out .= '</div>';
		$out .= '</div>';
	}
	echo $out;
}

function iknowledgebase_total_cat_post_count( $cat_id ) {
	$q = new WP_Query( array(
		'nopaging'  => true,
		'tax_query' => array(
			array(
				'taxonomy'         => 'category',
				'field'            => 'id',
				'terms'            => $cat_id,
				'include_children' => true,
			),
		),
		'fields'    => 'ids',
	) );

	return $q->post_count;
}


function iknowledgebase_home_panel_tabs( $cat_ID ) {


	$tabs = array(
		'subcats'       => esc_attr__( 'Subcategories', 'iknowledgebase' ),
		'date'          => esc_attr__( 'New', 'iknowledgebase' ),
		'comment_count' => esc_attr__( 'Popular', 'iknowledgebase' ),
	);

	$elements = apply_filters( 'iknowledgebase_home_panel_tabs', $tabs );

	$child_arg = array(
		'parent' => $cat_ID,
	);

	$child_arg = apply_filters( 'iknowledgebase_home_subcategories', $child_arg );

	$child_cats = get_categories( $child_arg );

	if ( ! $child_cats ) {
		unset( $elements['subcats'] );
	}

	$header = '<p class="panel-tabs" role="tablist">';

	$i = 0;
	foreach ( $elements as $key => $val ) {
		if ( $i === 0 ) {
			$header .= '<a id="tab-' . esc_attr( $key ) . '-' . absint( $cat_ID ) . '" class="is-active" role="tab" aria-selected="true" aria-controls="' . esc_attr( $key ) . '-' . absint( $cat_ID ) . '" data-tab="' . esc_attr( $key ) . '"' . iknowledgebase_panel_toogle( $elements, $key, $cat_ID ) . '>' . esc_html( $val ) . '</a>';
		} else {
			$header .= '<a id="tab-' . esc_attr( $key ) . '-' . absint( $cat_ID ) . '" tabindex="0" class="" role="tab" aria-selected="false" aria-controls="' . esc_attr( $key ) . '-' . absint( $cat_ID ) . '" data-tab="' . esc_attr( $key ) . '"' . iknowledgebase_panel_toogle( $elements, $key, $cat_ID ) . '>' . esc_html( $val ) . ' </a>';
		}
		$i ++;
	}
	$header .= '</p>';

	$header = ( count( $elements ) > 1 ) ? $header : '';

	$content = '';

	$iknowledgebase_numberposts = get_theme_mod( 'iknowledgebase_home_post_number', 5 );

	$posts_arg = array(
		'numberposts' => $iknowledgebase_numberposts,
		'category'    => $cat_ID,
	);

	$i = 0;
	foreach ( $elements as $key => $val ) {
		if ( $i === 0 ) {
			$content .= '<div data-content="' . esc_attr( $key ) . '" role="tabpanel" aria-labelledby="tab-' . absint( $key ) . '-' . absint( $cat_ID ) . '"  class="tabs-content"' . iknowledgebase_panel_content_toogle( $elements, $key, $cat_ID ) . '>';
		} else {
			$content .= '<div data-content="' . esc_attr( $key ) . '" role="tabpanel" aria-labelledby="tab-' . absint( $key ) . '-' . absint( $cat_ID ) . '" aria-labelledby  class="tabs-content is-hidden"' . iknowledgebase_panel_content_toogle( $elements, $key, $cat_ID ) . '>';
		}

		if ( $key === 'subcats' ) {
			foreach ( $child_cats as $cat ) {
				$cat_icon = apply_filters( 'iknowledgebase_category_icon', 'icon-folder', $cat->cat_ID );
				$cat_link = get_category_link( $cat->cat_ID );
				$content  .= '<a class="panel-block is-radiusless" href="' . esc_url( $cat_link ) . '">';
				$content  .= '<span class="panel-icon ' . esc_attr( $cat_icon ) . '" aria-hidden="true"></span>';
				$content  .= esc_html( $cat->cat_name );
				$content  .= '</a>';
			}
		} else {
			$posts_arg['orderby'] = $key;
			$posts                = get_posts( $posts_arg );
			$post_icon            = apply_filters( 'iknowledgebase_post_icon', 'icon-book' );
			foreach ( $posts as $single ) {
				setup_postdata( $single );
				$content .= '<a class="panel-block is-radiusless" href="' . esc_url( get_permalink( $single->ID ) ) . '">';
				$content .= '<span class="panel-icon" aria-hidden="true"><span class="' . esc_attr( $post_icon ) . '"></span></span>';
				$content .= esc_html( $single->post_title );
				$content .= '</a>';
			}
		}
		$content .= '</div>';
		$i ++;
	}
	$btn_color = get_theme_mod( 'iknowledgebase_view_btn_color', 'is-primary' );
	$cat_link  = get_category_link( $cat_ID );
	$link      = '<div class="panel-block mt-5">';
	$link      .= '<a href="' . esc_url( $cat_link ) . '" class="hvr-icon-wobble-horizontal button is-primary is-outlined hvr-icon-wobble-horizontal"><span>' . esc_attr__( 'View all', 'iknowledgebase' ) . '</span><span
                                class="icon is-small" aria-hidden="true"><span class="hvr-icon icon-long-arrow-alt-right"></span></span></a>';
	$link      .= '</div>';

	return $header . $content . $link;
}

function iknowledgebase_panel_toogle( $elements, $key, $cat_ID ) {
	if ( iknowledgebase_is_amp() ) {
		$attr    = ' on="tap:AMP.setState({panelMenuExpanded_' . $cat_ID . ': \'' . $key . '\'})" ';
		$default = array_key_exists( 'subcats', $elements ) ? 'subcats' : 'date';
		$attr    .= "[class]=\"panelMenuExpanded_" . $cat_ID . " ? (panelMenuExpanded_" . $cat_ID . " == '" . $key . "' ? 'is-active' : '') : ('" . $key . "' == '" . $default . "' ? 'is-active' : '')\"";

		return $attr;
	}
}

function iknowledgebase_panel_content_toogle( $elements, $key, $cat_ID ) {
	if ( iknowledgebase_is_amp() ) {
		$default = array_key_exists( 'subcats', $elements ) ? 'subcats' : 'date';
		$attr    = " [class]=\"panelMenuExpanded_" . $cat_ID . " ? (panelMenuExpanded_" . $cat_ID . " == '" . $key . "' ? '' : 'is-hidden') : ('" . $key . "' == '" . $default . "' ? '' : 'is-hidden')\"";

		return $attr;
	}
}
