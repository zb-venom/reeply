<?php
session_start();

require_once "db/db.php";
require_once "salt.php";

$login = $_SESSION['login'];
$passwordOld = $_POST['passOld'];
$password = $_POST['passInput'];
$password2 = $_POST['passInput2'];

if (empty($password) || empty($password2) || empty($passwordOld)) {
    header('Location: /settings.php?error=11 ');  
                    exit();
}

if ($password != $password2) {
    header('Location: /settings.php?error=22 ');  
                    exit();
}

if ($password == $passwordOld) {
    header('Location: /settings.php?error=33 ');  
                    exit();
}


$query = 'SELECT * FROM users WHERE login="'.$login.'"';
$result = mysqli_query($link, $query);
$myrow = mysqli_fetch_array($result);
if ($myrow['pass']==md5(md5($myrow['salt']).md5($passwordOld))) {
    $salt = generateSalt();
    $pass = md5(md5($salt).md5($password));
    $sql = "UPDATE users SET pass='$pass', salt='$salt' WHERE login='".$login."'";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));

    header('Location: /settings.php?error=200 ');  
                    exit();
} else {
    
    header('Location: /settings.php?error=44 ');  
                    exit();
}
