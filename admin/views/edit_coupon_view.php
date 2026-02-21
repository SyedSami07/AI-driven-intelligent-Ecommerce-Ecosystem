<?php
include_once("class/adminback.php");
$obj = new adminback();

if(isset($_GET['id'])){
    $coupon = $obj->get_coupon($_GET['id']);
}

if(isset($_POST['update_coupon'])){
    $update_msg = $obj->update_coupon($_POST);
}
?>

<h4>Update Coupon</h4>

<?php 
    if(isset($update_msg)){
        echo $update_msg;
    }
?>

<form action="" method="post" class="form">
    <input type="hidden" name="cupon_id" value="<?php echo $coupon['cupon_id']; ?>">

    <div class="form-group">
        <label for="cupon_code">Coupon Code</label>
        <input type="text" name="cupon_code" class="form-control" 
               value="<?php echo $coupon['cupon_code']; ?>" required>
    </div>

    <div class="form-group">
        <label for="cupon_description">Description</label>
        <input type="text" name="cupon_description" class="form-control" 
               value="<?php echo $coupon['description']; ?>" required>
    </div>

    <div class="form-group">
        <label for="cupon_discount">Discount (%)</label>
        <input type="number" name="cupon_discount" class="form-control" 
               value="<?php echo $coupon['discount']; ?>" required>
    </div>

    <div class="form-group">
        <label for="cupon_status">Status</label>
        <select name="cupon_status" class="form-control">
            <option value="1" <?php if($coupon['status']==1) echo "selected"; ?>>Active</option>
            <option value="0" <?php if($coupon['status']==0) echo "selected"; ?>>Inactive</option>
        </select>
    </div>

    <input type="submit" name="update_coupon" value="Update Coupon" 
           class="btn btn-block btn-primary">
</form>