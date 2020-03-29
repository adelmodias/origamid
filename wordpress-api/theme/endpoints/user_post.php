<?php

function api_user_post($request) {
    $name = sanitize_text_field($request["name"]);
    $email = sanitize_email($request["email"]);
    $senha = $request["senha"];
    $rua = sanitize_text_field($request["rua"]);
    $cep = sanitize_text_field($request["cep"]);
    $numero = sanitize_text_field($request["numero"]);
    $bairro = sanitize_text_field($request["bairro"]);
    $cidade = sanitize_text_field($request["cidade"]);
    $estado = sanitize_text_field($request["estado"]);

    $user_exists = username_exists($email);
    $email_exists = email_exists($email);

    if ( !$user_exists && !$email_exists && $email && $senha ) {

        $user_id = wp_create_user($email, $senha, $email);

        $response = array(
            'ID' => $user_id,
            'display_name' => $name,
            'first_name' => $name,
            'role' => 'subscriber'
        );

        wp_update_user($response);

        update_user_meta($user_id, 'rua', $rua);
        update_user_meta($user_id, 'cep', $cep);
        update_user_meta($user_id, 'numero', $numero);
        update_user_meta($user_id, 'bairro', $bairro);
        update_user_meta($user_id, 'cidade', $cidade);
        update_user_meta($user_id, 'estado', $estado);

        return rest_ensure_response("Usuário criado com sucesso.");

    } else {
        $response = new WP_Error("email", "E-mail já cadastrado.", array("status" => 403));
        return rest_ensure_response($response);

    }
    
    // $response = array(
    //     "name" => $name,
    //     "email" => $email,
    //     "senha" => $senha,
    //     "rua" => $rua,
    //     "cep" => $cep,
    //     "numero" => $numero,
    //     "bairro" => $bairro,
    //     "cidade" => $cidade,
    //     "estado" => $estado
    // );

    // {
    // "name": "",
    // "email": "",
    // "senha": "",
    // "rua": "",
    // "cep": "",
    // "numero": "",
    // "bairro": "",
    // "cidade": "",
    // "estado": ""
    // }

    // return rest_ensure_response($response);
}

function register_api_user_post() {
    register_rest_route("api", "/user", array(
        array(
            "methods" => WP_REST_Server::CREATABLE,
            // "methods" => "GET",
            "callback" => "api_user_post"
        ),
    ));
}

add_action("rest_api_init", "register_api_user_post");

?>