<?php 
    // 1. Process Database Updates FIRST
    if(isset($_POST['update_status_btn'])){
       $status_msg = $obj->updat_order_status($_POST);
    }

    // 2. Fetch Fresh Data AFTER the update
    $catagories = $obj->display_catagory();
    $all_order_info = $obj->all_order_info();

    $order_infos = array();
    while($all_order = mysqli_fetch_assoc($all_order_info)){
        $order_infos[] = $all_order; 
    }
?>

<h2>Manage order</h2>

<?php 
    if(isset($status_msg)){
        echo "<div class='alert alert-success'>{$status_msg}</div>";
    }
?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Products</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Uses Coupon</th>
                <th>Customer Name</th>
                <th>Customer Mobile</th>
                <th>Trans No</th>
                <th>Shipping</th>
                <th>Order Status</th>
                <th>Update Status</th>
                <th>Placing Time</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($order_infos as $order_info){ ?>
            <tr>
                <td><?php echo $order_info['order_id'] ?></td>
                <td><?php echo $order_info['product_name'] ?></td>
                <td><?php echo $order_info['pdt_quantity'] ?></td>
                <td><?php echo $order_info['amount'] ?></td>
                <td><?php echo $order_info['uses_coupon'] ?></td>
                <td><?php echo $order_info['customer_name'] ?></td>
                <td><?php echo $order_info['Shipping_mobile'] ?></td>
                <td><?php echo $order_info['trans_id'] ?></td>
                <td><?php echo $order_info['shiping_address'] ?></td>
                <td>
                    <?php 
                        if($order_info['order_status']==0){
                            echo "<span class='badge badge-danger'> Pending </span>";
                        } elseif($order_info['order_status']==1){
                            echo "<span class='badge badge-warning'> Processing </span>";
                        } elseif($order_info['order_status']==2){
                            echo "<span class='badge badge-success'> Delivered </span>";
                        } elseif($order_info['order_status']==3){
                            echo "<span class='badge badge-secondary'> Cancelled </span>";
                        }
                    ?>
                </td>

                <td>
                    <form action="" method="POST" class="form-inline">
                        <select name="update_status" class="form-control form-control-sm ">
                            <option value="0" <?php if($order_info['order_status']==0) echo "selected"; ?>>Pending</option>
                            <option value="1" <?php if($order_info['order_status']==1) echo "selected"; ?>>Processing</option>
                            <option value="2" <?php if($order_info['order_status']==2) echo "selected"; ?>>Delivered</option>
                            <option value="3" <?php if($order_info['order_status']==3) echo "selected"; ?>>Cancelled</option>
                        </select>
                        <input type="hidden" name="order_id" value="<?php echo $order_info['order_id'] ?>">
                        <input type="submit" value="Update" name="update_status_btn" class="btn btn-danger btn-dark mt-1">
                    </form>
                </td>
                <td><?php echo $order_info['order_time'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>