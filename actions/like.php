<?php

session_start();

require_once "db/db.php";
require_once "db/posts_db.php";


$post_id = $_POST['post_id'];
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM rating WHERE post_id=$post_id AND user_id=$user_id";
$result = mysqli_query($linkp, $sql);
$row = mysqli_num_rows($result);
if ($row == 0) {
    $sql = "INSERT INTO rating (status, post_id, user_id) VALUES (1, $post_id, $user_id)";
    mysqli_query($linkp, $sql);
} elseif ($row == 1) {
    $sql = "SELECT * FROM rating WHERE post_id=$post_id AND status <> 1 AND user_id=$user_id";
    $result = mysqli_query($linkp, $sql);
    $row = mysqli_num_rows($result);
    if ($row == 1) {
        $sql = "UPDATE rating SET status=1 WHERE post_id=$post_id AND user_id=$user_id";
        mysqli_query($linkp, $sql);
    } elseif ($row == 0) {
        $sql = "UPDATE rating SET status=0 WHERE post_id=$post_id AND user_id=$user_id";
        mysqli_query($linkp, $sql);
    }
    
} 
?>