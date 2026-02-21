<?php
include_once("admin/class/adminback.php");
$obj = new adminback();

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = mysqli_real_escape_string($obj->connection, $_GET['email']);
    $token = mysqli_real_escape_string($obj->connection, $_GET['token']);

    $check = "SELECT * FROM users WHERE user_email='$email' AND v_token='$token' LIMIT 1";
    $result = mysqli_query($obj->connection, $check);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // --- TIME CHECK START ---
        $registered_time = strtotime($user['v_created_at']);
        $current_time = time();
        $diff_in_seconds = $current_time - $registered_time;

        if ($diff_in_seconds > 30) { 
            // NEW LOGIC: If expired, delete the unverified user so they must register again
            $delete_query = "DELETE FROM users WHERE user_email='$email' AND v_status=0";
            mysqli_query($obj->connection, $delete_query);

            echo "<script>alert('Link expired (30 sec limit). Your registration has been cleared. Please register again.'); window.location.href='user_register.php';</script>";
            exit();
        }
        // --- TIME CHECK END ---

        // 3. Successful Verification
        $update = "UPDATE users SET v_status=1, v_token=NULL WHERE user_email='$email'";
        if (mysqli_query($obj->connection, $update)) {
            echo "<script>alert('Verification Successful! You can now login.'); window.location.href='user_login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid or already used verification link.'); window.location.href='user_login.php';</script>";
    }
} else {
    header("location:user_login.php");
}
?>