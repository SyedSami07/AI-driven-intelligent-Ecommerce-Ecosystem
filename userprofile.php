<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$cata_info = $obj->p_display_catagory();
$cataDatas = array();
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

$userid = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (empty($userid)) {
    header("location:user_login.php");
    exit();
}

// --- DYNAMIC REMOVE LOGIC (FIXES THE 404 ERROR) ---
if (isset($_GET['remove_pdt'])) {
    $remove_id = $_GET['remove_pdt'];
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['pdt_id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            
            // Redirects back to "this" file automatically
            $current_file = basename($_SERVER['PHP_SELF']);
            header("location: $current_file"); 
            exit();
        }
    }
}

if(empty($_SESSION['cart'])){
    header("location:exist_order.php");
    exit();
}

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "logout") {
        $obj->user_logout();
    }
}

if (isset($_POST['confirm_order'])) {
    $order_msg = $obj->confirm_order($_POST, $_SESSION['cart']);
}

include_once("includes/head.php");
?>

<style>
    /* FIX VISIBILITY */
    .delivery-box .nice-select .current, 
    .delivery-box select,
    .delivery-box .list .option {
        color: #000 !important;
    }

    .delivery-box .nice-select {
        width: 100% !important;
        border: 1px solid #ccc !important;
        float: none !important;
    }

    /* PAYMENT HIGHLIGHT */
    .bkash-notice {
        background: #fdf2f2;
        border-left: 4px solid #d12053;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    .bkash-number {
        color: #d12053;
        font-weight: 700;
        font-size: 1.2em;
    }

    /* PRODUCT PHOTO STYLING */
    .cart-pdt-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #eee;
        margin-right: 10px;
    }
    .pdt-column {
        display: flex;
        align-items: center;
    }
    .non-clickable {
        pointer-events: none;
        cursor: default;
        color: #333 !important;
        text-decoration: none !important;
    }
</style>

<body class="biolife-body">
    <?php include_once("includes/preloader.php"); ?>

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <div class="page-contain">
        <div id="main-content" class="main-content">
            <div class="container">
                <form action="" method="POST"> 
                <div class="row">
                    <div class="col-md-2">
                        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                            <h4 style="font-size: 16px;">Hello, <br><strong><?php if (isset($username)) { echo strtoupper($username); } ?></strong></h4>
                            <hr>
                            <a href="?logout=logout" class="btn btn-xs btn-danger">Logout</a>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <h2 class="text-center text-dark" style="margin-bottom: 20px;">Cart Summary</h2>

                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                            <table class="shop_table cart-form">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-name">Price</th>
                                        <th class="product-price">Quantity</th>
                                        <th class="product-quantity">Action</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $_SESSION['subtotal'] = 0;
                                    $_SESSION['cart_pdt_number'] = 0;
                                    $order_names = '';
                                    foreach ($_SESSION['cart'] as $key => $value) {
                                        $_SESSION['subtotal'] += $value['pdt_price'];
                                        $_SESSION['cart_pdt_number']++;
                                        $order_names = $value['pdt_name'] . "<br> " . $order_names;
                                    ?>
                                        <tr class="cart_item">
                                            <td class="product-thumbnail">
                                                <div class="pdt-column">
                                                    <img src="admin/uploads/<?php echo $value['pdt_img']; ?>" class="cart-pdt-img" alt="Product">
                                                    <span class="non-clickable"><?php echo $value['pdt_name']; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="price-amount"><?php echo $value['pdt_price'] ?></span>
                                                <input type="hidden" class="pdt_price" value="<?php echo $value['pdt_price'] ?>">
                                            </td>
                                            <td>
                                                <input type="number" value="1" name="quantity" class="quantity" style="width: 60px;" min="1" max="10" onchange="subtotal(), totalOfAll()">
                                            </td>
                                            <td>
                                                <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?remove_pdt=<?php echo $value['pdt_id']; ?>" 
                                                   class="btn btn-warning btn-sm" 
                                                   onclick="return confirm('Remove this item from cart?')">
                                                   Remove
                                                </a>
                                            </td>
                                            <td>
                                                <span class="subtotal price-amount"><?php echo $value['pdt_price'] ?></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="delivery-box" style="margin-top: 30px; max-width: 400px; padding: 15px; background: #fff; border: 1px solid #ddd;">
                                <label style="font-weight: bold; color: #333; display: block; margin-bottom: 10px;">Select Delivery Area:</label>
                                <select name="delivery_charge" id="delivery_charge" class="form-control" required onchange="totalOfAll()">
                                    <option value="" selected disabled>-- Choose Location --</option>
                                    <option value="60">Inside Sylhet City (60 TK)</option>
                                    <option value="120">Outside Sylhet (120 TK)</option>
                                </select>
                                <small style="display:block; margin-top: 8px; color: #e74c3c;">* Total price updates automatically.</small>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="shpcart-subtotal-block" style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                            <div class="subtotal-line">
                                <b class="stt-name">Total (<?php echo $_SESSION['cart_pdt_number'] ?> Items)</b>
                                <span class="stt-price" id="totalOfall"><?php echo $_SESSION['subtotal'] ?></span>
                            </div>

                            <div class="subtotal-line">
                                <p class="stt-name">Coupon</p>
                                <input type="text" name="coupon" id="cupon" class="form-control" style="width:40%; display:inline; height: 30px; padding: 5px;">
                                <span class="stt-price" id="discount">0</span>
                            </div>

                            <div class="subtotal-line">
                                <p class="stt-name">Shipping</p>
                                <span class="stt-price" id="shipping_val">0</span>
                            </div>

                            <hr style="border-top:1px solid #ccc">

                            <div class="subtotal-line">
                                <b class="stt-name" style="font-size: 18px;">Total Payable</b>
                                <span class="stt-price" id="afterdiscount" style="font-size: 18px; color: #7faf51;"><?php echo $_SESSION['subtotal'] ?></span>
                            </div>

                            <div class="bkash-notice" style="margin-top: 25px;">
                                <p style="margin: 0; font-size: 13px; color: #555;">Send Money to bKash (Personal):</p>
                                <span class="bkash-number">01303968132</span>
                            </div>

                            <div style="margin-top: 15px;">
                                <b class="stt-name">Payment TXID</b>
                                <input type="text" style="width:100%;" class="form-control" placeholder="Enter bKash TXID" name="txid" required>
                            </div>

                            <div style="margin-top: 20px;">
                                <b class="stt-name">Mobile</b>
                                <input type="text" name="shipping_Mobile" class="form-control" value="<?php echo $_SESSION['mobile'] ?>" required>
                            </div>

                            <div style="margin-top: 20px;">
                                <b class="stt-name">Shipping Address</b>
                                <textarea name="shiping" class="form-control" required><?php echo $_SESSION['address'] ?></textarea>
                            </div>

                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                            <input type="hidden" name="product_name" value="<?php echo $order_names ?>">
                            <input type="hidden" name="product_item" value="<?php echo $_SESSION['cart_pdt_number'] ?>">
                            <input type="hidden" name="amount" id="amount_input" value="<?php echo $_SESSION['subtotal'] ?>">
                            <input type="hidden" name="order_status" value="0">

                            <div class="btn-checkout" style="margin-top: 20px;">
                                <input type="submit" class="btn btn-success btn-block btn-lg" value="Confirm Order" name="confirm_order" style="border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function subtotal() {
            var item_price = document.getElementsByClassName("pdt_price");
            var item_quantity = document.getElementsByClassName("quantity");
            var item_total = document.getElementsByClassName("subtotal");
            for (let i = 0; i < item_price.length; i++) {
                item_total[i].innerText = item_price[i].value * item_quantity[i].value;
            }
        }

        function totalOfAll() {
            var item_total = document.getElementsByClassName("subtotal");
            let total = 0;
            for (let i = 0; i < item_total.length; i++) {
                total += parseInt(item_total[i].innerText);
            }
            document.getElementById("totalOfall").innerText = total;

            var shipping = parseInt(document.getElementById("delivery_charge").value) || 0;
            document.getElementById("shipping_val").innerText = shipping;

            var disc = parseInt(document.getElementById("discount").innerText) || 0;
            var finalTotal = (total + shipping) - disc;
            document.getElementById("afterdiscount").innerText = finalTotal;
            document.getElementById("amount_input").value = finalTotal;
        }

        $(document).ready(function() {
            $("#cupon").on("keyup blur", function() {
                $.ajax({
                    url: "json/coupon.php",
                    method: "POST",
                    data: { action: 'load_discount', cupon: $(this).val(), price: $("#totalOfall").text() },
                    success: function(data) {
                        $("#discount").text(Math.round(data));
                        totalOfAll();
                    }
                });
            });
        });
    </script>

    <?php 
    include_once("includes/footer.php");
    include_once("includes/mobile_footer.php");
    include_once("includes/script.php"); 
    ?>
</body>
</html>