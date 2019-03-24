<?php

// loads all of the necessary files for the theme
function university_files() {
    // loads css files
    wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style('university_main_styles',
        get_stylesheet_uri(),
        null,
        microtime() // disables cache during development
    );

    // loads js files
    wp_enqueue_script(
        'main_university_js',
        get_theme_file_uri('js/scripts-bundled.js'),
        null,
        microtime(), // disables cache during development
        true
    );
}
// loads theme features
function university_features() {

    // register menus ...
    register_nav_menu(
        'headerMenuLocation',
        'Header Menu Location.'
    );
    register_nav_menu(
        'footerOne',
        'Footer One Menu Location.'
    );
    register_nav_menu(
        'footerTwo',
        'Footer Two Menu Location.'
    );

    // loads title of page in <head>
    add_theme_support('title-tag');
    // enables featured images on posts
    add_theme_support('post-thumbnails');
    // tell WP to add a custom image size
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

/**
 * Tells WP how to get all posts, pages, etc.
 * @param WP_Query $query
 */
function university_adjust_queries($query) {
    // Adjust Programs Query
    if (
        !is_admin()
        AND is_post_type_archive('program')
        AND $query->is_main_query()
    ) {
        $query->set('orderby', 'title');
        $query->set('order', 'asc');
        $query->set('posts_per_page', -1);

    }
    // Adjust Events Query
    if (
        ! is_admin()
        AND is_post_type_archive('event')
        AND $query->is_main_query()
    ) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'asc');
        $query->set('meta_query', [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            ]
        ]);
    }
}

/**
 * Filter the CSS class for a nav menu based on a condition.
 *
 * @link https://developer.wordpress.org/reference/functions/add_filter/
 *
 * @param array  $classes The CSS classes that are applied to the menu item's <li> element.
 * @param object $item    The current menu item.
 * @return array (maybe) modified nav menu class.
 */
function add_nav_class( $classes, $item ) {
    if ( is_page('past-events') AND $item->post_title === 'Events') {
        // Notice you can change the conditional from is_single() and $item->title
        $classes[] = "current-menu-item";
    }
    return $classes;
}

/**
 * @param array $args
 */
function pageBanner( $args = null ) {
    if (! isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    if (! isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_sub_title');
    }
    if (! isset($args['photo'])) {
        if ( $image = get_field('page_banner_background_image') ) {
            $args['photo'] = $image['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url('<?= $args['photo'] ?>');">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?= $args['title'] ?>
            </h1>
            <div class="page-banner__intro">
                <p>
                    <?= $args['subtitle'];?>
                </p>
            </div>
        </div>
    </div>

    <?php
}