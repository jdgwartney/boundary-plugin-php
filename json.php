<?php
$arr = array(
    array(array(
        "region" => "valore",
        "price" => "valore2")
    ),
    array(
        "region" => "valore",
        "price" => "valore2"
    ),
    array(
        "region" => "valore",
        "price" => "valore2"
    )
);

echo json_encode($arr);
print("");

$products = array(
    array("foo:"," bar"),
    array(),
    array(),
    array()
);

echo json_encode($products);
?>

