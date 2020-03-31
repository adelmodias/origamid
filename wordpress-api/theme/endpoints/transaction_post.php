<?php

function api_transaction_post($request) {
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $product_sold = $request["product"]["sold"] === "false";

    if ($user_id > 0) {
        $product_slug = sanitize_text_field($request["product"]["id"]);
        $product_name = sanitize_text_field($request["product"]["name"]);
        $customer_id = sanitize_text_field($request["customer_id"]);
        $seller_id = sanitize_text_field($request["seller_id"]);
        $address = json_encode($request["address"], JSON_UNESCAPED_UNICODE);
        $product = json_encode($request["product"], JSON_UNESCAPED_UNICODE);

        $product_id = get_product_id_by_slug($product_slug);
        update_post_meta($product_id, "sold", true);

        $response = array(
            "post_author" => $user_id,
            "post_type" => "transaction",
            "post_title" => $customer_id . " - " . $product_name,
            "post_status" => "publish",
            "meta_input" => array(
                "customer_id" => $customer_id,
                "seller_id" => $seller_id,
                "address" => $address,
                "product" => $product
            ),
        );

        $post_id = wp_insert_post($response);
    } else {
        $response = new WP_Error("email", "Usuário não autenticado.", array("status" => 401));
    }

    return rest_ensure_response($response);
}

function register_api_transaction_post() {
    register_rest_route("api", "/transaction", array(
        array(
            "methods" => WP_REST_Server::CREATABLE,
            "callback" => "api_transaction_post"
        ),
    ));
}

add_action("rest_api_init", "register_api_transaction_post");

?>