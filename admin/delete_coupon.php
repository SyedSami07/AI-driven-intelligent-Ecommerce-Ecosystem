<?php
include_once("class/adminback.php");
$obj = new adminback();

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $obj->delete_coupon($id);
    header("Location: manage_coupon.php");
}
?>
