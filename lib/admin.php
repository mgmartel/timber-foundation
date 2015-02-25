<?php
/**
 * This class adds button and panel styles to TinyMCE
 *
 * Based on: http://www.sennza.com.au/2014/02/21/add-foundation-5-styles-tinymce-wordpress/
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

class TimberFoundationAdmin
{
    /**
     * @return TimberFoundationAdmin
     */
    public static function get_instance() {
        static $instance = false;

        if ( !$instance ) {
            $class = get_class();
            $instance = new $class();
            $instance->init();
        }

        return $instance;
    }

    protected function __construct(){}

    protected function init() {
        // MCE Styles - from Flair: https://github.com/sennza/Flair
        add_filter( 'mce_buttons_2', array( $this, 'mce_buttons' ) );
        add_filter( 'tiny_mce_before_init', array( $this, 'mce_before_init' ) );
    }

    public function mce_buttons( $buttons ) {
        array_unshift( $buttons, 'styleselect' );
        return $buttons;
    }

    public function mce_before_init( $init_array ) {
        // Add back some more of styles we want to see in TinyMCE
        $init_array['preview_styles'] = "font-family font-size font-weight font-style text-decoration text-transform color background-color padding";

        $style_formats = array(
            array(
                'title'    => 'Button',
                'attributes' => array( 'href' => '#'),
                'classes'  => 'button',
                'inline'   => 'a'
            ),
            array(
                'title'    => 'Secondary Button',
                'attributes' => array( 'href' => '#'),
                'inline' => 'a',
                'classes'  => 'button secondary',
            ),
            array(
                'title'    => 'Success Button',
                'attributes' => array( 'href' => '#'),
                'inline' => 'a',
                'classes'  => 'button success',
            ),
            array(
                'title'    => 'Alert Button',
                'attributes' => array( 'href' => '#'),
                'inline' => 'a',
                'classes'  => 'button alert',
            ),
            array(
                'title'    => 'Label',
                'classes'  => 'label',
                'inline'   => 'span'
            ),
            array(
                'title'    => 'Secondary Label',
                'classes'  => 'label secondary',
                'inline' => 'span',
            ),
            array(
                'title'    => 'Success Label',
                'classes'  => 'label success',
                'inline' => 'span',
            ),
            array(
                'title'    => 'Alert Label',
                'classes'  => 'label alert',
                'inline' => 'span',
            ),
            array(
                'title'    => 'Panel',
                'classes'  => 'panel',
                'block'    => 'div',
                'wrapper'  => true
            ),
            array(
                'title'    => 'Panel Callout',
                'classes'  => 'panel callout',
                'inline' => 'span',
            ),
        );
        // Insert the array, json encoded, into 'style_formats'
        $init_array['style_formats'] = json_encode( $style_formats );

        return $init_array;
    }
}

if ( is_admin() )
    TimberFoundationAdmin::get_instance();
