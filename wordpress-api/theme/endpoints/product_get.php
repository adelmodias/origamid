<?php

function api_product_get($request) {
    $slug = $request["slug"];
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

?>