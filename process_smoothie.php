<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['fruit_ids'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add each fruit from the smoothie to the cart
    foreach ($data['fruit_ids'] as $id) {
        $_SESSION['cart'][] = $id;
    }
    echo json_encode(['status' => 'success']);
}
?>