<?php
session_start();
include_once("admin/class/adminback.php");
$obj = new adminback();

// Handle the resend logic
if (isset($_POST['resend_verification_btn'])) {
    $res_msg = $obj->resend_verification_link($_POST);
}

// Redirect if already logged in
if(isset($_SESSION['user_id'])){
    header('location:userprofile.php');
    exit();
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
            <div class="container">
                <h2 class="text-center">Resend Verification Link</h2>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="text-info">
                            <?php if (isset($res_msg)) { echo $res_msg; } ?>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="float:none; margin: 0 auto;">
                        <div class="signin-container">
                            <form action="" method="POST">
                                <p class="form-row">
                                    <label for="user_email">Enter your registered Email:<span class="requite">*</span></label>
                                    <input type="email" name="user_email" class="txt-input form-control" placeholder="example@mail.com" required>
                                </p>

                                <p class="wrap-btn">
                                    <input type="submit" value="Send New Verification Link" name="resend_verification_btn" class="btn btn-block btn-success">
                                </p>
                            </form>
                            
                            <div class="text-center" style="margin-top: 20px;">
                                <a href="user_login.php" class="link-to-help">Back to Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>

    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>
    <?php include_once("includes/script.php"); ?>
</body>
</html>