<?php
/**
 * All the theme functionality happens in here. A lot of the normal boilerplate
 * code has been taken care of by the TimberRegionsSite class. For example, we
 * only have to populate the TimberFoundationSite::$nav_menus var to add nav
 * menus. Check out TimberRegionsSite for a more elaborate explanation of what
 * happens here.
 */

class TimberFoundationSite extends TimberRegionsSite {

    const VERSION = '0.1';

    public $foundation_js_vars = array();

    public function __construct(){
        $this->editor_style = 'assets/css/editor-style.css';

        $this->theme_supports[] = 'foundation-icons';
        $this->theme_supports['custom-background'] = array(
            'default-image' => '', // background image default
            'default-color' => '', // background color default (dont add the #)
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        );

        $this->nav_menus['primary']      = __( 'Primary (left)', 'timber-foundation' );
        $this->nav_menus['topbar-right'] = __( 'Primary (right)', 'timber-foundation' );
        $this->nav_menus['footer']       = __( 'Footer Menu', 'timber-foundation' );

        $this->sidebars[] = array(
            'name'          => __( 'Sidebar', 'timber-foundation' ),
            'id'            => 'sidebar',
            'before_widget' => '<article id="%1$s" class="panel widget %2$s">',
            'after_widget'  => '</article>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        );

        $this->sidebars[] = array(
            'id'            => 'footer-wide',
            'name'          => __( 'Full-Width Footer', 'timber-foundation' ),
            'before_widget' => '<div class="large-12 columns"><article id="%1$s" class="widget %2$s">',
            'after_widget'  => '</article></div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        );

        $this->sidebars[] = array(
            'id'            => 'footer',
            'name'          => __( 'Footer', 'timber-foundation' ),
            'before_widget' => '<div class="large-3 columns"><article id="%1$s" class="widget %2$s">',
            'after_widget'  => '</article></div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        );

        $this->setup_wp_title();
        parent::__construct();
    }

    private function _get_uri() {
        return get_template_directory_uri();
        // return is_child_theme() ? get_stylesheet_directory_uri() : get_template_directory_uri();
    }

    public function register_styles() {
        global $wp_styles;

        // @todo Add a filter for child themes to decide whether to load the parent styles or not
        $uri = get_stylesheet_directory_uri() . '/assets/css/';

        // foundation stylesheet
        wp_register_style( 'timber-foundation', $this->_get_uri() . '/assets/css/app.css', array(), '' );

        // Register the main style
        wp_register_style( 'theme-stylesheet', $uri . 'style.css', array(), '', 'all' );

        // Foundation Font Icons
        wp_register_style( 'foundation-icons', $this->_get_uri() . '/assets/css/foundation-icons.css', array(), '', 'all' );

        // register Google fonts
        //wp_register_style('google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Lora:400,700|Droid+Sans+Mono ');

        // ie-only style sheet
        wp_register_style( 'timber-foundation-ie-only', $uri . 'ie.css', array(), self::VERSION, 'screen' );
        $wp_styles->add_data( 'timber-foundation-ie-only', 'conditional', 'lt IE 9' );

        parent::register_styles();
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'timber-foundation' );
        wp_enqueue_style( 'theme-stylesheet' );

        // IE styles
        wp_enqueue_style('timber-foundation-ie-only');

        //wp_enqueue_style( 'google-font' );

        if ( current_theme_supports( 'foundation-icons' ) )
            wp_enqueue_style( 'foundation-icons' );

        parent::enqueue_styles();
    }

    public function register_scripts() {

        $uri = $this->_get_uri() . '/assets/js/';

        // modernizr (without media query polyfill)
        wp_register_script( 'timber-foundation-modernizr', $uri . 'modernizr.js', array(), '2.6.2', false );

        // comment reply script for threaded comments
        if( get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }

        // adding Foundation scripts file in the footer
        $min = defined( 'SCRIPT_DEBUG' && SCRIPT_DEBUG ) ? '.min' : '';
        wp_register_script( 'foundation', $uri . "foundation$min.js", array( 'jquery' ), '', true );

        // @todo IE conditional
        //wp_register_script( 'html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js" , false, true );

        parent::register_scripts();
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'timber-foundation-modernizr' );
        wp_enqueue_script( 'foundation' );

        if ( !is_admin() ) {
            $foundation_js_vars = $this->foundation_js_vars;
            add_action( 'wp_footer', function() use ( $foundation_js_vars ) {
                ?>

                <script>
                    (function($) {
                        $(document).foundation(<?php if ( !empty( $foundation_js_vars ) ) echo json_encode( $foundation_js_vars ); ?>);
                    })(jQuery);
                </script>
                <?php
                do_action( 'timber_foundation_init' );
            }, 999 );
        }

        parent::enqueue_scripts();
    }

    public function get_theme_regions() {
        return new TimberFoundationRegions;
    }

    public function add_to_context( $context ){
        // Theme Options/Settings - prevent to run twice if child-themed
        if ( !isset( $context['theme_options'] ) )
            $context['theme_options'] = new TimberFoundation_ThemeOptions();

        $context = parent::add_to_context( $context );

        // Override the title and force the seperator on the right
        $context['wp_title'] = TimberHelper::get_wp_title( '&raquo;', 'right' );

        // Menu
        $context = $this->add_menus_to_context( $context );

        // WP API
        $context['dynamic_sidebar'] = TimberHelper::function_wrapper( 'dynamic_sidebar', array(), true );
        $context['is_user_logged_in'] = is_user_logged_in();
        $context['current_user'] = ( is_user_logged_in() ) ? new TimberUser() : false;

        $context['wp_login_url'] = TimberHelper::function_wrapper('wp_login_url', array( get_permalink() ) );
        $context['wp_logout_url'] = TimberHelper::function_wrapper('wp_logout_url', array( get_permalink() ) );

        global $comment_author, $comment_author_email, $comment_author_url;
        $context['comment_author'] = $comment_author;
        $context['comment_author_email'] = $comment_author_email;
        $context['comment_author_url'] = $comment_author_url;

        return $context;
    }

        protected function add_menus_to_context( $context ) {
            $context['menu'] = new TimberMenu( 'primary' );
            $context['menu_left'] = TimberHelper::function_wrapper( 'wp_nav_menu', array( array(
                'theme_location' => 'primary',
                'container' => false,
                'depth' => 0,
                'items_wrap' => '<ul class="left">%3$s</ul>',
                //'fallback_cb' => array( 'TimberFoundation_Walker', 'render_menu_fallback' ),
                'fallback_cb' => false,
                'walker' => new TimberFoundation_Walker( array(
                    'in_top_bar' => true,
                    'add_dividers' => true,
                    'item_type' => 'li',
                    'menu_type' => 'main-menu'
                ) ),
            ) ) );

            $context['menu_right'] = TimberHelper::function_wrapper( 'wp_nav_menu', array( array(
                'theme_location' => 'topbar-right',
                'container' => false,
                'depth' => 0,
                'items_wrap' => '<ul class="right">%3$s</ul>',
                'fallback_cb' => false,
                'walker' => new TimberFoundation_Walker( array(
                    'in_top_bar' => true,
                    'add_dividers' => true,
                    'item_type' => 'li',
                    'menu_type' => 'main-menu'
                ) ),
            ) ) );

            // Footer
            $context['footer_menu'] = new TimberMenu( 'footer' );

            return $context;
        }

    function add_to_twig($twig){
        // Foundation
        $twig->addFunction( 'pagination', new Twig_SimpleFunction( 'pagination', array( 'TimberFoundationTemplate', 'pagination' ) ) );

        // WP API
        $twig->addFunction(new Twig_SimpleFunction( 'is_active_sidebar', 'is_active_sidebar' ) );

        return parent::add_to_twig( $twig );
    }

    public function add_body_classes( $body_classes ) {
        $body_classes[] = 'antialiased';
        return parent::add_body_classes( $body_classes );
    }

    //
    // SITE TITLE
    //
    protected function setup_wp_title() {
        add_filter( 'wp_title', array( $this, 'wp_title' ), 10, 2 );
    }

        /**
         * Based on twentyfourteen_wp_title
         */
        public function wp_title( $title, $sep ) {
            global $paged, $page;

            if ( is_feed() ) {
                return $title;
            }

            // Add the site name.
            $title .= get_bloginfo( 'name', 'display' );

            // Add the site description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) ) {
                $title = "$title $sep $site_description";
            }

            // Add a page number if necessary.
            if ( $paged >= 2 || $page >= 2 ) {
                $title = "$title $sep " . sprintf( __( 'Page %s', 'timber-foundation' ), max( $paged, $page ) );
            }

            return $title;
        }

}