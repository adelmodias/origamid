<?php
function product_scheme($slug) {
    $post_id = get_product_id_by_slug($slug);
    
    if($post_id) {
        $post_meta = get_post_meta($post_id);
        $images = get_attached_media("image", $post_id);
        $images_array = null;

        if($images) {
            $images_array = array();

            foreach ($images as $key => $value) {
                $images_array[] = array(
                    "title" => $value->post_name,
                    "src" => $value->guid
                );
            }
        }

        $response = array(
            "id" => $slug,
            "photos" => $images_array,
            "name" => $post_meta["name"][0],
            "price" => $post_meta["price"][0],
            "description" => $post_meta["description"][0],
            "sold" => $post_meta["sold"][0],
            "user_id" => $post_meta["user_id"][0],
        );

    } else {
        $response = new WP_Error("naoexiste", "Produto não encontrado.", array("status" => 404));
    }

    return $response;
}

// GET INFO OF UNIQUE PRODUCT
function api_product_get($request) {
    $response = product_scheme($request["slug"]);
    return rest_ensure_response($response);
}

function register_api_product_get() {
    register_rest_route("api", "/product/(?P<slug>[-\w]+)", array(
        array(
            "methods" => WP_REST_Server::READABLE,
            "callback" => "api_product_get"
        ),
    ));
}

add_action("rest_api_init", "register_api_product_get");

// GET ALL PRODUCTS
function api_products_get($request) {
    $q = sanitize_text_field($request["q"]) ?: "";
    $_page = sanitize_text_field($request["_page"]) ?: 0;
    $_limit = sanitize_text_field($request["_limit"]) ?: 9;
    $user_id = sanitize_text_field($request["user_id"]);

    $user_id_query = null;
    if($user_id) {
        $user_id_query = array(
            "key" => "user_id",
            "value" => $user_id,
            "compare" => "="
        );
    }

    $sold = array(
        "key" => "sold",
        "value" => false,
        "compare" => "="
    );

    $query = array(
        "post_type" => "product",
        "posts_per_page" => $_limit,
        "paged" => $_page,
        "s" => $q,
        "meta_query" => array(
            $user_id_query,
            $sold
        )
    );

    $loop = new WP_Query($query);
    $posts = $loop->posts;
    $total = $loop->found_posts;

    $products_array = array();
    foreach($posts as $key => $value) {
        $products_array[] = product_scheme($value->post_name);
    }

    $response = rest_ensure_response($products_array);
    $response->header("X-Total-Count", $total);

    return $response;
}

function register_api_products_get() {
    register_rest_route("api", "/product", array(
        array(
            "methods" => WP_REST_Server::READABLE,
            "callback" => "api_products_get"
        ),
    ));
}

add_action("rest_api_init", "register_api_products_get");

?>