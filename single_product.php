<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once("admin/class/adminback.php");
$obj = new adminback();

// 1. Fetch Categories for Navigation
$cata_info = $obj->p_display_catagory();
$cataDatas = [];
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

// 2. Initialize Product Variables
$pro_datas = [];
$ctg_id = 0;
$rel_pro = [];
$cmt_row = 0;

// 3. Check if Product ID is set
if (isset($_GET['status']) && isset($_GET['id'])) {
    $pdtId = intval($_GET['id']); 

    if ($_GET['status'] === 'singleproduct') {
        $pdt_info = $obj->display_product_byId($pdtId);

        if ($pdt_info && mysqli_num_rows($pdt_info) > 0) {
            $pdt_fetch = mysqli_fetch_assoc($pdt_info);
            $pro_datas[] = $pdt_fetch;

            $ctg_id = $pdt_fetch['ctg_id'];
            $rel_pro = $obj->related_product($ctg_id);
        } else {
            echo "<h2 style='text-align:center; margin-top:50px;'>Product not found!</h2>";
            exit;
        }
    }
} else {
    echo "<h2>No product selected!</h2>";
    exit;
}

// 4. HANDLING COMMENT SUBMISSION (AI + REDIRECT TO PREVENT DUPLICATES)
if (isset($_POST['post_comment'])) {
    $user_comment = $_POST['comment'];
    
    // Call AI to check toxicity
    $is_toxic = $obj->check_cyberbullying($user_comment);

    // Save the AI result into the POST data
    $_POST['ai_status'] = $is_toxic; 

    // Save to Database (Even if bully, so Admin can see it)
    $obj->post_comment($_POST);

    // Store status in Session to show message after redirect
    if ($is_toxic == 1) {
        $_SESSION['cmt_feedback'] = "toxic";
    } else {
        $_SESSION['cmt_feedback'] = "success";
    }

    // REDIRECT back to the same page (Stops double posts on refresh)
    header("Location: single_product.php?status=singleproduct&id=" . $pdtId);
    exit(); 
}

// 5. Fetch comments for display
$cmt_fetch = $obj->view_comment_id($pdtId);
if ($cmt_fetch) {
    $cmt_row = mysqli_num_rows($cmt_fetch);
}

include_once("includes/head.php");
?>



<style>
    .product-details-container { padding: 40px 0; background: #fff; }
    .product-main-title { font-size: 32px; font-weight: 700; color: #222; margin-bottom: 10px; }
    .price-box { margin: 20px 0; padding: 15px; background: #f9f9f9; border-radius: 8px; }
    .current-price { font-size: 28px; font-weight: 700; color: #7faf51; }
    .review-section { margin-top: 40px; border-top: 1px solid #eee; padding-top: 40px; padding-bottom: 60px; }
    .review-item { padding: 20px; border-bottom: 1px solid #eee; margin-bottom: 15px; background: #fafafa; border-radius: 8px; }
    .alert { border-left: 5px solid; }
</style>

<body class="biolife-body">
    <?php include_once("includes/preloader.php"); ?>

    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <div class="page-contain product-details-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="product-gallery" style="border: 1px solid #eee; border-radius: 12px; overflow: hidden;">
                        <img src="admin/uploads/<?php echo htmlspecialchars($pdt_fetch['pdt_img']); ?>" alt="" class="img-fluid" style="width: 100%;">
                    </div>
                </div>

                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="product-info-content" style="padding-left: 20px;">
                        <h1 class="product-main-title"><?php echo htmlspecialchars($pdt_fetch['pdt_name']); ?></h1>
                        <div class="rating-stock" style="margin-bottom: 15px;">
                            <span style="color: #f39c12;"><i class="fa fa-star"></i> (<?php echo $cmt_row; ?> Reviews)</span>
                        </div>
                        <p style="color: #666;"><?php echo htmlspecialchars($pdt_fetch['pdt_des']); ?></p>
                        <div class="price-box">
                            <span class="current-price">Tk. <?php echo $pdt_fetch['pdt_price']; ?></span>
                        </div>
                        
                        <form action="addtocart.php" method="POST">
                            <input type="hidden" name="pdt_id" value="<?php echo $pdt_fetch['pdt_id']; ?>">
                            <button type="submit" name="addtocart" class="btn btn-success btn-lg" style="border-radius: 50px;">
                                <i class="fa fa-shopping-basket"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="review-section">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <h3 style="font-weight: 700; margin-bottom: 25px;">Customer Reviews</h3>
                        <ul class="review-list" style="list-style:none; padding:0;">
                            <?php if($cmt_fetch && mysqli_num_rows($cmt_fetch) > 0) {
                                while($cmtinfo = mysqli_fetch_assoc($cmt_fetch)){ 
                                    // Hide bullying comments from the public eye
                                    if(isset($cmtinfo['ai_status']) && $cmtinfo['ai_status'] == 1) continue;
                                ?>
                                    <li class="review-item">
                                        <strong><?php echo htmlspecialchars($cmtinfo['user_name']); ?></strong> 
                                        <small class="text-muted"><?php echo $cmtinfo['comment_date']; ?></small>
                                        <p style="margin-top:10px;"><?php echo htmlspecialchars($cmtinfo['comment']); ?></p>
                                    </li>
                            <?php }} else { echo "<p>No reviews yet.</p>"; } ?>
                        </ul>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <?php if(isset($_SESSION['user_id'])) { ?>
                            <div style="background: #fdfdfd; padding: 30px; border: 1px solid #eee; border-radius: 12px;">
                                <h4 style="font-weight: 700; margin-bottom: 20px;">Leave a Review</h4>
                                
                                <?php 
                                    // SHOW NOTIFICATION FROM SESSION
                                    if(isset($_SESSION['cmt_feedback'])){
                                        if($_SESSION['cmt_feedback'] == "toxic"){
                                            echo "<div class='alert alert-danger shadow-sm'>Your comment has been identified as cyberbullying. It will remain hidden until the admin review</div>";
                                        } else {
                                            echo "<div class='alert alert-success shadow-sm'>Thank you for your review!</div>";
                                        }
                                        unset($_SESSION['cmt_feedback']); // Delete after showing
                                    }
                                ?>

                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="user_name" value="<?php echo $_SESSION['username'] ?? 'Customer'; ?>">
                                    <input type="hidden" name="pdt_id" value="<?php echo $pdtId; ?>">
                                    <textarea name="comment" class="form-control" rows="4" style="margin-bottom: 15px;" placeholder="Leave your opinion.." required></textarea>
                                    <button type="submit" name="post_comment" class="btn btn-dark btn-block">Submit Review</button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <p>Please <a href="login.php" style="color: #7faf51; font-weight: bold;">Login</a> to post a review.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/script.php"); ?>
</body>
</html>