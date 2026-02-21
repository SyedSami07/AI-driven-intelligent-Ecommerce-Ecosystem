<?php
session_start();
include("class/adminback.php");
$obj = new adminback();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$rec_msg = "";

if (isset($_POST['admin_recover'])) {

    $recover_email = trim($_POST['recover_email']);
    $rec_row = $obj->admin_password_recover($recover_email);

    if ($rec_row && mysqli_num_rows($rec_row) > 0) {

        $rec_result = mysqli_fetch_assoc($rec_row);
        $rec_id    = $rec_result['admin_id'];
        $rec_email = $rec_result['admin_email'];

        // ✅ correct reset link
        $reset_link = "http://localhost/fruid/admin/admin_password_update.php?status=update&id={$rec_id}";

        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = ''; // Your Gmail
            $mail->Password   = ''; // 🔐 Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Email
            $mail->setFrom('', 'Fruid');
            $mail->addAddress($rec_email);

            $mail->isHTML(true);
            $mail->Subject = 'Admin Password Recovery | Fruid';
            $mail->Body    = "
                <p>Dear Admin,</p>
                <p>Please click the link below to reset your password:</p>
                <p><a href='{$reset_link}'>{$reset_link}</a></p>
                <p>If you did not request this, please ignore this email.</p>
                <p>Thank you</p>
            ";

            $mail->send();
            $rec_msg = "Please check your email to reset your password.";

        } catch (Exception $e) {
            $rec_msg = "Email sending failed: " . $mail->ErrorInfo;
        }

    } else {
        $rec_msg = "No admin account found with this email.";
    }
}
?>

<?php include("includes/head.php"); ?>

<body>
<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="login-card card-block auth-body mr-auto ml-auto">
                    <form method="post" class="md-float-material">
                        <div class="auth-box">
                            <h3 class="text-left txt-primary">Recover Password</h3>

                            <p style="color:black;">
                                <?php if (!empty($rec_msg)) echo $rec_msg; ?>
                            </p>

                            <hr><br>

                            <div class="input-group">
                                <input type="email"
                                       class="form-control"
                                       placeholder="Admin Email Address"
                                       name="recover_email"
                                       required>
                            </div>

                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <input type="submit"
                                           name="admin_recover"
                                           class="btn btn-primary btn-md btn-block"
                                           value="Recover Password">
                                </div>
                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12">
                                    <a href="index.php"
                                       class="btn btn-success btn-md btn-block">
                                        Go to Sign In
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("includes/script.php"); ?>
