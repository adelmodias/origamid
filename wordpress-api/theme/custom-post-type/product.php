<?php
function register_product() {
    register_post_type("product", array(
        "label" => "Produto",
        "description" => "Produto",
        "public" => true,
        "show_ui" => true,
        "capability_type" => "post",
        "rewrite" => array(
            "slug" => "produto",
            "with_front" => true
        ),
        "query_var" => true,
        "supports" => array("custom-fields", "author", "title"),
        "publicly_queryable" => true
    ));
}
add_action("init", "register_product");
?>