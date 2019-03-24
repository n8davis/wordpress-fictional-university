<?php
require_once 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

add_action('wp_enqueue_scripts',LOAD_THEME_FILES);
add_action('after_setup_theme', LOAD_THEME_FEATURES);
add_action('pre_get_posts', ADJUST_MAIN_QUERIES);
add_filter( 'nav_menu_css_class' , ADD_NAV_CSS_CLASS , 10, 2 );