<?php 

/**
 * Post list design
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function swift_plugin_styles() {
	
    wp_register_style('swift-main-styles', plugins_url('assets/css/style.css', __FILE__), array(), '1.0.0', 'all');
    wp_register_style('bootstrap-styles', plugins_url('assets/css/bootstrap.min.css', __FILE__), array(), '5.3.3', 'all');
	wp_register_style('fontawesome-styles', plugins_url('assets/css/font-awesome.min.css', __FILE__), array(), '5.15.4', 'all');
    wp_register_script('bootstrap-script', plugins_url('assets/js/bootstrap.bundle.min.js', __FILE__), array('jquery'), '5.3.3', true);
    wp_register_script('swift-script', plugins_url('assets/js/custom.js', __FILE__), array('jquery'), '1.0', true);
}




add_action('wp_enqueue_scripts', 'swift_plugin_styles');
function swift_admin_scripts() {
	wp_enqueue_style('post-database-styles', plugins_url('assets/css/swiftpost-main.css', __FILE__), array(), '1.0.0', 'all');
}	
add_action('admin_enqueue_scripts', 'swift_admin_scripts');

/**
 * Custom function to include a file from the plugin directory.
 *
 * @param string $file_name The name of the file you want to include.
 */
function swift_code_plugin_file($file_name) {
    $file_path = plugin_dir_path(__FILE__) . esc_html($file_name);
    if (file_exists($file_path)) {
        include_once($file_path);
    } else {
        // Handle the case where the file doesn't exist or provide an error message.
        // You can customize this part to your needs.
        echo 'File not found: ' . esc_html($file_name);
    }
}

swift_code_plugin_file('post-shortcode.php');


// Add a submenu under the "Settings" menu.
function swiftpost_list_settings_submenu() {
    add_submenu_page(
        'options-general.php',
        'SwiftPost List Settings',
        'SwiftPost List',
        'manage_options',
        'swiftpost-list-settings',
        'swiftpost_list_settings_page'
    );
}
add_action('admin_menu', 'swiftpost_list_settings_submenu');

// Create the content for the submenu page.
function swiftpost_list_settings_page() {
    echo '<div class="wrap">';
    echo '<h2>SwiftPost List Shortcode Usage</h2>';
    echo '<p class="subpara">Use the following shortcode to display posts with different designs:</p>';
	echo '<div class="heading-wrapper">';
    echo '<h3>Hello, we are here to assist you in displaying a list of posts in four different design templates. We aim to make it easier for you to showcase your posts. Please use the provided code based on your design preferences for the post list. The code is set up to display default posts with default settings, and the default design (Design 1) is being shown. This plugin can be utilized for any post type, including custom post types. If you have specific design preferences or requirements, you can customize the code accordingly. </h3>';
    echo '</div>';
	echo '<div class="code-wrapper code-wrapper-1">';
    echo '<code>[swiftpost-list]</code>';
    echo '</div>';
	echo '<div class="heading-wrapper">';
    echo '<h3>Here is a basic customization code for displaying a list of posts. You can adjust the values to "true" or "false" based on your specific requirements.</h3>';
    echo '</div>';
    echo '<div class="code-wrapper code-wrapper-2">';
    echo '<code>[swiftpost-list post_type="your-post-name" design="design1" show_title="true" show_cat="true" posts_per_page="6" columns="3"]</code>';
    echo '<div>';
	echo '<div class="heading-wrapper-2">';
    echo '<h3>Design</h3>';
	echo '<p>Select the design template you want to use.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" design="design1"]</code>';
    echo '<code>[swiftpost-list post_type="your-post-name" design="design2"]</code>';
	echo '<code>[swiftpost-list post_type="your-post-name" design="design3"]</code>';
    echo '<code>[swiftpost-list post_type="your-post-name" design="design4"]</code>';
    echo '</div>';
	echo '<div class="heading-wrapper-2">';
    echo '<h3>Title</h3>';
	echo '<p>The code determines whether the post title is displayed or hidden, and by default, it is set to be displayed (true).</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" show_title="false"]</code>';
	echo '<h3>Content</h3>';
	echo '<p>The content of the post is determined to be included or excluded based on the provided code, and by default, it is set to true.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" show_content="false"]</code>';
	echo '<h3>Categorary</h3>';
	echo '<p>You have the ability to display or hide categories, and you can also filter posts using the category ID.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" show_cat="false" category_id="your-category-id"]</code>';
    echo '<h3>Tag</h3>';
	echo '<p>You have the ability to display or hide tags, and you can also filter posts using the tag ID.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" show_tag="false" tag_id="123"]</code>';
	echo '<h3>Image, Date, Author</h3>';
	echo '<p>You have the option to display or hide the image, date, and author details in the post design. By default, they are set to be visible.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" show_image="true" show_date="true" show_author="false"]</code>';
	echo '<h3>Offset</h3>';
	echo '<p>If you want to adjust the position of the blog post, you can make use of an offset.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" offset="1"]</code>';
	echo '<h3>Orderby(Date/Title), Order(asc/desc)</h3>';
	echo '<p>If you had like, you can display the posts in a specific order and sort them by date, title, or in ascending (asc) or descending (desc) order.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" orderby="date/title" order="desc/asc"]</code>';
	echo '<h3>Post per page</h3>';
	echo '<p>You can also determine the number of posts displayed on each page. By default, six posts are shown on each page.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" posts_per_page="4"]</code>';
	echo '<h3>Columns</h3>';
	echo '<p>You have the ability to determine the default number of columns displayed in a post. By default, two columns will be shown.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" columns="3"]</code>';
	echo '<h3>Content length</h3>';
	echo '<p>You have the flexibility to customize the length of the content as per your needs. The default setting is 30 characters.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" content_words="40"]</code>';
    echo '<h3>Default Image</h3>';
	echo '<p>In this code, if a featured image is not available for your posts, a default image will be displayed in the post. You have the option to change this default image by using its image ID.</p>';
	echo '<code>[swiftpost-list post_type="your-post-name" default_image_id="123"]</code>';
    echo '</div>';
    echo '</div>';
}


