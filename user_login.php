<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

$cata_info = $obj->p_display_catagory();
$cataDatas = array();
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

// Handle Login
if (isset($_POST['user_login_btn'])){
    $logmsg = $obj->user_login($_POST);
}

// Redirect if already logged in
if(isset($_SESSION['user_id'])){
    header('location:userprofile.php');
    exit();
}
?>

<?php
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
            <div class="container">
                <h2 class="text-center" style="margin-top: 20px;">Log in</h2>

                <div class="msg-container text-center" style="margin-bottom: 20px;">
                    <?php if(isset($logmsg)): ?>
                        <div class="alert alert-danger" style="display: inline-block; padding: 10px 20px;">
                            <?php echo $logmsg; // This will now render the "Resend" link correctly ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="signin-container">
                            <form action="" name="frm-login" method="post">
                                <p class="form-row">
                                    <label for="fid-name">Email</label>
                                    <input type="email" id="fid-name" name="user_email" class="txt-input" required>
                                </p>
                                <p class="form-row">
                                    <label for="user_password">Password:</label>
                                    <input type="password" name="user_password" class="txt-input" required>
                                </p>
                                <p class="wrap-btn">
                                    <input type="submit" value="Log In" name="user_login_btn" class="btn btn-success">
                                    <a href="user_password_recover.php" class="link-to-help">Forgot your password?</a>
                                </p>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="register-in-container">
                            <div class="intro">
                                <h4 class="box-title">New Customer?</h4>
                                <p class="sub-title">Create an account with us and you’ll be able to:</p>
                                <ul class="lis">
                                    <li>Check out faster</li>
                                    <li>Save multiple shipping addresses</li>
                                    <li>Access your order history</li>
                                    <li>Track new orders</li>
                                    <li>Save items to your Wishlist</li>
                                </ul>
                                <a href="user_register.php" class="btn btn-bold">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>

    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>

    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>

    <?php include_once("includes/script.php"); ?>
</body>
</html>