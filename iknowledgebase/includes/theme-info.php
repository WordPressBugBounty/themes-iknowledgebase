<?php
/**
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 * @package iknowledgebase
 */

/**
 * Add Theme Info page to admin menu
 */
function iknowledgebase_theme_info_menu_link() {

	// Get theme details.
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( __( 'Welcome to %1$s %2$s', 'iknowledgebase' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ),
		__( 'Theme Info', 'iknowledgebase' ),
		'edit_theme_options',
		'iknowledgebase',
		'iknowledgebase_theme_info_page'
	);

}

add_action( 'admin_menu', 'iknowledgebase_theme_info_menu_link' );

/**
 * Display Theme Info page
 */
function iknowledgebase_theme_info_page() {

	// Get theme details.
	$theme = wp_get_theme();
	?>

    <div class="wrap theme-info-wrap">

        <h1><?php printf( __( 'Welcome to %1$s %2$s', 'iknowledgebase' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ); ?></h1>

        <div class="theme-description"><?php echo esc_html( $theme->display( 'Description' ) ); ?></div>

        <hr>
        <div class="important-links clearfix">
            <p><strong><?php esc_html_e( 'Theme Links', 'iknowledgebase' ); ?>:</strong>
                <a href="https://wow-company.com/iknowledgebase-theme/"
                   target="_blank"><?php esc_html_e( 'Theme Page', 'iknowledgebase' ); ?></a>
                <a href="https://themes.wow-company.com/iknowledgebase/"
                   target="_blank"><?php esc_html_e( 'Theme Demo', 'iknowledgebase' ); ?></a>
                <a href="https://themes.wow-company.com/iknowledgebasepro/"
                   target="_blank"><?php esc_html_e( 'Theme Demo PRO version', 'iknowledgebase' ); ?></a>
                <a href="https://docs.wow-company.com/category/themes/iknowledgebase/" target="_blank">
		            <?php esc_html_e( 'Theme Documentation', 'iknowledgebase' ); ?>
                </a>
                <a href="https://wordpress.org/support/theme/iknowledgebase/reviews/"
                   target="_blank"><?php esc_html_e( 'Rate this theme', 'iknowledgebase' ); ?></a>
            </p>
        </div>
        <hr>

        <div id="getting-started">

            <h3><?php printf( __( 'Getting Started with %s', 'iknowledgebase' ), $theme->display( 'Name' ) ); ?></h3>

            <div class="columns-wrapper clearfix">

                <div class="column column-half clearfix">

                    <div class="section">
                        <h4><?php esc_html_e( 'Theme Documentation', 'iknowledgebase' ); ?></h4>

                        <p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'iknowledgebase' ); ?>
                        </p>
                        <p>
                            <a href="https://docs.wow-company.com/category/themes/iknowledgebase/"
                               target="_blank" class="button button-secondary">
								<?php printf( __( 'View %s Documentation', 'iknowledgebase' ), 'IKnowledgeBase' ); ?>
                            </a>
                        </p>
                    </div>

                    <div class="section">
                        <h4><?php esc_html_e( 'Theme Options', 'iknowledgebase' ); ?></h4>

                        <p class="about">
							<?php printf( __( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'iknowledgebase' ), $theme->display( 'Name' ) ); ?>
                        </p>
                        <p>
                            <a href="<?php echo wp_customize_url(); ?>"
                               class="button button-primary"><?php esc_html_e( 'Customize Theme', 'iknowledgebase' ); ?></a>
                        </p>
                    </div>

                </div>

                <div class="column column-half clearfix">

                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png"/>

                </div>

            </div>

        </div>

        <hr>

        <div id="more-features">

            <h3><?php esc_html_e( 'Get more features', 'iknowledgebase' ); ?></h3>

            <div class="columns-wrapper clearfix">

                <div class="column column-half clearfix">

                    <div class="section">
                        <h4><?php esc_html_e( 'Pro Version Add-on', 'iknowledgebase' ); ?></h4>

                        <p class="about">
							<?php printf( __( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'iknowledgebase' ), 'iknowledgebase' ); ?>
                        </p>
                        <p>
                            <a href=" https://wow-estore.com/item/iknowledgebase-pro/ "
                               target="_blank" class="button button-secondary">
								<?php printf( __( 'Learn more about %s Pro', 'iknowledgebase' ), 'IKnowledgeBase' ); ?>
                            </a>
                        </p>
                    </div>

                </div>


            </div>

        </div>

        <hr>

        <div id="theme-author">

            <p>
				<?php printf( __( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'iknowledgebase' ),
					$theme->display( 'Name' ),
					'<a target="_blank" href="https://wow-company.com/" title="Wow-Company">Wow-Company</a>',
					'<a target="_blank" href="https://wordpress.org/support/theme/iknowledgebase/reviews/" title="' . esc_attr__( 'Review IKnowledgeBase', 'iknowledgebase' ) . '">' . esc_html__( 'rate it', 'iknowledgebase' ) . '</a>'
				); ?>
            </p>

        </div>

    </div>

	<?php
}

/**
 * Enqueues CSS for Theme Info page
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function iknowledgebase_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_iknowledgebase' !== $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'iknowledgebase-theme-info-css', get_template_directory_uri() . '/assets/css/theme-info.css' );

}

add_action( 'admin_enqueue_scripts', 'iknowledgebase_theme_info_page_css' );
