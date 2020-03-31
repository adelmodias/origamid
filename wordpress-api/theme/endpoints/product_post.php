<?php

function api_product_post($request) {
    $user = wp_get_current_user();
    $user_id = $user->ID;

    if ($user_id > 0) {

        $name = sanitize_text_field($request["name"]);
        $description = sanitize_text_field($request["description"]);
        $price = sanitize_text_field($request["price"]);
        $user_login = $user->user_login;

        $response = array(
            "post_author" => $user_id,
            "post_title" => $name,
            "post_type" => "product",
            "post_status" => "publish",
            "meta_input" => array(
                "name" => $name,
                "price" => $price,
                "description" => $description,
                "user_id" => $user_login,
                "sold" => false
            ),
        );

        $product_id = wp_insert_post($response);
        $response["id"] = get_post_field("post_name", $product_id);

        $files = $request->get_file_params();

        if ($files) {
            require_once(ABSPATH . "wp-admin/includes/image.php");
            require_once(ABSPATH . "wp-admin/includes/file.php");
            require_once(ABSPATH . "wp-admin/includes/media.php");

            foreach ($files as $file => $array) {
                media_handle_upload($file, $product_id);
            }

        }

    } else {
        $response = new WP_Error("email", "Usuário não autenticado.", array("status" => 401));
    }

    return rest_ensure_response($response);
}

function register_api_product_post() {
    register_rest_route("api", "/product", array(
        array(
            "methods" => WP_REST_Server::CREATABLE,
            "callback" => "api_product_post"
        ),
    ));
}

add_action("rest_api_init", "register_api_product_post");

?>