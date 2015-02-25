<?php
/**
 * Like in Timber Regions, functions.php is just for bootstrapping code. At the
 * moment, it only contains includes for theme classes, and ultimately the Timber
 * Regions bootstrap. Look at the note there for more info on the different
 * options you have using it as a base.
 */


// At the moment, we assume that Timber Regions is installed as a theme. When
// distributing the theme, you can consider bundling Timber Regions with it. See
// the comment at the bottom of this file.
if ( !file_exists( dirname( get_template_directory() ) . '/timber-regions/functions.php' ) ) {

    add_action( 'all_admin_notices', function() {
        echo __( '<div class="error"><p><strong>Timber Foundation</strong> is not active!</p><p>You need to install <a href="https://github.com/mgmartel/timber-regions" target="_blank">Timber Regions</a> before you can use this theme.</div>', 'timber-foundation' );
    });

    return;

}

$includes = array(
    'lib/theme-options.php',
    locate_template( 'lib/theme-options.php' )
);

foreach( $includes as $include ) {
    require_once $include;
}

$theme_includes = array(
    'lib/nav.php',      // Navigation walker
    'lib/template.php', // Template methods
    'lib/admin.php',    // Admin related stuff
);

foreach ( $theme_includes as $file ) {
    if ( !$filepath = locate_template( $file ) ) {
        trigger_error( sprintf( __( 'Error locating %s for inclusion', 'timber-regions' ), $file ), E_USER_ERROR );
    }

    require $filepath;
}

/**
 * Require the Timber Regions theme. Loading it like this keeps the current
 * theme still child-themeable. You could also make timber-regions a parent
 * theme. Or include it in a sub-folder inside this theme.
 */
require dirname( get_template_directory() ) . '/timber-regions/functions.php';