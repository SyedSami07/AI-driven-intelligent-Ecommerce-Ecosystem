<?php
session_start();
require 'vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("admin/class/adminback.php");
$obj = new adminback();

// Fetch categories
$cata_info = $obj->p_display_catagory();
$cataDatas = [];
while ($data = mysqli_fetch_assoc($cata_info)) {
    $cataDatas[] = $data;
}

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("location:userprofile.php");
    exit;
}

// Password recovery logic
$rec_msg = "";

if (isset($_POST['u_pass_recover'])) {
    $recover_email = $_POST['recover_email'];
    $rec_row = $obj->user_password_recover($recover_email);
    $num_row = mysqli_num_rows($rec_row);

    if ($num_row > 0) {
        $rec_result = mysqli_fetch_assoc($rec_row);

        $rec_id = $rec_result['user_id'];
        $rec_name = $rec_result['user_firstname'];
        $rec_email = $rec_result['user_email'];

        // PHPMailer setup
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';      // Your Gmail
            $mail->Password = '';         // Your Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('', 'Fru');
            $mail->addAddress($rec_email, $rec_name);

            $mail->isHTML(true);
            $mail->Subject = 'Recover Password From Fruid';
            $mail->Body = "
                <p>Dear {$rec_name},</p>
                <p>Please click the link below to reset your password:</p>
                <p><a href='http://localhost/fruid/user_password_update.php?status=update&id={$rec_id}'>Reset Password</a></p>
                <p>Thank you!</p>
            ";

            $mail->send();
            $rec_msg = "✅ Please check your email and reset your password!";
        } catch (Exception $e) {
            $rec_msg = "❌ Email sending failed: {$mail->ErrorInfo}";
        }
    } else {
        $rec_msg = "❌ Sorry! No account found with this email.";
    }
}
?>

<?php include_once("includes/head.php"); ?>

<body class="biolife-body">
    <!-- Preloader -->
    <?php include_once("includes/preloader.php"); ?>

    <!-- HEADER -->
    <header id="header" class="header-area style-01 layout-03">
        <?php include_once("includes/header_top.php"); ?>
        <?php include_once("includes/header_middle.php"); ?>
        <?php include_once("includes/header_bottom.php"); ?>
    </header>

    <!-- Page Contain -->
    <div class="page-contain">
        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <h2 class="text-center">Password Recovery</h2>

                <h4 class="text-danger">
                    <?php if (isset($rec_msg)) { echo $rec_msg; } ?>
                </h4>

                <div class="row">
                    <!--Form Sign In-->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="signin-container">
                            <form action="" name="frm-login" method="post">
                                <p class="form-row">
                                    <label for="email">Email</label>
                                    <input type="email" id="fid-name" name="recover_email" class="txt-input" required>
                                </p>
                                <p class="wrap-btn">
                                    <input type="submit" value="Recover Password" name="u_pass_recover" class="btn btn-success">
                                </p>
                            </form>
                        </div>
                    </div>

                    <!--Go to Register form-->
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

    <!-- FOOTER -->
    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/mobile_footer.php"); ?>
    <?php include_once("includes/mobile_global.php"); ?>

    <!-- Scroll Top Button -->
    <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a>

    <?php include_once("includes/script.php"); ?>
</body>
</html>
