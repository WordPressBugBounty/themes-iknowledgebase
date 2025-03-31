<?php
/**
 * Search form
 *
 * @package iknowledgebase
 */

$size = (is_single() || is_archive()) ? '' : ' is-medium';

?>
<form method="get" id="searchform" role="search" class="search-form is-relative" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site search', 'twentytwelve' ); ?>">
    <div class="field has-addons m-0">
        <div class="control is-expanded">
            <label class="screen-reader-text"
                   for="s"><?php esc_html_e( 'Search for:', 'iknowledgebase' ); ?></label>
            <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" aria-label="<?php esc_attr_e( 'Search for:', 'iknowledgebase' ); ?>"
                   placeholder="<?php esc_attr_e( 'How can we help you?', 'iknowledgebase' ); ?>"
                   class="input live-search is-primary<?php echo esc_attr($size);?>" autocomplete="off"/>
        </div>
        <div class="control">
            <button type="submit" class="button is-primary<?php echo esc_attr($size);?>">
                <span class="icon is-small">
                    <span class="icon-search" aria-hidden="true"></span>
                </span>
                <span class="screen-reader-text">Search</span>
            </button>
        </div>

    </div>
    <div class="search-result panel" aria-live="polite"></div>
</form>
