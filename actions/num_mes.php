<?php
session_start();
$login = $_SESSION['login'];
$id = $_SESSION['id'];

require_once "/db/messages_db.php";

$num = 0;

$numSql = "SELECT * FROM $login ORDER BY last_mes DESC";
$numRes = mysqli_query($linkm, $numSql) or die("Ошибка " . mysqli_error($linkm));  
while ($numRow = mysqli_fetch_array($numRes)) {
    $chat = $numRow['chat'];  
    $numSqli = "SELECT * FROM $chat WHERE id_user != $id ORDER BY id DESC LIMIT 1";   
    $numResi = mysqli_query($linkm, $numSqli) or die("Ошибка " . mysqli_error($linkm));  
    $numRowi = mysqli_fetch_array($numResi);
    if ($numRowi['read'] == 0 && !empty($numRowi)){
        $num++;
    }
}
if ($num != 0) 
    echo "<small><span class='badge-pill badge-primary' style='margin-top: 6px; margin-left: 5px; position: absolute';>".$num."</span></small>";

?>
      