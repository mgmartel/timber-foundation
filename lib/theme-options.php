<?php
/**
 * This class demonstrates how easily components and layouts can be swapped out
 * thanks to the Timber Regions architecture. It doesn't expose any real theme
 * options panel yet, but developers can quite sipmle change the class vars,
 * which will in turn take care of setting up specific collections of regions.
 */


// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

class TimberFoundation_ThemeOptions
{
    protected $header_menu_type = 'responsive'; //responsive|offcanvas|topbar
    protected $offcanvas_side   = 'right'; // left|right

    protected $topbar_classes = array(
        'contain-to-grid',
        'sticky'
    );

    public function __construct() {
        $this->setup_header();
    }

    protected function setup_header() {
        if ( 'responsive' === $this->header_menu_type ) {
                $this->setup_offcanvas_responsive();
        } elseif ( 'offcanvas' === $this->header_menu_type ) {
            $this->setup_offcanvas();
        } else {
            $this->setup_topbar();
        }
    }

    protected function setup_topbar() {
        TimberFoundationRegions::set_wrapper( 'default' );
        TimberFoundationRegions::set_header( 'topbar' );

        TimberFoundationRegions::unset_header_large();
        TimberFoundationRegions::unset_header_small();
    }

    protected function setup_offcanvas() {
        TimberFoundationRegions::set_wrapper( 'offcanvas' );
        TimberFoundationRegions::set_header( 'tabbar' );

        TimberFoundationRegions::unset_header_large();
        TimberFoundationRegions::unset_header_small();
    }

    protected function setup_offcanvas_responsive() {
        TimberFoundationRegions::set_wrapper( 'offcanvas' );

        TimberFoundationRegions::unset_header();
        TimberFoundationRegions::set_header_large( 'topbar' );
        TimberFoundationRegions::set_header_small( 'tabbar' );
    }

    public function get_offcanvas_side() {
        return $this->offcanvas_side;
    }
        public function offcanvas_side() {
            return $this->get_offcanvas_side();
        }

    public function get_topbar_classes() {
        return $this->topbar_classes;
    }

        public function topbar_classes() {
            return implode( " ", $this->get_topbar_classes() );
        }
}