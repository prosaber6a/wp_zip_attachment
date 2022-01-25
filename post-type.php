<?php
function prozip_register_my_cpts()
{

    /**
     * Post Type: Products.
     */

    $labels = [
        "name" => __("Products", "prozip"),
        "singular_name" => __("Product", "prozip"),
        "menu_name" => __("Zip Products", "prozip"),
    ];

    $args = [
        "label" => __("Products", "prozip"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => false,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "pro_zip_product", "with_front" => false],
        "query_var" => true,
        "menu_icon" => "dashicons-pdf",
        "supports" => ["title", "custom-fields"],
        "show_in_graphql" => false,
    ];

    register_post_type("pro_zip_product", $args);
}

add_action('init', 'prozip_register_my_cpts');
