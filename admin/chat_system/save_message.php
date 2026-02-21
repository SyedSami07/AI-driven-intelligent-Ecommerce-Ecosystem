<?php
session_start();
include_once("../class/adminback.php"); 
$obj = new adminback();
$db = $obj->connection; // Using the connection property from your class

$s_id = $_POST['sender_id'] ?? 0;
$r_id = $_POST['receiver_id'] ?? 1;
$msg_text = $_POST['message'] ?? '';

if(!empty($msg_text) && $s_id != 0){
    
    // 1. Send the text to Port 5001 for AI analysis
    $is_bullying = $obj->check_cyberbullying($msg_text);
    
    // 2. Escape the message for database safety
    $safe_msg = mysqli_real_escape_string($db, $msg_text);

    // 3. Insert with the AI status (is_bullying will be 1 or 0)
    $sql = "INSERT INTO chat_messages (sender_id, receiver_id, message, is_bullying) 
            VALUES ('$s_id', '$r_id', '$safe_msg', '$is_bullying')";
    
    if(mysqli_query($db, $sql)){
        echo "Sent successfully";
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>