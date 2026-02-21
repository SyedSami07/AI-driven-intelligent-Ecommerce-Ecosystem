<?php
session_start();
include_once("../class/adminback.php"); 
$obj = new adminback();
$db = $obj->connection; // Using the connection property directly

$uid = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Fetch messages including the is_bullying column
$sql = "SELECT * FROM chat_messages WHERE (sender_id = $uid OR receiver_id = $uid) ORDER BY id ASC";

$result = mysqli_query($db, $sql);
$data = [];

if($result){
    while($row = mysqli_fetch_assoc($result)) {
    // We send the flag. The frontend will decide whether to mask it.
    // If you want to be extra secure, only send the full text if session user_id == 1
    $row['is_bullying'] = intval($row['is_bullying']);
    $data[] = $row;
}
}

echo json_encode($data);
?>