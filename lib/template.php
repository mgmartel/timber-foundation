<?php
/**
 * A few template functions. Because sometimes you just need some extra logic in
 * your templates (in rendering pagination for example), it can be easier to have
 * a php function take care of the heavy lifting. That is what this class is for.
 */

class TimberFoundationTemplate
{
    /**
     * Single comment callback
     *
     * Using the callback so the walker can go through and give us nested comments
     *
     * @param type $comment
     * @param type $args
     * @param type $depth
     *
     * @todo Add AJAX threaded comments?
     */
    public static function comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?>>
            <article id="comment-<?php comment_ID(); ?>">
                <header class="comment-author">
                    <?php echo get_avatar($comment,$size='48'); ?>
                    <div class="author-meta">
                        <?php printf(__('<cite class="fn">%s</cite>', 'timber-foundation'), get_comment_author_link()) ?>
                        <time datetime="<?php echo comment_date('c') ?>"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s', 'timber-foundation'), get_comment_date(),  get_comment_time()) ?></a></time>
                        <?php edit_comment_link(__('(Edit)', 'timber-foundation'), '', '') ?>
                    </div>
                </header>

                <?php if ($comment->comment_approved == '0') : ?>
                    <div class="notice">
                        <p class="bottom"><?php _e('Your comment is awaiting moderation.', 'timber-foundation') ?></p>
                    </div>
                <?php endif; ?>

                <section class="comment">
                    <?php comment_text() ?>
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </section>

            </article>
    <?php

    }

    public static function pagination() {
        global $wp_query;

        $big = 999999999; // This needs to be an unlikely integer

        // For more options and info view the docs for paginate_links()
        // http://codex.wordpress.org/Function_Reference/paginate_links
        $paginate_links = paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'mid_size' => 5,
            'prev_next' => True,
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'type' => 'list'
        ) );

        // Display the pagination if more than one page is found
        if ( $paginate_links ) {
            return '<div class="pagination-centered">'
                 . $paginate_links
                 . '</div>';
        }
    }
}