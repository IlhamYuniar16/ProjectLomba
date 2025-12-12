<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
include '../db/db.php';

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = '$token' LIMIT 1";
    $verify_query_run = mysqli_query($db, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if($row['verify_status'] == "0") {
            $clicked_token = $row['verify_token'];
            $update_token_status = "UPDATE users SET verify_status = '1' WHERE verify_token = '$clicked_token' LIMIT 1";
            $update_token_status_run = mysqli_query($db, $update_token_status);

            if($update_token_status_run) {
                $_SESSION['status'] = "Your account has been verified!";
                header("Location: http://localhost:5173/masuk");
            } else {
                $_SESSION['status'] = "Verification failed!";
                header("Location: http://localhost:5173/masuk");
            }
        } else {
            $_SESSION['status'] = "Email Already Verified. Please masuk";
            header("Location: http://localhost:5173/masuk");
            exit();
        }
    } else {
        $_SESSION['status'] = "This Token does not exist";
        header("Location: http://localhost:5173/masuk");
        exit();
    } 
} else {
        $_SESSION['status'] = "Not Allowed";
        header("Location: http://localhost:5173/masuk");
    }
?>