<?php
function register_transaction() {
    register_post_type("transaction", array(
        "label" => "Transação",
        "description" => "Transação",
        "public" => true,
        "show_ui" => true,
        "capability_type" => "post",
        "rewrite" => array(
            "slug" => "transacao",
            "with_front" => true
        ),
        "query_var" => true,
        "supports" => array("custom-fields", "author", "title"),
        "publicly_queryable" => true
    ));
}
add_action("init", "register_transaction");
?>