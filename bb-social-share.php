<?php
/**
 * Plugin Name: BB Social Share
 * Plugin URI: https://github.com/yesbhautik/bb-social-share/
 * Description: A plugin that adds social sharing buttons to the WooCommerce product page.
 * Version: 1.0
 * Author: Bhautik Bavdiya
 * Author URI: https://www.instagram.com/yesbhautik
 * License: GPL3
 */

function bb_social_share_buttons() {
    global $post;
    $product_url = get_permalink( $post->ID );
    $product_title = get_the_title( $post->ID );

    //Shorten the product URL using Bit.ly
    $apiKey = "8e4b63a4c1a74ecd3f46d08ba45063d30759efbb";
    $url = "https://api-ssl.bitly.com/v4/shorten";
    $data = json_encode( array( "long_url" => $product_url ) );

    $options = array(
        "http" => array(
            "header" => "Content-type: application/json\r\n" .
                        "Authorization: Bearer " . $apiKey,
            "method" => "POST",
            "content" => $data,
        ),
    );
    $context = stream_context_create( $options );
    $result = json_decode( file_get_contents( $url, false, $context ) );
    $short_url = $result->link;

    echo '<div class="bb-social-share">';
    echo '<a href="https://www.facebook.com/sharer.php?u=' . $short_url . '&t=' . $product_title . '" target="_blank">Facebook</a>';
    echo '<a href="https://twitter.com/share?url=' . $short_url . '&text=' . $product_title . '" target="_blank">Twitter</a>';
    echo '<a href="https://plus.google.com/share?url=' . $short_url . '" target="_blank">Google+</a>';
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'bb_social_share_buttons', 35 );

function bb_social_share_css() {
    echo '<style type="text/css">
        .bb-social-share {
            margin: 20px 0;
        }
        .bb-social-share a {
            display: inline-block;
            margin-right: 10px;
            padding: 5px 10px;
            background: #333;
            color: #fff;
            text-decoration: none;
        }
        .bb-social-share a:hover {
            background: #000;
        }
    </style>';
}
add_action( 'wp_head', 'bb_social_share_css' );

?>
