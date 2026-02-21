<?php
// 1. Composer Autoloader (relative path from admin/class/ to vendor/)
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class adminback
{
    public $connection;
    function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "ecommerce";

        $this->connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$this->connection) {
            die("Databse connection error!!!");
        }
    }

    function admin_login($data)
    {
        $admin_email = $data["admin_email"];
        $admin_pass = md5($data['admin_pass']);

        $query = "SELECT * FROM `admin_info` WHERE admin_email = '$admin_email' AND admin_pass = '$admin_pass'";

        if (mysqli_query($this->connection, $query)) {
            $result = mysqli_query($this->connection, $query);
            $admin_info = mysqli_fetch_assoc($result);
            if ($admin_info) {
                header("location:dashborad.php");
                session_start();
                $_SESSION['admin_id'] = $admin_info['admin_id'];
                $_SESSION['admin_email'] = $admin_info['admin_email'];
                $_SESSION['role'] = $admin_info['role'];
            } else {
                $log_msg = "Email or password wrong";
                return $log_msg;
            }
        }
    }

    function admin_logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['role']);
        header("location:index.php");
        session_destroy();
    }

    function admin_password_recover($recover_email)
    {
        $query = "SELECT * FROM `admin_info` WHERE `admin_email`='$recover_email'";
        if (mysqli_query($this->connection, $query)) {
            $row =  mysqli_query($this->connection, $query);
            return $row;
        }
    }

    function update_admin_password($data)
    {
        $u_admin_id = $data['admin_update_id'];
        $u_admin_pass = md5($data['admin_update_password']);

        $query = "UPDATE `admin_info` SET `admin_pass`='$u_admin_pass' WHERE `admin_id`= $u_admin_id";

        if (mysqli_query($this->connection, $query)) {
            $update_mag = "You password updated successfull";
            return $update_mag;
        } else {
            return "Failed";
        }
    }

    function add_admin_user($data){
        $user_email = $data['user_name'];
        $user_pass = md5($data['user_password']);
        $user_role = $data['user_role'];

        $query = "INSERT INTO `admin_info`( `admin_email`, `admin_pass`, `role`) VALUES ('$user_email','$user_pass',$user_role)";

        if(mysqli_query($this->connection, $query)){
            $msg="{$user_email} add as a user successfully";
            return $msg;
        }
    }

    function show_admin_user(){
        $query = "SELECT * FROM `admin_info`";
        if(mysqli_query($this->connection, $query)){
            $result = mysqli_query($this->connection, $query);
            return $result;
        }
    }

    function show_admin_user_by_id($user_id){
        $query = "SELECT * FROM `admin_info` WHERE `admin_id`=$user_id";
        if(mysqli_query($this->connection, $query)){
            $result = mysqli_query($this->connection, $query);
            return $result;
        }
    }

    function update_admin($data){
        $u_id = $data['user_id'];
        $u_email = $data['u-user-email'];
        $u_role = $data['u_user_role'];
        $query = "UPDATE `admin_info` SET `admin_email`='$u_email',`role`= $u_role WHERE `admin_id`= $u_id ";
        if(mysqli_query($this->connection, $query)){
            $up_msg = "Udated successfully";
            return $up_msg;
        }
        
    }

    function delete_admin($admin_id){
        $query = "DELETE FROM `admin_info` WHERE `admin_id`=$admin_id";
        if(mysqli_query($this->connection, $query)){
            $del_msg = "User Deleted Successfully";
            return $del_msg;
        }
    }

    function add_catagory($data)
    {
        $ctg_name = $data['ctg_name'];
        $ctg_des = $data['ctg_des'];
        $ctg_status = $data['ctg_status'];

        $query = "INSERT INTO `catagory`( `ctg_name`, `ctg_des`, `ctg_status`) VALUES ('$ctg_name','$ctg_des', $ctg_status)";

        if (mysqli_query($this->connection, $query)) {
            return "{$ctg_name} added as a catagory successfully!!";
        } else {
            return "Failed to add catagory";
        }
    }

    function display_catagory()
    {
        $query = "SELECT * FROM `catagory`";

        if (mysqli_query($this->connection, $query)) {
            $ctg_info = mysqli_query($this->connection, $query);
            return $ctg_info;
        }
    }

    function p_display_catagory()
    {
        $query = "SELECT * FROM `catagory` WHERE ctg_status=1";

        if (mysqli_query($this->connection, $query)) {
            $ctg_info = mysqli_query($this->connection, $query);
            return $ctg_info;
        }
    }

    function catagory_published($id)
    {
        $query = "UPDATE `catagory` SET `ctg_status`= 1 WHERE ctg_id = $id";
        mysqli_query($this->connection, $query);
    }
    function catagory_unpublished($id)
    {
        $query = "UPDATE `catagory` SET `ctg_status`= 0 WHERE ctg_id = $id";
        mysqli_query($this->connection, $query);
    }

    function delete_catagory($id)
    {
        $query = "DELETE FROM `catagory` WHERE  ctg_id = $id";
        mysqli_query($this->connection, $query);
    }

    function display_cataByID($id)
    {
        $query = "SELECT * FROM `catagory` WHERE ctg_id = $id";

        if (mysqli_query($this->connection, $query)) {
            $cata_info = mysqli_query($this->connection, $query);
            return mysqli_fetch_assoc($cata_info);
        }
    }

    function updata_catagory($data)
    {
        $u_ctg_id = $data['u_ctg_id'];
        $u_ctg_name = $data['u_ctg_name'];
        $u_ctg_des = $data['u_ctg_des'];
        $u_ctg_status = $data['u_ctg_status'];

        $query = "UPDATE `catagory` SET `ctg_name`='$u_ctg_name',`ctg_des`='$u_ctg_des',`ctg_status`= $u_ctg_status WHERE ctg_id =  $u_ctg_id";
        if (mysqli_query($this->connection, $query)) {
            return "{$u_ctg_name} Catagory Update successfully";
        }
    }

    function add_product($data)
{
    if (empty($data['pdt_ctg'])) {
        return "❌ Please select a product category";
    }

    // 1. ESCAPE STRINGS to fix the SQL error (handling quotes like "It's")
    $pdt_name = mysqli_real_escape_string($this->connection, $data['pdt_name']);
    $pdt_des  = mysqli_real_escape_string($this->connection, $data['pdt_des']);
    
    // 2. Format numbers
    $pdt_price = floatval($data['pdt_price']);
    $pdt_stock = intval($data['pdt_stock']);
    $pdt_ctg   = intval($data['pdt_ctg']);
    $pdt_status = intval($data['pdt_status']);

    // 3. Image Handling
    $pdt_img_name = $_FILES['pdt_img']['name'];
    $pdt_img_size = $_FILES['pdt_img']['size'];
    $pdt_img_tmp  = $_FILES['pdt_img']['tmp_name'];
    $img_ext      = strtolower(pathinfo($pdt_img_name, PATHINFO_EXTENSION));

    // Basic check for file existence
    if (empty($pdt_img_name)) {
        return "❌ Please upload a product image";
    }

    list($width, $height) = getimagesize($pdt_img_tmp);

    // Validate Extension
    $valid_extensions = array("jpg", "jpeg", "png");
    if (in_array($img_ext, $valid_extensions)) {
        
        // Validate Size (2MB)
        if ($pdt_img_size <= 2000000) {
            
            // Validate Dimensions
            if ($width <= 271 && $height <= 271) {
                
                // 4. Create a unique name for the image to avoid overwriting
                $unique_img_name = time() . "_" . $pdt_img_name;

                $query = "INSERT INTO `products` (`pdt_name`, `pdt_price`, `pdt_des`, `product_stock`, `pdt_ctg`, `pdt_img`, `pdt_status`) 
                          VALUES ('$pdt_name', $pdt_price, '$pdt_des', $pdt_stock, $pdt_ctg, '$unique_img_name', $pdt_status)";

                if (mysqli_query($this->connection, $query)) {
                    move_uploaded_file($pdt_img_tmp, "uploads/" . $unique_img_name);
                    return "✅ Product uploaded successfully";
                } else {
                    return "❌ SQL Error: " . mysqli_error($this->connection);
                }

            } else {
                return "❌ Sorry!! Image max dimensions are 271x271 px. You uploaded {$width}x{$height} px.";
            }

        } else {
            return "❌ File size should not exceed 2MB";
        }
    } else {
        return "❌ File should be jpg, jpeg, or png format";
    }
}

    function display_product()
    {
        $query = "SELECT * FROM `product_info_ctg`";

        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }



    function delete_product($id)
    {
        // 1. Sanitize the ID
        $id = intval($id);

        // 2. Fetch product info to get the image name
        $sel_query = "SELECT pdt_name, pdt_img FROM `products` WHERE pdt_id=$id";
        $query = mysqli_query($this->connection, $sel_query);
        $fetch = mysqli_fetch_assoc($query);

        // 3. Check if the product actually exists before proceeding
        if ($fetch) {
            $pdt_name = $fetch['pdt_name'];
            $img_name = $fetch['pdt_img'];

            // 4. Delete the record from the database
            $del_query = "DELETE FROM `products` WHERE pdt_id=$id";
            if (mysqli_query($this->connection, $del_query)) {
                
                // 5. Only try to unlink if the image name is not empty
                if (!empty($img_name)) {
                    $file_path = 'uploads/' . $img_name;
                    
                    // 6. Ensure the path is a file and not just the directory
                    if (is_file($file_path)) {
                        unlink($file_path);
                    }
                }
                return "{$pdt_name} deleted successfully";
            }
        } else {
            return "Error: Product not found.";
        }
    }

    function published_product($id)
    {
        $query = "UPDATE `products` SET `pdt_status`='1' WHERE pdt_id=$id";
        if (mysqli_query($this->connection, $query)) {
            
            return "Published Successfully";
            
        }
    }

    function unpublished_product($id)
    {
        $query = "UPDATE `products` SET `pdt_status`='0' WHERE pdt_id=$id";
        if (mysqli_query($this->connection, $query)) {
            
            return "Unpublished Successfully";
            
        }
    }

    function edit_product($id)
    {
        $query = "SELECT * FROM `products` WHERE pdt_id=$id";
        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }

    function update_product($data)
{
    // 1. Sanitize and assign variables
    $pdt_id = intval($data['pdt_id']);
    $pdt_name = mysqli_real_escape_string($this->connection, trim($data['u_pdt_name']));
    $pdt_price = $data['u_pdt_price'];
    $pdt_des = mysqli_real_escape_string($this->connection, $data['u_pdt_des']);
    $pdt_ctg = intval($data['u_pdt_ctg']);
    $pdt_stock = intval($data['pdt_stock']);
    $pdt_status = intval($data['u_pdt_status']);
    
    $pdt_img_name = $_FILES['u_pdt_img']['name'];

    // SCENARIO A: User uploaded a NEW image
    if (!empty($pdt_img_name)) {
        $pdt_img_tmp = $_FILES['u_pdt_img']['tmp_name'];
        $pdt_img_size = $_FILES['u_pdt_img']['size'];
        $img_ext = strtolower(pathinfo($pdt_img_name, PATHINFO_EXTENSION));

        // Get image dimensions safely
        list($width, $height) = getimagesize($pdt_img_tmp);

        if (in_array($img_ext, ["jpg", "jpeg", "png"])) {
            if ($pdt_img_size <= 2000000) {
                if ($width < 271 && $height < 271) {
                    
                    // Delete old image from folder
                    $res = mysqli_query($this->connection, "SELECT pdt_img FROM products WHERE pdt_id=$pdt_id");
                    $row = mysqli_fetch_assoc($res);
                    if ($row && file_exists("uploads/" . $row['pdt_img'])) {
                        unlink("uploads/" . $row['pdt_img']);
                    }

                    // Update query INCLUDING new image (Notice: no space before $pdt_name)
                    $query = "UPDATE `products` SET 
                              `pdt_name`='$pdt_name', 
                              `pdt_price`='$pdt_price', 
                              `pdt_des`='$pdt_des', 
                              `pdt_ctg`=$pdt_ctg, 
                              `pdt_img`='$pdt_img_name', 
                              `product_stock`=$pdt_stock, 
                              `pdt_status`=$pdt_status 
                              WHERE pdt_id=$pdt_id";

                    if (mysqli_query($this->connection, $query)) {
                        move_uploaded_file($pdt_img_tmp, "uploads/" . $pdt_img_name);
                        return "Product and Image Updated Successfully";
                    }
                } else {
                    return "Image too large ({$width}x{$height}). Max 270x270px allowed.";
                }
            } else {
                return "File size exceeds 2MB.";
            }
        } else {
            return "Invalid file format. Use JPG or PNG.";
        }
    } 
    // SCENARIO B: No new image (Just update text)
    else {
        // Update query EXCLUDING image (Notice: no space before $pdt_name)
        $query = "UPDATE `products` SET 
                  `pdt_name`='$pdt_name', 
                  `pdt_price`='$pdt_price', 
                  `pdt_des`='$pdt_des', 
                  `pdt_ctg`=$pdt_ctg, 
                  `product_stock`=$pdt_stock, 
                  `pdt_status`=$pdt_status 
                  WHERE pdt_id=$pdt_id";

        if (mysqli_query($this->connection, $query)) {
            return "Product Updated Successfully (Old image kept)";
        } else {
            return "Error updating database.";
        }
    }
}

    function display_product_byCata($cataId)
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE ctg_id=$cataId AND pdt_status=1 AND `product_stock`>0";
        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }

    function display_product_byId($pdtId)
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE pdt_id=$pdtId";
        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }

    function related_product($cataID)
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE ctg_id=$cataID ORDER BY pdt_id DESC LIMIT 6";
        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }

    function ctg_by_id($cataID)
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE ctg_id=$cataID";
        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            $pdt_fetch = mysqli_fetch_assoc($pdt_info);
            return $pdt_fetch;
        }
    }

    function user_register($data)
{
    $username = $data['username'];
    $user_firstname = $data['user_firstname'];
    $user_lastname = $data['user_lastname'];
    $user_email = $data['user_email'];
    $user_password = md5($data['user_password']);
    $user_mobile = $data['user_mobile'];
    $user_address = $data['user_address'];
    $user_roles = $data['user_roles'];
    
    // 1. Create a unique verification token
    $v_token = bin2hex(random_bytes(16));

    $user_check = "SELECT * FROM `users` WHERE user_name='$username' or user_email='$user_email'";
    $mysqli_result = mysqli_query($this->connection, $user_check);
    $row = mysqli_num_rows($mysqli_result);

    if ($row >= 1) {
        return "Username or email already exist";
    } else {
        // 2. Insert with v_token and v_status (set to 0)
        $query = "INSERT INTO `users`( `user_name`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_mobile`,`user_address`, `user_roles`, `v_token`, `v_status`) 
                  VALUES ('$username','$user_firstname','$user_lastname','$user_email','$user_password','$user_mobile','$user_address',$user_roles, '$v_token', 0)";

        if (mysqli_query($this->connection, $query)) {
            // 3. Send the Verification Email
            $this->send_verification_email($user_email, $v_token, $user_firstname);
            return "Registration successful! Please check your email to verify your account.";
        }
    }
}

    function user_login($data)
{
    $user_email = $data['user_email']; 
    $user_password = md5($data['user_password']);

    $query = "SELECT * FROM `users` WHERE `user_email`='$user_email' AND `user_password`='$user_password'";

    $result = mysqli_query($this->connection, $query);
    $user_info = mysqli_fetch_array($result);

    if ($user_info) {
        // --- START OF VERIFICATION CHECK ---
        if ($user_info['v_status'] == 0) {
            // Updated return message with a link to the resend page
            return "Your email is not verified. <a href='resend_verification.php' style='color: #ffcc00; font-weight: bold; text-decoration: underline;'>Click here to resend the link.</a>";
        }
        // --- END OF VERIFICATION CHECK ---

        // If verified, proceed with session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user_id'] = $user_info['user_id'];
        $_SESSION['email'] = $user_info['user_email'];
        $_SESSION['mobile'] = $user_info['user_mobile'];
        $_SESSION['address'] = $user_info['user_address'];
        $_SESSION['username'] = $user_info['user_name'];
        
        header("location:userprofile.php");
        exit(); 
        
    } else {
        $logmsg = "Your username or password is incorrect";
        return $logmsg;
    }
}

    function user_logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);

        header("location:user_login.php");
        session_destroy();
    }

    function view_all_product()
{
    // Added "AND pdt_status = 1" to hide unpublished products from the public
    $query = "SELECT * FROM `product_info_ctg` WHERE `product_stock` > 0 AND `pdt_status` = 1";

    if (mysqli_query($this->connection, $query)) {
        $pdt_info = mysqli_query($this->connection, $query);
        return $pdt_info;
    }
}

    function display_five_catagory()
    {
        $query = "SELECT * FROM `catagory` LIMIT 5";
        if (mysqli_query($this->connection, $query)) {
            $catagories = mysqli_query($this->connection, $query);
            return $catagories;
        }
    }

   function display_five_products($ctg_id) {
    $query = "SELECT * FROM `product_info_ctg` WHERE `ctg_id`=$ctg_id LIMIT 8";
    $result = mysqli_query($this->connection, $query);
    return $result;
}

    function display_top_rated_pdt()
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE `pdt_price`>200  ORDER BY `pdt_price` LIMIT 12";

        if (mysqli_query($this->connection, $query)) {
            $top_rated = mysqli_query($this->connection, $query);
            return $top_rated;
        }
    }

    function search_product($keyword)
    {
        $query = "SELECT * FROM `product_info_ctg` WHERE `pdt_name` LIKE '%$keyword%'";

        if (mysqli_query($this->connection, $query)) {
            $search_query = mysqli_query($this->connection, $query);
            return $search_query;
        }
    }

    function place_order($data)
    {
        $user_id = $data['user_id'];
        $product_name = $data['product_name'];
        $product_item = $data['product_item'];
        $quantity = $data['quan'];
        $amount = $data['amount'];
        $order_status = $data['order_status'];
        $trans_id = $data['txid'];
        $mobile = $data['shipping_Mobile'];

        $shiping = $data['shiping'];


        $query = "INSERT INTO `order_details`(`user_id`, `product_name`, `product_item`, `amount`, `order_status`, `trans_id`,`Shipping_mobile`, `shiping`, `order_time`, `order_date`) VALUES ( $user_id,'$product_name',$product_item, $amount, $order_status,'$trans_id',$mobile,'$shiping',NOW(), CURDATE())";

        if (mysqli_query($this->connection, $query)) {

            unset($_SESSION['cart']);
            header("location:exist_order.php");
        }
    }

    function confirm_order($post, $session){
        $user_id = $post['user_id'];
        $order_status = $post['order_status'];
        $trans_id = $post['txid'];
        $mobile = $post['shipping_Mobile'];
        $shiping = $post['shiping'];
        $coupon = $_POST['coupon'];

        foreach($session as $key){
            $pdt_name = $key['pdt_name'];
            $pdt_price= $key['pdt_price'];
            $pdt_id= $key['pdt_id'];
            $pdt_quantity=$key['quantity'];

           $query= "INSERT INTO `order_details`(`user_id`, `product_name`,`pdt_quantity`, `amount`,`uses_coupon`, `order_status`, `trans_id`, `Shipping_mobile`, `shiping`, `order_time`) VALUES ($user_id,'$pdt_name',$pdt_quantity, $pdt_price,'$coupon', $order_status,'$trans_id','$mobile','$shiping',NOW())";
           $result= mysqli_query($this->connection, $query);
           unset($_SESSION['cart']);
            header("location:exist_order.php");
           

        }

    }

    function order_details_by_id($user_id)
    {
        $query = "SELECT * FROM `order_details` WHERE `user_id`=$user_id ORDER BY `order_time` DESC";
        if (mysqli_query($this->connection, $query)) {
            $order_query = mysqli_query($this->connection, $query);
            return $order_query;
        }
    }

    function all_order_info()
    {
        $query = "SELECT * FROM `all_order_info` ORDER BY `order_time` DESC";

        if (mysqli_query($this->connection, $query)) {
            $all_order_info = mysqli_query($this->connection, $query);
            return $all_order_info;
        }
    }

  function updat_order_status($data)
{
    $u_pdt_id = intval($data['order_id']);
    $u_pdt_status = $data['update_status'];

    // 1. Validation: Ensure it's not the "Select" placeholder
    if ($u_pdt_status === "Select" || $u_pdt_status === "") {
        return "❌ Error: Please select a valid order status.";
    }

    $u_pdt_status = intval($u_pdt_status);

    // 2. Security: Ensure the status is within the allowed range (0-3)
    $allowed_statuses = [0, 1, 2, 3];
    if (!in_array($u_pdt_status, $allowed_statuses)) {
        return "❌ Error: Invalid status code detected.";
    }

    // 3. Execution: Update the database
    $query = "UPDATE `order_details` SET `order_status` = $u_pdt_status WHERE `order_id` = $u_pdt_id";
    
    if (mysqli_query($this->connection, $query)) {
        // Check if a row was actually changed
        if (mysqli_affected_rows($this->connection) > 0) {
            return "✅ Order Status updated successfully!";
        } else {
            return "ℹ️ No changes made (Status was already set to this value).";
        }
    } else {
        return "❌ SQL Error: " . mysqli_error($this->connection);
    }
}

    function user_password_recover($recover_email)
    {
        $query = "SELECT * FROM `users` WHERE `user_email`='$recover_email'";
        if (mysqli_query($this->connection, $query)) {
            $row =  mysqli_query($this->connection, $query);
            return $row;
        }
    }

    function update_user_password($data)
    {

        $update_id = $data['update_user_id'];
        $update_password = md5($data['update_user_password']);

        // echo $update_id.$update_password;

        $query = "UPDATE `users` SET `user_password`='$update_password' WHERE `user_id`=$update_id";


        if (mysqli_query($this->connection, $query)) {
            $update_mag = "You password updated successfull";
            return $update_mag;
        } else {
            return "Please enter a correct email";
        }
    }


    function display_links()
    {
        $query = "SELECT * FROM header_info";

        if (mysqli_query($this->connection, $query)) {
            $ctg_info = mysqli_query($this->connection, $query);
            return $ctg_info;
        }
    }

    function display_link_ID($id)
    {
        $query = "SELECT * FROM header_info WHERE id = $id";

        if (mysqli_query($this->connection, $query)) {
            $cata_info = mysqli_query($this->connection, $query);
            return mysqli_fetch_assoc($cata_info);
        }
    }

 

    function updata_links($data)
    {
        $link_id = $data['id'];
        $link_email = $data['email'];
        $link_tweeter = $data['tweeter'];
        $link_fb = $data['fb'];
        $link_pin = $data['pin'];
        $link_phone = $data['phone'];


        $query = "UPDATE header_info SET email='$link_email',tweeter='$link_tweeter',fb_link= '$link_fb', pinterest='$link_pin', phone='$link_phone' WHERE id = $link_id";
        if (mysqli_query($this->connection, $query)) {
            return "Link Update successfully";
        }
    }

    function display_logo()
    {
        $query = "SELECT * FROM add_logo";

        if (mysqli_query($this->connection, $query)) {
            $pdt_info = mysqli_query($this->connection, $query);
            return $pdt_info;
        }
    }



    function display_logo_ID($id)
    {
        $query = "SELECT * FROM add_logo WHERE id = $id";

        if (mysqli_query($this->connection, $query)) {
            $cata_info = mysqli_query($this->connection, $query);
            return mysqli_fetch_assoc($cata_info);
        }
    }

    function update_logo($data){
        $lg_id = $data['id'];

        $lg_name = $_FILES['img']['name'];
        $lg_size = $_FILES['img']['size'];
        $lg_tmp = $_FILES['img']['tmp_name'];
        $lg_ext = pathinfo($lg_name, PATHINFO_EXTENSION);

        list($width, $height) = getimagesize("$lg_tmp");


        if ($lg_ext == "jpg" ||   $lg_ext == 'jpeg' ||  $lg_ext == "png") {
            if ($lg_size <= 2e+6) {

                if ($width < 136 && $height < 37) {

                    $select_query = "SELECT * FROM `add_logo` WHERE id=$lg_id";
                    $result = mysqli_query($this->connection, $select_query);
                    $row = mysqli_fetch_assoc($result);
                    $pre_img = $row['img'];
                    unlink("uploads/".$pre_img);


                    $query = "UPDATE add_logo SET img='$lg_name' WHERE id=$lg_id";

                    if (mysqli_query($this->connection, $query)) {
                        move_uploaded_file($lg_tmp, "uploads/" . $lg_name);
                        $msg = "Logo  Updated successfully";
                        return $msg;
                    }
                }else{
                    $msg = "Sorry !! Logo max height: 135px and width:36px, but you are trying {$width} px and {$height} px";
                    return $msg;
                }
            } else {
                $msg = "File size should not be large 2MB";
                return $msg;
            }
        } else {
            $msg = "File shoul be jpg or png formate";
            return $msg;
        }
    }

    function SlideShow(){
        $query = "SELECT * FROM `slider`";
        if(mysqli_query($this->connection, $query)){
            $row = mysqli_query($this->connection, $query);
            return $row;
        }
    }

    
    function slide_By_id($id){
        $query = "SELECT * FROM `slider` WHERE `slider_id`=$id";
        if(mysqli_query($this->connection, $query)){
            $row = mysqli_query($this->connection, $query);
            return $row;
        }
    }

    function slider_update($data){
    $slide_id = $data['slider_id'];
    $first_line = $data['first_line'];
    $second_line = $data['second_line'];
    $third_line = $data['third_line'];
    $btn_left = $data['btn_left'];
    $btn_right = $data['btn_right'];

    // Check if a new image is uploaded
    if(isset($_FILES['slider_img']) && !empty($_FILES['slider_img']['name'])){
        $lg_name = $_FILES['slider_img']['name'];
        $lg_size = $_FILES['slider_img']['size'];
        $lg_tmp = $_FILES['slider_img']['tmp_name'];
        $lg_ext = pathinfo($lg_name, PATHINFO_EXTENSION);

        list($width, $height) = getimagesize($lg_tmp);

        if(in_array(strtolower($lg_ext), ['jpg','jpeg','png'])){
            if($lg_size <= 2e+6){
                if($width == 1920 && $height == 550){

                    // Get previous slider image
                    $select_query = "SELECT * FROM `slider` WHERE `slider_id`=$slide_id";
                    $result = mysqli_query($this->connection, $select_query);
                    $row = mysqli_fetch_assoc($result);
                    $pre_img = $row['slider_img'];
                    $img_path = "uploads/" . $pre_img;

                    // Only unlink if file exists
                    if(!empty($pre_img) && is_file($img_path)){
                        unlink($img_path);
                    }

                    // Update slider record with new image
                    $query = "UPDATE `slider` SET 
                        `first_line`='$first_line',
                        `second_line`='$second_line',
                        `third_line`='$third_line',
                        `btn_left`='$btn_left',
                        `btn_right`='$btn_right',
                        `slider_img`='$lg_name'
                        WHERE `slider_id`=$slide_id";

                    if(mysqli_query($this->connection, $query)){
                        move_uploaded_file($lg_tmp, "uploads/" . $lg_name);
                        return "Slider updated successfully with new image";
                    }

                } else {
                    return "Slider image must be 1920x550px. You tried {$width}x{$height}px";
                }
            } else {
                return "File size should not exceed 2MB";
            }
        } else {
            return "File must be jpg or png format";
        }
    } else {
        // No new image uploaded, just update text/buttons
        $query = "UPDATE `slider` SET 
            `first_line`='$first_line',
            `second_line`='$second_line',
            `third_line`='$third_line',
            `btn_left`='$btn_left',
            `btn_right`='$btn_right'
            WHERE `slider_id`=$slide_id";

        if(mysqli_query($this->connection, $query)){
            return "Slider updated successfully (without changing image)";
        }
    }
}



    public function post_comment($data){
    $user_id = $data['user_id'];
    $user_name = $data['user_name'];
    $pdt_id = $data['pdt_id'];
    $comment = $data['comment'];
    // Catch the new field here
    $ai_status = isset($data['ai_status']) ? $data['ai_status'] : 0; 
    $date = date('Y-m-d');

    // Add 'ai_status' to your INSERT query
    $query = "INSERT INTO customer_feedback (user_id, user_name, pdt_id, comment, ai_status, comment_date) 
              VALUES ('$user_id', '$user_name', '$pdt_id', '$comment', '$ai_status', '$date')";
    
    if(mysqli_query($this->connection, $query)){
        return "Comment posted!";
    }
}

    // Fetch comments for a specific product (User Side)
    function view_comment_id($id){
        $pdt_id = intval($id); // Security: ensure ID is a number
        $query = "SELECT * FROM `customer_feedback` WHERE `pdt_id` = $pdt_id ORDER BY id DESC";
        
        $result = mysqli_query($this->connection, $query);
        if($result && mysqli_num_rows($result) > 0){
            return $result;
        }
        return false;
    }

    // Fetch all comments (Admin Side)
    function view_comment_all(){
        // ORDER BY id DESC makes sure the newest comments appear at the top
        $query = "SELECT * FROM `customer_feedback` ORDER BY id DESC";
        
        $result = mysqli_query($this->connection, $query);
        if($result){
            return $result;
        }
        return false;
    }
    function edit_comment($cmt_id){
        $query = "SELECT * FROM `customer_feedback` WHERE `id` = $cmt_id";

        if(mysqli_query($this->connection, $query)){
            $array = mysqli_query($this->connection, $query);
            return $array;
        }
    }
    function update_comment($data){
        $cmt_id = $data['cmt_id'];
        $comment = $data['u_comment'];
        $query = "UPDATE `customer_feedback` SET `comment`='$comment' WHERE `id`=$cmt_id";
        if(mysqli_query($this->connection, $query)){
            $updata_msg = "Comment updated successfully";
            return $updata_msg;
        }
    }

    function delete_comment($cmt_id){
        $query = "DELETE FROM `customer_feedback` WHERE `id`=$cmt_id";

        if(mysqli_query($this->connection, $query)){
            $del_msg = "Comment deleted successfully";
            return $del_msg;
        }
    }

    function add_coupon($data){
        $coupon_code = $data['cuopon_code'];
        $coupon_description = $data['cuopon_description'];
        $coupon_discount = $data['cuopon_discount'];
        $coupon_status = $data['cuopon_status'];


        $query = "INSERT INTO `cupon`( `cupon_code`, `description`, `discount`, `status`) VALUES ('$coupon_code','$coupon_description',$coupon_discount,$coupon_status)";

        if(mysqli_query($this->connection, $query)){

            
            $add_msg = "Coupon added successfully";
            return $add_msg;
        }
    }

    function show_coupon(){
        $query = "SELECT * FROM `cupon`";
        if(mysqli_query($this->connection, $query)){
            $result = mysqli_query($this->connection, $query);
            return $result;
        }
    }
    // Add this at the bottom of the adminback class, before the last closing brace }
   public function display_all_product_smoothie()
{
    // Selecting from the 'products' table as seen in your screenshot
    $query = "SELECT * FROM `products` WHERE pdt_status=1 AND `product_stock` > 0";

    $pdt_info = mysqli_query($this->connection, $query);
    if ($pdt_info) {
        return $pdt_info;
    }
}

    #new added for coupon delete and edit




    function delete_coupon($id) {
    $id = intval($id); // sanitize input
    $query = "DELETE FROM `cupon` WHERE `cupon_id` = $id";
    if(mysqli_query($this->connection, $query)) {
        return "Coupon deleted successfully";
    } else {
        return "Failed to delete coupon";
    }
}




// Get single coupon by ID (for editing)
function get_coupon($id) {
    $id = intval($id);
    $query = "SELECT * FROM `cupon` WHERE `cupon_id` = $id";
    if(mysqli_query($this->connection, $query)) {
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }
}

// Update coupon
function update_coupon($data) {
    $id = intval($data['cupon_id']);
    $code = $this->connection->real_escape_string($data['cupon_code']);
    $desc = $this->connection->real_escape_string($data['cupon_description']);
    $discount = floatval($data['cupon_discount']);
    $status = intval($data['cupon_status']);

    $query = "UPDATE `cupon` SET `cupon_code`='$code', `description`='$desc', `discount`=$discount, `status`=$status WHERE `cupon_id`=$id";

    if(mysqli_query($this->connection, $query)) {
        return "Coupon updated successfully";
    } else {
        return "Failed to update coupon";
    }
}

public function get_db_conn() {
        return $this->connection;
    }


   private function send_verification_email($email, $token, $name) {
    // Corrected for Composer Namespace
    $mail = new PHPMailer(true); 

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = ''; // This App Password looks correct
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Cleaner way to write 'tls'
        $mail->Port       = 587;

        $mail->setFrom('@gmail.com', 'Fruid');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - Fruid';
        
        $base_url = "http://localhost/fruid/"; 
        // Using urlencode for the email is safer
        $verify_link = $base_url . "verify.php?email=" . urlencode($email) . "&token=" . $token;

        $mail->Body = "<h3>Hello $name,</h3>
                       <p>Thank you for registering. Please click the button below to verify your email address within 2-minutes:</p>
                       <a href='$verify_link' style='background:green; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; display:inline-block;'>Verify Email</a>
                       <br><br>
                       <p>If the button doesn't work, copy and paste this link: <br> $verify_link </p>";

        $mail->send();
    } catch (Exception $e) {
        // If it fails, you can see why by uncommenting the line below:
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}



function resend_verification_link($data) {
    $email = mysqli_real_escape_string($this->connection, $data['user_email']);
    
    $check_user = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";
    $result = mysqli_query($this->connection, $check_user);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['v_status'] == 1) {
            return "This account is already verified. Please login.";
        } else {
            $new_token = bin2hex(random_bytes(16));
            // Note: v_created_at is updated so the 2-minute timer starts over
            $update_query = "UPDATE users SET v_token = '$new_token', v_created_at = NOW() WHERE user_email = '$email'";
            
            if (mysqli_query($this->connection, $update_query)) {
                $this->send_verification_email($email, $new_token, $user['user_firstname']);
                return "A new 2-minute link has been sent to your email.";
            }
        }
    } else {
        return "No account found with that email address.";
    }
}

// Inside your AdminFunction class (e.g., in AdminFunction.php)
public function check_cyberbullying($text) {
    $url = 'http://127.0.0.1:5001/check'; // Your Python IDE address
    $data = json_encode(['comment' => $text]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    if ($response === false) { return 0; } // If Python is off, show as safe

    $result = json_decode($response, true);
    curl_close($ch);

    return $result['is_bully']; // Returns 1 (Bully) or 0 (Safe)
}





public function get_comment_info_by_id($id){
    $query = "SELECT * FROM customer_feedback WHERE id = $id";
    if(mysqli_query($this->connection, $query)){
        $info = mysqli_query($this->connection, $query);
        return $info;
    }
}


public function send_chat_message($data) {
        $sender_id = mysqli_real_escape_string($this->connection, $data['sender_id']);
        $receiver_id = mysqli_real_escape_string($this->connection, $data['receiver_id']);
        $message = mysqli_real_escape_string($this->connection, $data['message']);

        // Call the AI function we just created
        $is_bullying = $this->check_cyberbullying($message);

        // Insert into your 'chat_messages' table
        $query = "INSERT INTO `chat_messages` (`sender_id`, `receiver_id`, `message`, `is_bullying`, `created_at`) 
                  VALUES ('$sender_id', '$receiver_id', '$message', '$is_bullying', NOW())";

        if (mysqli_query($this->connection, $query)) {
            return "Message Sent";
        }
    }


}
