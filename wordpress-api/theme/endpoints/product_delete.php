<?php

function api_product_delete($request) {
    $slug = $request["slug"];
    $product_id = get_product_id_by_slug($slug);
    $user = wp_get_current_user();
    $author_id = (int) get_post_field("post_author", $product_id);
    $user_id = (int) $user->ID;

    if ($user_id === $author_id) {

        $images = get_attached_media("image", $product_id);
        if ($images) {
            foreach($images as $key => $value) {
                wp_delete_attachment($value->ID, true);
            }
        }

        $response = wp_delete_post($product_id, true);

    } else {
        $response = new WP_Error("email", "Usuário não autenticado.", array("status" => 401));
    }

    return rest_ensure_response($response);
}

function register_api_product_delete() {
    register_rest_route("api", "/product/(?P<slug>[-\w]+)", array(
        array(
            "methods" => WP_REST_Server::DELETABLE,
            "callback" => "api_product_delete"
        ),
    ));
}

add_action("rest_api_init", "register_api_product_delete");

?>