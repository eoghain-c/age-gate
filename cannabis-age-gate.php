<?php
/*
Plugin Name: Cannabis Age Gate
Description: Adds a Canadian compliant age gate to your website.
Author: EC
Version: 0.2
*/

// Prevent direct access to the file.
if (!defined('ABSPATH')) {
    exit;
}

// Add custom routing to handle the Age Gate page.
add_filter('do_parse_request', 'age_gate_route', 1, 3);
function age_gate_route($continue, $wp, $extra_query_vars) {
    $request = untrailingslashit($wp->request);
    
    if ($request === 'age-gate') {
        include plugin_dir_path(__FILE__) . 'templates/age-gate.php';
        exit(); // Stops WP workflow.
    }
    
    return $continue;
}

// Refresh cookies to extend session for users who have passed the age gate.
add_action('parse_request', 'refresh_age_gate_cookies');
function refresh_age_gate_cookies() {
    if (isset($_COOKIE['age_gate']) && $_COOKIE['age_gate'] == true) {
        setcookie('age_gate', true, time() + 1200, "/");
        setcookie('province', sanitize_text_field($_COOKIE['province']), time() + 1200, "/");
    }
}

// Handle the Age Gate form submission.
add_action('admin_post_agegate', 'process_age_gate_form');
add_action('admin_post_nopriv_agegate', 'process_age_gate_form');
function process_age_gate_form() {
    session_start();

    // Sanitize user inputs.
    $province = sanitize_text_field($_POST['province']);
    $day = intval($_POST['day']);
    $month = intval($_POST['month']);
    $year = intval($_POST['year']);

    // Determine the legal age based on the province.
    $target_age = 19;
    if ($province === 'qc') {
        $target_age = 21;
    } elseif ($province === 'ab') {
        $target_age = 18;
    }

    // Calculate user age.
    $birthday = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
    $age = $birthday ? $birthday->diff(new DateTime())->y : 0;

    // Handle age validation.
    if ($age < $target_age) {
        $_SESSION['age-gate-error'] = true;
        wp_safe_redirect(home_url('/age-gate'));
    } else {
        unset($_SESSION['age-gate-error']);
        setcookie('age_gate', true, time() + 1200, "/");
        setcookie('province', $province, time() + 1200, "/");
        wp_safe_redirect(home_url());
    }

    exit;
}

// Register Age Gate settings page in the admin.
if (class_exists('ACF')) {
    add_action('acf/init', 'register_age_gate_options_pages');
    function register_age_gate_options_pages() {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => __('Age Gate Settings'),
                'menu_title' => __('Age Gate'),
                'menu_slug' => 'age-gate-settings',
                'capability' => 'edit_posts',
                'redirect' => false
            ));
        }
    }
}