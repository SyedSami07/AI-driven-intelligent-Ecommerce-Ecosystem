<?php
session_start();
include_once("../class/adminback.php"); 
$obj = new adminback();
$db = $obj->connection; // Using the connection property from your class

// Updated SQL to include a count of bullying messages flagged by the AI
$sql = "SELECT DISTINCT m.sender_id, u.user_name, 
        SUM(CASE WHEN m.is_bullying = 1 THEN 1 ELSE 0 END) as bullying_count
        FROM chat_messages m 
        JOIN users u ON m.sender_id = u.user_id 
        WHERE m.sender_id != 1
        GROUP BY m.sender_id, u.user_name"; 

$result = mysqli_query($db, $sql);
$data = [];

if($result){
    while($row = mysqli_fetch_assoc($result)){
        // We cast the count to an integer for the frontend
        $row['bullying_count'] = intval($row['bullying_count']);
        $data[] = $row;
    }
}
echo json_encode($data);
?>