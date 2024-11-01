<?php
/**
 * post-shortcode.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Define the shortcode for displaying posts with different designs.
function swift_post_list_shortcode($atts) {

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_style('swift-main-styles');
    wp_enqueue_style('bootstrap-styles');
    wp_enqueue_style('fontawesome-styles');
    wp_enqueue_script('bootstrap-script');
    wp_enqueue_script('swift-script');

    $atts = shortcode_atts(array(
        'post_type' => 'post',
        'design' => 'design1', // Default design style
        'show_title' => 'true',
		'show_content' => 'true',
		'show_btn' => 'true',
		'show_cat' => 'true',
		'show_tag' => 'true',
		'show_image' => 'true',
		'show_date' => 'true',
		'show_author' => 'true',
		'orderby'        => 'date',
        'order'          => 'desc',
		'posts_per_page' => 3,
		'columns'        => 2,
		'category_id'      => 0, 
		'tag_id'           => 0,
		'offset'         => 0, 
		'content_words'   => 30,
		'default_image_id' => '',
    ), $atts);

    $post_type = $atts['post_type'];
    $design = $atts['design'];
    $show_title = $atts['show_title'];
	$show_content = $atts['show_content'];
	$show_btn = $atts['show_btn'];
	$show_cat = $atts['show_cat'];
	$show_tag = $atts['show_tag'];
	$show_date = $atts['show_date'];
	$show_author = $atts['show_author'];
	$show_image = $atts['show_image'];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$offset = $atts['offset'] + ($paged - 1) * $atts['posts_per_page'];
	$total_posts = wp_count_posts($post_type)->publish;
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $atts['posts_per_page'],
        'paged'          => $paged,
		'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
		'offset'         => $offset,
    );
	// default image based on the attachment ID
    $default_image_url = wp_get_attachment_url($atts['default_image_id']);

    // If the default image ID is not provided or not found, use a default image from the plugin folder
    if (!$default_image_url) {
        $default_image_url = plugins_url('assets/images/default.jpeg', __FILE__);
    }
	 // Add category filter if provided
    if (!empty($atts['category_id'])) {
        // Get the taxonomies associated with the post type dynamically
        $taxonomies = get_object_taxonomies($atts['post_type']);
        foreach ($taxonomies as $taxonomy) {
            $term_info = get_term($atts['category_id'], $taxonomy);
            if ($term_info && $term_info->term_id == $atts['category_id']) {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $atts['category_id'],
                );
                break;
            }
        }
    }
    // Add tag filter if provided
    if (!empty($atts['tag_id'])) {
        // Get the taxonomies associated with the post type dynamically
        $taxonomies = get_object_taxonomies($atts['post_type']);
        foreach ($taxonomies as $taxonomy) {
            $term_info = get_term($atts['tag_id'], $taxonomy);
            if ($term_info && $term_info->term_id == $atts['tag_id']) {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $atts['tag_id'],
                );
                break;
            }
        }
    }
    $swift_custom_query = new WP_Query($args);

    $output = '';

    if ($swift_custom_query->have_posts()) {
        $template_file = "designs/post-list-{$design}.php";

        // Check if a specific template file for the post type exists
        if ($post_type !== 'post' && file_exists(__DIR__ . "/post-list-{$design}-{$post_type}.php")) {
            $template_file = "post-list-{$design}-{$post_type}.php";
        }

        ob_start();
        include($template_file);
        $output .= ob_get_clean();
    } else {
        $output = 'No posts found for post type ' . $post_type;
    }

    wp_reset_postdata();

    return $output;
}

add_shortcode('swiftpost-list', 'swift_post_list_shortcode');

// Function to display tags on the post
function swift_display_tags() {
    // Get the post type
    $post_type = get_post_type();

    // Retrieve the taxonomies associated with the custom post type
    $taxonomies = get_object_taxonomies( $post_type, 'objects' );

    // Variable to track if any tags are found
    $tags_found = false;

    // Variable to store the HTML output
    $html_output = '';

    // Check if taxonomies exist
    if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
        foreach ( $taxonomies as $taxonomy ) {
            if ( $taxonomy->hierarchical === false && $taxonomy->public === true ) {
                // Retrieve the tags associated with the current post and taxonomy
                $tags = get_the_terms( get_the_ID(), $taxonomy->name );

                // If tags exist, generate HTML output
                if ( $tags && ! is_wp_error( $tags ) ) {
                    $tags_found = true;
                    $html_output .= '<ul class="post-tags">';
                    $tag_count = count( $tags );
                    $i = 1;
                    foreach ( $tags as $tag ) {
                        $html_output .= '<li><a href="' . esc_url( get_term_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>';
                        // Add comma after each tag except the last one
                        if ( $i < $tag_count ) {
                            $html_output .= ', ';
                        }
                        $html_output .= '</li>';
                        $i++;
                    }
                    $html_output .= '</ul>';
                    break; // Exit the loop after displaying tags for the first suitable taxonomy
                }
            }
        }
    }

    // If no tags found
    if ( ! $tags_found ) {
        $html_output .= 'No tags found.';
    }

    // Return the HTML output
    return $html_output;
}


// Function to display categories on the post
function swift_display_categories() {
    $output = ''; // Initialize the output variable

    // Get the categories of the current post
    $categories = get_the_category();

    // Check if categories exist for the current post
    if ($categories) {
        $output .= '<ul>';
        foreach ($categories as $category) {
            $output .= '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }
        $output .= '</ul>';
    } else {
        // If no categories found for default posts, check for custom taxonomies
        $custom_taxonomies = get_object_taxonomies(get_post_type());
        foreach ($custom_taxonomies as $taxonomy) {
            $terms = get_the_terms(get_the_ID(), $taxonomy);
            if ($terms && !is_wp_error($terms)) {
                $output .= '<ul>';
                foreach ($terms as $term) {
                    $output .= '<li><a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a></li>';
                }
                $output .= '</ul>';
                break; // Break the loop after displaying categories from the first taxonomy
            }
        }
    }

    return $output; // Return the generated HTML
}
