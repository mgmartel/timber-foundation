<?php
/**
 * This class will be the main interface for puzzling together the theme. It
 * defines the available regions and their default region templates. Check out
 * theme-options.php to see how to easily interact with this class.
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

class TimberFoundationRegions extends TimberRegions
{
    public static $wrapper = 'default';
    public static $layout  = 'sidebar-right';

    protected static $_regions = array(
        'header' => array( 'topbar'),
        'header-small' => array(),
        'header-large' => array(),

        'footer' => array(
            'widgets',
            'menu',
            'colophon'
        ),

        'offcanvas' => array( 'menu' )
    );
}