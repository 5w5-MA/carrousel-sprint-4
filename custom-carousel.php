<?php
/**
 * Plugin Name: Custom Carousel
 * Description: A simple custom carousel for WordPress.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Enqueue styles and scripts
function custom_carousel_enqueue_assets() {
    // Enqueue CSS
    wp_enqueue_style('custom-carousel-style', plugin_dir_url(__FILE__) . 'style.css');
    
    // Enqueue JS
    wp_enqueue_script('custom-carousel-script', plugin_dir_url(__FILE__) . 'js/carousel.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_carousel_enqueue_assets');


function ajoutImg()
{
    add_image_size('imagesCartesCarrousel', 500, 900, true);
}
add_action('after_setup_theme',  'ajoutImg');

// Shortcode to output the carousel HTML
function custom_carousel_shortcode($atts) {
    // Get the custom image field values from ACF
    $image_carrousel = get_field('image_carrousel'); // Assuming you have ACF fields for each image
    $image_carrousel2 = get_field('image_carrousel2');
    $image_carrousel3 = get_field('image_carrousel3');
    $image_carrousel4 = get_field('image_carrousel4');
    $image_carrousel5 = get_field('image_carrousel5');

    // Default image to use if the ACF field is empty or not found
    $default_image = plugin_dir_url(__FILE__) . 'images/default-image.jpg'; // Update this path to your default image

    // Generate the carousel HTML output
    $output = '<div class="carousel">
                <div class="carousel__list">';

    // Create an array of image fields to loop over
    $images = [$image_carrousel, $image_carrousel2, $image_carrousel3, $image_carrousel4, $image_carrousel5];

    // Loop through each image
    foreach ($images as $index => $image) {
        // Check if the image exists and has the correct size
        if ($image && isset($image['sizes']['imagesCartesCarrousel'])) {
            $image_url = esc_url($image['sizes']['imagesCartesCarrousel']);
        } else {
            // Use the default image if the ACF field is empty or missing
            $image_url = $default_image;
        }

        // Add the image to the carousel list as a background image
        $output .= '<div class="carousel__item" data-pos="' . ($index - 2) . '" style="background-image: url(' . $image_url . ');">
                        <!-- Optional: You can add text or other content here -->
                    </div>';
    }

    $output .= '</div></div>';
    
    return $output;
}

add_shortcode('custom_carousel', 'custom_carousel_shortcode');
