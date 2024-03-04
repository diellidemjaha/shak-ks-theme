<?php
// functions.php

// Enqueue custom styles and Bootstrap 5
function enqueue_custom_styles() {
    // Enqueue Bootstrap 5 CSS
    wp_enqueue_style('shak-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    
    // Enqueue custom styles
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom-style.css');
    
    // Enqueue Bootstrap 5 JS
    wp_enqueue_script('shak-bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '0.1', true);
    
    // Enqueue jQuery in compatibility mode
    wp_enqueue_script('jquery-compat', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, true);
    wp_add_inline_script('jquery-compat', 'var $ = jQuery.noConflict();');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

// Add theme support for navigation menus
function custom_theme_setup() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'shak-ks'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Add theme support for post thumbnails
add_theme_support('post-thumbnails');
add_theme_support('comments');

// Register custom post type 'lajmet'
function register_lajmet_post_type() {
    register_post_type('lajmet', array(
        'labels' => array(
            'name' => __('Lajmet'),
            'singular_name' => __('Lajmi'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'comments'),
    ));
}
add_action('init', 'register_lajmet_post_type');

// Register custom post type 'temat_e_diskutimit'
function register_temat_e_diskutimit_post_type() {
    register_post_type('temat_e_diskutimit', array(
        'labels' => array(
            'name' => __('Temat e Diskutimit'),
            'singular_name' => __('Tema'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'comments'),
    ));
}
add_action('init', 'register_temat_e_diskutimit_post_type');

// Function to handle user registration
function register_user_on_post() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        // Sanitize and validate form data
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        // Create a new user with hashed password
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Registration successful
            wp_redirect(home_url('/registration-successful/')); // Redirect to success page
            exit;
        } else {
            // Registration failed
            $error_message = $user_id->get_error_message();
            echo "Registration failed: $error_message";
        }
    }
}
add_action('init', 'register_user_on_post');

// Customize login redirection
function custom_login_redirect($redirect_to, $request, $user) {
    // Redirect all users to the home page
    return home_url('/');
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

// Allow only logged-in users to post comments
function restrict_comments_to_logged_in_users($open, $post_id) {
    // Check if the post type is 'lajmet' or 'temat_e_diskutimit'
    if (get_post_type($post_id) === 'lajmet' || get_post_type($post_id) === 'temat_e_diskutimit') {
        // Check if the user is not logged in
        if (!is_user_logged_in()) {
            return false; // Disable comments for non-logged-in users
        }
    }
    return $open; // Allow comments for other cases
}
add_filter('comments_open', 'restrict_comments_to_logged_in_users', 10, 2);

// Allow administrators to edit all comments
function allow_administrator_to_edit_all_comments($caps, $cap, $user_id, $args) {
    // Check if the user has the 'administrator' role
    $user = get_userdata($user_id);
    if ($user && in_array('administrator', $user->roles)) {
        $caps[$cap[0]] = true;
    }
    return $caps;
}
add_filter('user_has_cap', 'allow_administrator_to_edit_all_comments', 10, 4);

// Add support for comments to custom post type 'temat_e_diskutimit'
add_action('init', 'add_comments_support_to_temat_e_diskutimit');
function add_comments_support_to_temat_e_diskutimit() {
    add_post_type_support('temat_e_diskutimit', 'comments');
}



