<?php

function api_user_put($request) {
    $user = wp_get_current_user();
    $user_id = $user->ID;

    if ($user_id > 0) {
        $name = sanitize_text_field($request["name"]);
        $email = sanitize_email($request["email"]);
        $senha = $request["senha"];
        $rua = sanitize_text_field($request["rua"]);
        $cep = sanitize_text_field($request["cep"]);
        $numero = sanitize_text_field($request["numero"]);
        $bairro = sanitize_text_field($request["bairro"]);
        $cidade = sanitize_text_field($request["cidade"]);
        $estado = sanitize_text_field($request["estado"]);

        $email_exists = email_exists($email);

        if ( !$email_exists || $email_exists === $user_id ) {
            $response = array(
                'ID' => $user_id,
                'user_pass' => $senha,
                'user_email' => $email,
                'display_name' => $name,
                'first_name' => $name,
            );

            wp_update_user($response);

            update_user_meta($user_id, 'rua', $rua);
            update_user_meta($user_id, 'cep', $cep);
            update_user_meta($user_id, 'numero', $numero);
            update_user_meta($user_id, 'bairro', $bairro);
            update_user_meta($user_id, 'cidade', $cidade);
            update_user_meta($user_id, 'estado', $estado);

            // return rest_ensure_response("Usuário criado com sucesso.");
        } else {
            $response = new WP_Error("email", "E-mail já cadastrado.", array("status" => 403));
        }
    } else {
        $response = new WP_Error("email", "Usuário não autenticado.", array("status" => 401));
    }

    return rest_ensure_response($response);
}

function register_api_user_put() {
    register_rest_route("api", "/user", array(
        array(
            "methods" => WP_REST_Server::EDITABLE,
            "callback" => "api_user_put"
        ),
    ));
}

add_action("rest_api_init", "register_api_user_put");

?>