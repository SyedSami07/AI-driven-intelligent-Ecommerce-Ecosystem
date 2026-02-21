<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$cata_info = $obj->p_display_catagory();
$cataDatas = array();
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

// --- FIXED: SMOOTHIE BUNDLE LOGIC ---
// এই অংশটি নিশ্চিত করবে যে ৫টি আইটেমই যোগ হচ্ছে, ডুপ্লিকেট নাম থাকলেও স্কিপ করবে না
if (isset($_POST['add_smoothie_bundle'])) {
    $ids = explode(',', $_POST['smoothie_ids']); 
    
    if (!isset($_SESSION['cart'])) { 
        $_SESSION['cart'] = array(); 
    }

    foreach ($ids as $id) {
        $id = trim($id);
        if(!empty($id)){
            $pdt_info = $obj->display_product_byId($id); 
            if($pdt_info){
                $pdt_fetch = mysqli_fetch_assoc($pdt_info);
                if ($pdt_fetch) {
                    // স্মুদি বান্ডেলের জন্য সরাসরি ডাটা পুশ করা হচ্ছে
                    $_SESSION['cart'][] = array(
                        'pdt_name' => $pdt_fetch['pdt_name'],
                        'pdt_price' => $pdt_fetch['pdt_price'],
                        'pdt_img' => $pdt_fetch['pdt_img'],
                        'pdt_id' => $pdt_fetch['pdt_id'],
                        'quantity' => 1
                    );
                }
            }
        }
    }
}

// --- ORIGINAL: ADD SINGLE TO CART ---
if (isset($_POST['addtocart'])) {
    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    
    $pdt_names = array_column($_SESSION['cart'], "pdt_name");
    if (in_array($_POST['pdt_name'], $pdt_names)) {
        echo "<script>alert('This Item Already added in Cart')</script>";
    } else {
        $_SESSION['cart'][] = array(
            'pdt_name' => $_POST['pdt_name'],
            'pdt_price' => $_POST['pdt_price'],
            'pdt_img' => $_POST['pdt_img'],
            'pdt_id' => $_POST['pdt_id'],
            'quantity' => 1
        );
    }
}

// --- ORIGINAL: REMOVE PRODUCT ---
if (isset($_POST['remove_product'])) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if (isset($value['pdt_name']) && $value['pdt_name'] == $_POST['remove_pdt_name']) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }
}

include_once("includes/head.php");
?>

<body class="biolife-body">
    <?php include_once("includes/preloader.php"); ?>

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <div class="page-contain">
        <div id="main-content" class="main-content">
            <br>
            <div class="container">
                <div class="shopping-cart-container">
                    <div class="row">
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="box-title">Your cart items</h3>
                            <div class="shopping-cart-form">
                                <table class="shop_table cart-form">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product Name</th>
                                            <th class="product-price">Price (Tk)</th>
                                            <th class="product-quantity">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subtotal = 0;
                                        $total_product = 0;
                                        $pdt_list = []; 
                                        
                                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                            foreach ($_SESSION['cart'] as $key => $value) {
                                                $subtotal += (float)$value['pdt_price'];
                                                $total_product++;
                                                $pdt_list[] = $value['pdt_name']; 
                                        ?>
                                        <tr class="cart_item">
                                            <td class="product-thumbnail" data-title="Product Name">
                                                <a class="prd-thumb" href="single_product.php?id=<?php echo $value['pdt_id']; ?>">
                                                    <figure><img width="113" height="113" src="admin/uploads/<?php echo $value['pdt_img'] ?? ''; ?>"></figure>
                                                </a>
                                                <a class="prd-name" href="#"><?php echo $value['pdt_name'] ?? 'Unknown'; ?></a>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <div class="price price-contain">
                                                    <ins><span class="price-amount">Tk. <?php echo $value['pdt_price'] ?? 0; ?></span></ins>
                                                </div>
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <form action="" method="POST">
                                                    <input type="hidden" value="<?php echo $value['pdt_name'] ?? ''; ?>" name="remove_pdt_name">
                                                    <input class="btn btn-warning" type="submit" value="Remove Product" name="remove_product">
                                                </form>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' style='padding:20px; text-align:center;'>Your cart is empty</td></tr>";
                                        } 
                                        ?>
                                    </tbody>
                                </table>

                                <?php if($total_product >= 3): ?>
                                <div class="ai-recipe-box" style="margin-top: 30px; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #f0f9eb 0%, #e1f2d5 100%); border-left: 6px solid #7faf51; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                                    <h4 style="color: #4a7c1a; margin-bottom: 10px;">
                                        <i class="fa fa-magic"></i> AI Smoothie Recipe Generated!
                                    </h4>
                                    <p style="color: #555; font-style: italic;">"Based on your <strong>BMI of 22.2</strong>, we recommend blending these weight-loss friendly fruits: <strong><?php echo implode(', ', array_unique($pdt_list)); ?></strong>. Mix with water or green tea for best results!"</p>
                                    <div style="margin-top: 10px; font-size: 12px; color: #7faf51; font-weight: bold;">
                                        <i class="fa fa-bolt"></i> Total Items in Bundle: <?php echo $total_product; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="shpcart-subtotal-block">
                                <div class="subtotal-line">
                                    <b class="stt-name">Subtotal <span class="sub">(<?php echo $total_product; ?> Items)</span></b>
                                    <span class="stt-price">Tk. <?php echo $subtotal; ?></span>
                                </div>
                                <div class="btn-checkout">
                                    <a href="userprofile.php" class="btn checkout">Check out</a>
                                </div>
                                <p class="pickup-info"><b>Free Pickup</b> is available as soon as today.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>
</html>