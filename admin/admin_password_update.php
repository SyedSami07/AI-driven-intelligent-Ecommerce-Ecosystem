<?php
session_start();
include("class/adminback.php");
$obj = new adminback();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['status']) || $_GET['status'] !== 'update' || !isset($_GET['id'])) {
    die("Invalid password recovery link.");
}

$u_admin_id = intval($_GET['id']);
$update_msg = "";

if (isset($_POST['u_admin_btn'])) {

    if (strlen($_POST['admin_update_password']) < 6) {
        $update_msg = "Password must be at least 6 characters.";
    } else {
        $update_msg = $obj->update_admin_password($_POST);
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
                    <form method="post">
                        <div class="auth-box">
                            <h3 class="text-left txt-primary">Update Admin Password</h3>

                            <p style="color:black;"><?php echo $update_msg; ?></p>
                            <hr><br>

                            <div class="input-group">
                                <input type="password" name="admin_update_password"
                                       class="form-control"
                                       placeholder="New Password" required>
                            </div>

                            <input type="hidden" name="admin_update_id"
                                   value="<?php echo $u_admin_id; ?>">

                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <input type="submit" name="u_admin_btn"
                                           class="btn btn-primary btn-md btn-block"
                                           value="Update Password">
                                </div>
                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12">
                                    <a href="index.php" class="btn btn-success btn-md btn-block">
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
